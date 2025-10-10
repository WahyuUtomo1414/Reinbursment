<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendUserCredentialMail extends Mailable
{
        use Queueable, SerializesModels;

    public $user;
    public $plainPassword;

    /**
     * Buat instance baru.
     */
    public function __construct($user, $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    /**
     * Definisi envelope (judul email, dll)
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Account Login Information',
        );
    }

    /**
     * Definisi konten email
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.user_credentials',
            with: [
                'user' => $this->user,
                'plainPassword' => $this->plainPassword,
            ],
        );
    }

    /**
     * Attachment (optional)
     */
    public function attachments(): array
    {
        return [];
    }
}
