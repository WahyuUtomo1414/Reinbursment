<?php

namespace App\Filament\Widgets;

use App\Models\Employe;
use App\Models\ReinbursementTRX;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class DivisiOverview extends StatsOverviewWidget
{
    use HasWidgetShield;
    
    protected function getStats(): array
    {
        $employe = Employe::count();
        $reinburment = ReinbursementTRX::count();
        $reinbursementTotal = ReinbursementTRX::sum('total_amount');

        $formattedTotal = 'Rp. ' . number_format($reinbursementTotal, 0, ',', '.');

        return [
            Stat::make('Employees', $employe)
                ->description('↑ 32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([3, 4, 6, 8, 12, 14, 18, 20, 24]),

            Stat::make('Reimbursements', $reinburment)
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
