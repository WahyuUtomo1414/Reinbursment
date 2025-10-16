<?php

namespace App\Filament\Resources\ReinbursementTRXES\Pages;

use App\Filament\Resources\ReinbursementTRXES\ReinbursementTRXResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReinbursementTRX extends CreateRecord
{
    protected static string $resource = ReinbursementTRXResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!isset($data['status_id'])) {
            $data['status_id'] = 7; // force default
        }

        return $data;
    }
}
