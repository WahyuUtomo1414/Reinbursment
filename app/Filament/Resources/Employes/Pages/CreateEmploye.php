<?php

namespace App\Filament\Resources\Employes\Pages;

use App\Models\User;
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

        // Cek apakah sudah punya user
        if (!$employe->user) {
            $plainPassword = Str::random(10);

            $user = User::create([
                'name' => $employe->name,
                'email' => $employe->email,
                'password' => $plainPassword,
                'id_employe' => $employe->id,
            ]);

            // Assign role default (optional)
            $user->assignRole('employee');

            // Kirim email kredensial
            Mail::to($employe->email)->queue(
                new \App\Mail\SendUserCredentialMail($user, $plainPassword)
            );
        }
    }
}
