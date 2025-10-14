<?php

namespace App\Filament\Resources\ReinbursementTRXES\Widgets;

use App\Models\ReinbursementTRX;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Resources\ReinbursementTRXES\Pages\ListReinbursementTRXES;

class ReinbursementStatsOverview extends BaseWidget
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
        
        return [
            Stat::make('Jumlah Pengajuan', $tableQuery->count())
                ->description('Total data reinbursement yang tampil di tabel ini')
                ->icon('heroicon-o-clipboard-document'),

            Stat::make('Total Nominal', 'Rp ' . number_format($tableQuery->sum('total_amount'), 0, ',', '.'))
                ->description('Total nominal semua pengajuan yang sedang difilter')
                ->icon('heroicon-o-banknotes')
                ->color('info'),
        ];
    }
}