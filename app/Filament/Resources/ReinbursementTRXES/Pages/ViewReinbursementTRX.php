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
                    strtolower(Auth::user()?->roles?->first()?->name ?? '') === 'super_admin'
                    || (
                        strtolower(Auth::user()?->roles?->first()?->name ?? '') === 'finance'
                        && ($record->status_id ?? null) == 8
                    )
                    || !in_array(strtolower(Auth::user()?->roles?->first()?->name ?? ''), ['finance', 'super_admin'])
                ),
        ];
    }
}
