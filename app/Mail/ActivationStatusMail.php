<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActivationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    
    public $user;
    public $status;

    /**
     * Create a new message instance.
     *
     * @param mixed $user
     * @param string $status
     */
    public function __construct($user,$status)
    {
        $this->user = $user;
        $this->status = $status;

    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->status == 'activated' ? 'Account Activation' : 'Account Deactivation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        
        return new Content(
            view: 'emails.activation_status',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
