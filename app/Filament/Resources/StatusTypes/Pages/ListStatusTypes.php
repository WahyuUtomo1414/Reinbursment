<?php

namespace App\Filament\Resources\StatusTypes\Pages;

use App\Filament\Resources\StatusTypes\StatusTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStatusTypes extends ListRecords
{
    protected static string $resource = StatusTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
