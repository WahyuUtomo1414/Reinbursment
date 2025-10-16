<?php

namespace App\Filament\Resources\ReinbursementTRXES\ReinbursementTRXResource\Widgets;

use App\Models\Employe;
use App\Models\ReinbursementTRX;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use App\Filament\Resources\ReinbursementTRXES\Pages\ListReinbursementTRXES;

class ReinburmentOverview extends StatsOverviewWidget
{
    use InteractsWithPageTable;

    protected ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListReinbursementTRXES::class;
    }
    
    protected function getStats(): array
    {
        $tableQuery = $this->getPageTableQuery();

        $totalReimbursements = $tableQuery->count();
        $totalReimbursementsPaid = $tableQuery
            ->whereHas('paymentReinbursement', function ($query) {
                $query->where('status_id', 5);
            })
            ->count();
        $totalAmount = $tableQuery->sum('total_amount');

        return [
            Stat::make('Total Reimbursements', $totalReimbursements),

            Stat::make('Total Reimbursements Paid', $totalReimbursementsPaid),

            Stat::make('Total Amount', 'Rp ' . number_format($totalAmount, 0, ',', '.')),
        ];
    }
}
