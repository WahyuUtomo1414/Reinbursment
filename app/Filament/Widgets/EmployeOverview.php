<?php

namespace App\Filament\Widgets;

use App\Models\Employe;
use App\Models\ReinbursementTRX;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class EmployeOverview extends StatsOverviewWidget
{
    use HasWidgetShield;
    
    protected function getStats(): array
    {
        $user = Auth::user();

        if (!$user) {
            return [
                Stat::make('No Data', 'User not authenticated'),
            ];
        }

        // Get data Reimbursement berdasarkan created_by user login
        $lastReimbursement = ReinbursementTRX::where('created_by', $user->id)
            ->latest('created_at')
            ->first();

        $lastStatus = $lastReimbursement?->status->name ?? 'No Reimbursement Yet';
        $statusDate = $lastReimbursement?->created_at?->format('d M Y') ?? '-';

        $reimbursementCount = ReinbursementTRX::where('created_by', $user->id)->count();

        $reimbursementTotal = ReinbursementTRX::where('created_by', $user->id)->sum('total_amount');

        $formattedTotal = 'Rp. ' . number_format($reimbursementTotal, 0, ',', '.');

        return [
            Stat::make('Last Reimbursement Status', ucfirst($lastStatus))
                ->description("Last updated on {$statusDate}")
                ->color($this->getStatusColor($lastStatus))
                ->icon('heroicon-m-information-circle'),

            Stat::make('Total Reimbursements', $reimbursementCount)
                ->description('Total reimbursements you created')
                ->color('info')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Amount', $formattedTotal)
                ->description('Sum of all reimbursements you submitted')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }

    /**
     * Fungsi bantu untuk menentukan warna berdasarkan status.
     */
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
