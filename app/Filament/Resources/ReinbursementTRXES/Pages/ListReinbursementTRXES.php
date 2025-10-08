<?php

namespace App\Filament\Resources\ReinbursementTRXES\Pages;

use App\Filament\Resources\ReinbursementTRXES\ReinbursementTRXResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReinbursementTRXES extends ListRecords
{
    protected static string $resource = ReinbursementTRXResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
