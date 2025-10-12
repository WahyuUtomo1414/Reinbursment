<?php

namespace App\Filament\Resources\ReinbursementTRXES\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Exports\ReinbursementTRXExporter;
use App\Filament\Resources\ReinbursementTRXES\ReinbursementTRXResource;

class ListReinbursementTRXES extends ListRecords
{
    protected static string $resource = ReinbursementTRXResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Created Reinbursement'),
            ExportAction::make()
                ->label('Export Data')
                ->exporter(ReinbursementTRXExporter::class)
                ->columnMapping(false)
                ->color('info')
                ->visible(fn (): bool => 
                    in_array(
                        strtolower(Auth::user()?->roles?->first()?->name ?? ''), 
                        ['super_admin']
                    )
                ),
        ];
    }
}
