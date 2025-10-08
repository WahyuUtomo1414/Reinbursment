<?php

namespace App\Filament\Resources\ReinbursementTRXES\Pages;

use App\Filament\Resources\ReinbursementTRXES\ReinbursementTRXResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditReinbursementTRX extends EditRecord
{
    protected static string $resource = ReinbursementTRXResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
