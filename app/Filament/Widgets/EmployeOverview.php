<?php

namespace App\Filament\Widgets;

use App\Models\Employe;
use Illuminate\Support\Carbon;
use App\Models\ReinbursementTRX;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class EmployeOverview extends StatsOverviewWidget
{
    use HasWidgetShield;
    
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = Auth::user();

        if (!$user) {
            return [
                Stat::make('No Data', 'User not authenticated'),
            ];
        }

        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;
        $statusId = $this->pageFilters['status_id'] ?? null;

        $query = ReinbursementTRX::query()
            ->where('created_by', $user->id)
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', Carbon::parse($startDate)))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', Carbon::parse($endDate)))
            ->when($statusId, fn($q) => $q->where('status_id', $statusId));

        $lastReimbursement = $query->latest('created_at')->first();
        $lastStatus = $lastReimbursement?->status?->name ?? 'No Reimbursement Yet';
        $statusDate = $lastReimbursement?->created_at?->format('d M Y') ?? '-';

        $reimbursementCount = $query->count();
        $reimbursementTotal = $query->sum('total_amount');
        $formattedTotal = 'Rp. ' . number_format($reimbursementTotal, 0, ',', '.');

        return [
            Stat::make('Last Reimbursement Status', ucfirst($lastStatus))
                ->description("Last updated on {$statusDate}")
                ->color($this->getStatusColor($lastStatus))
                ->icon('heroicon-m-information-circle'),

            Stat::make('Total Reimbursements', $reimbursementCount)
                ->description('reimbursements')
                ->color('info')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Amount', $formattedTotal)
                ->description('Total reimbursements you submitted')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }

    private function getStatusColor(string $status): string
    {
        return match (strtolower($status)) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'gray',
        };
    }
}
