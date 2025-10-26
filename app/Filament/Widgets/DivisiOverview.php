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

class DivisiOverview extends StatsOverviewWidget
{
    use HasWidgetShield;
    
    use InteractsWithPageFilters;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $user = Auth::user();

        // 🔹 1. Cek apakah user terhubung ke employe
        if (!$user || !$user->id_employe) {
            return [
                Stat::make('No Data', 'User not linked to employe'),
            ];
        }

        // 🔹 2. Ambil division ID dari employe
        $employe = Employe::find($user->id_employe);
        $divisionId = $employe?->id_division;

        if (!$divisionId) {
            return [
                Stat::make('No Division', 'Division not found'),
            ];
        }

        // 🔹 3. Ambil nilai filter dari page (kalau ada)
        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;
        $statusId = $this->pageFilters['status_id'] ?? null;

        // 🔹 4. Query base untuk Reimbursement berdasarkan division
        $reimbursementQuery = ReinbursementTRX::whereHas('employe', function ($query) use ($divisionId) {
            $query->where('id_division', $divisionId);
        })
        ->when($startDate, fn ($q) => $q->whereDate('created_at', '>=', Carbon::parse($startDate)))
        ->when($endDate, fn ($q) => $q->whereDate('created_at', '<=', Carbon::parse($endDate)))
        ->when($statusId, fn ($q) => $q->where('status_id', $statusId));

        // 🔹 5. Hitung data
        $employeCount = Employe::where('id_division', $divisionId)->count();
        $reimbursementCount = $reimbursementQuery->count();
        $totalAmount = $reimbursementQuery->sum('total_amount');
        $formattedTotal = 'Rp. ' . number_format($totalAmount, 0, ',', '.');

        // 🔹 6. Return ke widget Filament
        return [
            Stat::make('Employees', $employeCount)
                ->description('Employee in this Division')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Reimbursements', $reimbursementCount)
                ->description('Filtered Reimbursement Data')
                ->descriptionIcon('heroicon-m-document-currency-dollar')
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Amount', $formattedTotal)
                ->description('Filtered Total Amount')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}
