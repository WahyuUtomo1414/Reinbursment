<?php

namespace App\Filament\Widgets;

use App\Models\Employe;
use Illuminate\Support\Carbon;
use App\Models\ReinbursementTRX;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class AdminOverview extends StatsOverviewWidget
{
    use HasWidgetShield;

    use InteractsWithPageFilters;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        // Ambil nilai dari filter yang didefinisikan di Dashboard
        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;
        $statusId = $this->pageFilters['status_id'] ?? null;

        // Buat query dinamis
        $query = ReinbursementTRX::query()
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', Carbon::parse($startDate)))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', Carbon::parse($endDate)))
            ->when($statusId, fn($q) => $q->where('status_id', $statusId));

        // Ambil data hasil filter
        $totalReimbursement = $query->count();
        $totalPending = ReinbursementTRX::where('status_id', 7)->count();
        $totalAmount = $query->sum('total_amount');
        $totalEmploye = \App\Models\Employe::count();

        $formattedAmount = 'Rp. ' . number_format($totalAmount, 0, ',', '.');

        return [
            Stat::make('Total Employee', $totalEmploye)
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Reimbursements', $totalReimbursement)
                ->descriptionIcon('heroicon-m-document-currency-dollar')
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Amount', $formattedAmount)
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }

    protected int|string|array $columnSpan = 3;

    protected function getColumns(): int
    {
        return 3;
    }
}
