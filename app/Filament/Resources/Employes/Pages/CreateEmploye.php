<?php

namespace App\Filament\Resources\Employes\Pages;

use App\Models\Employe;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Mail\SendUserCredentialMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Notification;
use App\Filament\Resources\Employes\EmployeResource;

class CreateEmploye extends CreateRecord
{
    protected static string $resource = EmployeResource::class;

    protected function afterCreate(): void
    {
        $employe = $this->record;
        $user = $employe->user;

        if ($user) {
            $plainPassword = Str::random(10);

            $user->update([
                'password' => bcrypt($plainPassword),
            ]);

            Mail::to($user->email)->send(
                new SendUserCredentialMail(
                    $user,
                    $plainPassword
                )
            );
        }
    }
}
