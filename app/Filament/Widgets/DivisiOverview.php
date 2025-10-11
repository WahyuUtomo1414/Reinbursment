<?php

namespace App\Filament\Widgets;

use App\Models\Employe;
use App\Models\ReinbursementTRX;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class DivisiOverview extends StatsOverviewWidget
{
    use HasWidgetShield;
    
    protected function getStats(): array
    {
        $user = Auth::user();

        // cek relasi employe
        if (!$user || !$user->id_employe) {
            return [
                Stat::make('No Data', 'User not linked to employe'),
            ];
        }
        
        // get division id
        $employe = Employe::find($user->id_employe);
        $divisionId = $employe?->id_division;

        if (!$divisionId) {
            return [
                Stat::make('No Division', 'Division not found'),
            ];
        }

        // 🔹 Ambil data employe & reinbursement yang 1 divisi
        $employeCount = Employe::where('id_division', $divisionId)->count();

        $reinbursementCount = ReinbursementTRX::whereHas('employe', function ($query) use ($divisionId) {
            $query->where('id_division', $divisionId);
        })->count();

        $reinbursementTotal = ReinbursementTRX::whereHas('employe', function ($query) use ($divisionId) {
            $query->where('id_division', $divisionId);
        })->sum('total_amount');

        $formattedTotal = 'Rp. ' . number_format($reinbursementTotal, 0, ',', '.');

        return [
            Stat::make('Employees', $employeCount)
                ->description('↑ 32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([3, 4, 6, 8, 12, 14, 18, 20, 24]),

            Stat::make('Reimbursements', $reinbursementCount)
                ->description('↓ 7% decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->chart([10, 9, 8, 7, 6, 5, 4, 4, 3]),

            Stat::make('Total Amount', $formattedTotal)
                ->description('↑ 3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([10, 12, 13, 15, 16, 18, 19, 20, 23]),
        ];
    }
}
