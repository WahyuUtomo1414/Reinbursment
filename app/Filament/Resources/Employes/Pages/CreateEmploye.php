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

    /**
     * Simpan password plain sebelum disimpan (karena di-hash)
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->plainPassword = $data['user']['password'] ?? null;
        return $data;
    }

    /**
     * Kirim email setelah record & relasi berhasil disimpan
     */
    protected function afterSave(): void
    {
        $employe = $this->record;

        if ($employe->user && $this->plainPassword) {
            Mail::to($employe->user->email)
                ->send(new SendUserCredentialMail($employe->user, $this->plainPassword));

            Notification::make()
                ->title('Employee Created')
                ->body('Login credentials have been sent to ' . $employe->user->email)
                ->success()
                ->send();
        }
    }
}
