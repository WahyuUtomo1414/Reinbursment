<?php

namespace App\Filament\Resources\Employes\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use App\Mail\SendUserCredentialMail;
use Illuminate\Support\Facades\Mail;
use Filament\Actions\ForceDeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Notification;
use App\Filament\Resources\Employes\EmployeResource;

class EditEmploye extends EditRecord
{
    protected static string $resource = EmployeResource::class;

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
