<?php

namespace App\Filament\Exports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use App\Models\ReinbursementTRX;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class ReinbursementTRXExporter extends Exporter
{
    protected static ?string $model = ReinbursementTRX::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('account.account_name')
                ->label('Account Name'),

            ExportColumn::make('account.provider')
                ->label('Bank / Provider'),

            ExportColumn::make('employe.name')
                ->label('Employee Name'),

            ExportColumn::make('total_amount')
                ->label('Total Amount (Rp)')
                ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

            ExportColumn::make('status.name')
                ->label('Status'),

            ExportColumn::make('note')
                ->label('Note'),

            ExportColumn::make('approve.name')
                ->label('Approved By'),

            ExportColumn::make('approve_at')
                ->label('Approved At')
                ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d/m/Y H:i') : '-'),

            ExportColumn::make('created_at')
                ->label('Created At')
                ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d/m/Y H:i') : '-'),

            ExportColumn::make('updated_at')
                ->label('Updated At')
                ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d/m/Y H:i') : '-'),

            ExportColumn::make('deleted_at')
                ->label('Deleted At')
                ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d/m/Y H:i') : '-'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your reinbursement t r x export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
