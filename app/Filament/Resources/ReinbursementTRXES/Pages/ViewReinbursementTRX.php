<?php

namespace App\Filament\Resources\ReinbursementTRXES\Pages;

use Filament\Actions\EditAction;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ReinbursementTRXES\ReinbursementTRXResource;

class ViewReinbursementTRX extends ViewRecord
{
    protected static string $resource = ReinbursementTRXResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(fn ($record) => 
                    !in_array(Auth::user()?->roles?->first()?->name ?? '', ['employee']) 
                    && $record->status_id === 8
                ),
        ];
    }
}
