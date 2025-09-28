<?php

namespace App\Filament\Resources\StatusTypes\Pages;

use App\Filament\Resources\StatusTypes\StatusTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditStatusType extends EditRecord
{
    protected static string $resource = StatusTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
