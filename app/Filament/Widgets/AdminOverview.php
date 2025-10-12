<?php

namespace App\Filament\Widgets;

use App\Models\Employe;
use App\Models\ReinbursementTRX;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class AdminOverview extends StatsOverviewWidget
{
    use HasWidgetShield;

    protected function getStats(): array
    {
        $employe = Employe::count();
        $reinburmentPending = ReinbursementTRX::where('status_id', 7)->count();
        $reinburment = ReinbursementTRX::count();
        $reinbursementTotal = ReinbursementTRX::sum('total_amount');

        $formattedTotal = 'Rp. ' . number_format($reinbursementTotal, 0, ',', '.');

        return [
            Stat::make('Total Employe', $employe)
                ->description('Employe')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Reimbursements', $reinburment)
                ->description('Reimbursement')
                ->descriptionIcon('heroicon-m-document-currency-dollar')
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            
            Stat::make('Reimbursements Pending', $reinburmentPending)
                ->description('Reimbursement')
                ->descriptionIcon('heroicon-m-document-currency-dollar')
                ->color('danger')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Amount', $formattedTotal)
                ->color('info')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}
