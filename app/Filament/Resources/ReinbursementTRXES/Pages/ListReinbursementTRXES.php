<?php

namespace App\Filament\Resources\ReinbursementTRXES\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Exports\ReinbursementTRXExporter;
use App\Filament\Resources\ReinbursementTRXES\ReinbursementTRXResource;

class ListReinbursementTRXES extends ListRecords
{
    protected static string $resource = ReinbursementTRXResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExportAction::make()
                ->exporter(ReinbursementTRXExporter::class)
                ->columnMapping(false),
        ];
    }
}
