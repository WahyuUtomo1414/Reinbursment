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
                ->description('Employe')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Reimbursements', $reinbursementCount)
                ->description('Reimbursement')
                ->descriptionIcon('heroicon-m-document-currency-dollar')
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Amount', $formattedTotal)
                ->color('info')
                ->description('For Total Reimbursement')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}
