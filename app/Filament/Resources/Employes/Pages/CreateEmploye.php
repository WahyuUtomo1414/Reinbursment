<?php

namespace App\Filament\Resources\Employes\Pages;

use App\Mail\SendUserCredentialMail;
use Illuminate\Support\Facades\Mail;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Notification;
use App\Filament\Resources\Employes\EmployeResource;

class CreateEmploye extends CreateRecord
{
    protected static string $resource = EmployeResource::class;

    protected ?string $plainPassword = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $plainPassword = $data['user']['password'] ?? null;

        if ($plainPassword) {
            $data['user']['password_plain'] = $plainPassword;
        }

        return $data;
    }
}
