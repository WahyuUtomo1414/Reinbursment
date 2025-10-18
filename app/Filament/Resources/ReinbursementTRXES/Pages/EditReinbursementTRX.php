<?php

namespace App\Filament\Resources\ReinbursementTRXES\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\ForceDeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ReinbursementTRXES\ReinbursementTRXResource;

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

    //Method Untuk Handle Approve Otomatis
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['status_id'] ?? null) == 8) {
            $data['approve_by'] = Auth::user()->id_employe;
            $data['approve_at'] = now();
        }

        return $data;
    }
}
