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

    protected ?string $plainPassword = null;
    protected ?string $originalEmail = null;

    /**
     * Simpan nilai awal user (untuk bandingkan nanti)
     */
    protected function beforeFill(): void
    {
        $employe = $this->record;

        if ($employe->user) {
            $this->originalEmail = $employe->user->email;
        }
    }

    /**
     * Tangkap password plain kalau diubah
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->plainPassword = $data['user']['password'] ?? null;
        return $data;
    }

    /**
     * Kirim email setelah disimpan jika email/password diubah
     */
    protected function afterSave(): void
    {
        $employe = $this->record;
        $user = $employe->user;

        if (! $user) {
            return;
        }

        $emailChanged = $this->originalEmail && $user->email !== $this->originalEmail;
        $passwordChanged = !empty($this->plainPassword);

        if ($emailChanged || $passwordChanged) {
            Mail::to($user->email)
                ->send(new SendUserCredentialMail($user, $this->plainPassword ?: '[unchanged]'));

            Notification::make()
                ->title('User Updated')
                ->body('Login credentials have been resent to ' . $user->email)
                ->success()
                ->send();
        }
    }
}
