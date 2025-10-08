<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class AdminOverview extends StatsOverviewWidget
{
    use HasWidgetShield;
    
    protected function getStats(): array
    {
        return [
            Stat::make('Employees', '24')
                ->description('↑ 32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([3, 4, 6, 8, 12, 14, 18, 20, 24]),

            Stat::make('Reimbursements', '34')
                ->description('↓ 7% decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->chart([10, 9, 8, 7, 6, 5, 4, 4, 3]),

            Stat::make('Total Amount', 'Rp 23.000.000')
                ->description('↑ 3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([10, 12, 13, 15, 16, 18, 19, 20, 23]),
        ];
    }
}
