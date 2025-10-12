<?php

namespace App\Filament\Resources\ReinbursementTRXES\Pages;

use App\Filament\Resources\ReinbursementTRXES\ReinbursementTRXResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReinbursementTRX extends ViewRecord
{
    protected static string $resource = ReinbursementTRXResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(fn ($record) => $record->status_id !== 8),
        ];
    }
}
