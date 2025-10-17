<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Employe;
use Illuminate\Support\Str;
use App\Mail\SendUserCredentialMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmployeObserver
{
    // public function creating(Employe $employe): void
    // {
    //     if (!$employe->user_id) {
    //         $plainPassword = Str::random(10);

    //         $user = User::create([
    //             'name' => $employe->name,
    //             'email' => $employe->email,
    //             'password' => Hash::make($plainPassword),
    //         ]);

    //         $employe->user_id = $user->id;
    //         $employe->temp_password = $plainPassword; // simpan sementara
    //     }
    // }

    // /**
    //  * Handle the Employe "created" event.
    //  */
    // public function created(Employe $employe)
    // {
    //     $user = $employe->user;

    //     if ($user) {
    //         $plainPassword = Str::random(10);

    //         $user->update([
    //             'password' => bcrypt($plainPassword),
    //         ]);

    //         Mail::to($user->email)->send(
    //             new SendUserCredentialMail($user, $plainPassword)
    //         );
    //     }
    // }

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
