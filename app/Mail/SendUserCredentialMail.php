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
     * Create a new message instance.
     */
    public function __construct($user, $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    /**
     * Get the message envelope (subject, from, etc).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Account Login Information',
        );
    }

    /**
     * Get the message content (view + data).
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_credentials',
            with: [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'password' => $this->plainPassword,
            ],
        );
    }

    /**
     * Attachments (optional).
     */
    public function attachments(): array
    {
        return [];
    }
}
