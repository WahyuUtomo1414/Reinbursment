<?php

namespace App\Observers;

use Illuminate\Support\Facades\Log;
use App\Models\Employe;
use App\Mail\SendUserCredentialMail;
use Illuminate\Support\Facades\Mail;

class EmployeObserver
{
    /**
     * Handle the Employe "created" event.
     */
    public function created(Employe $employe): void
    {
        // Cek apakah employe punya relasi user
        if ($employe->user && $employe->user->password_plain ?? false) {
            try {
                Mail::to($employe->user->email)
                    ->send(new SendUserCredentialMail(
                        $employe->user,
                        $employe->user->password_plain
                    ));
            } catch (\Exception $e) {
                Log::error('Email send failed: ' . $e->getMessage());
            }
        }
    }

    /**
     * Handle the Employe "updated" event.
     */
    public function updated(Employe $employe): void
    {
        //
    }

    /**
     * Handle the Employe "deleted" event.
     */
    public function deleted(Employe $employe): void
    {
        //
    }

    /**
     * Handle the Employe "restored" event.
     */
    public function restored(Employe $employe): void
    {
        //
    }

    /**
     * Handle the Employe "force deleted" event.
     */
    public function forceDeleted(Employe $employe): void
    {
        //
    }
}
