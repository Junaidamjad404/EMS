<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\TicketPurchase;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketPurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    
    public $purchase;
    public $user; // Add user property

    /**
     * Create a new message instance.
     */
    public function __construct(TicketPurchase $purchase)
    {
        $this->purchase = $purchase;
        $this->user = $purchase->user; // Get user from purchase
        Log::info('Ticket Purchase Confirmation Mailable:', [
            'user' => $this->user,
            'purchase' => $this->purchase
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Purchase Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket_purchase_confirmation',
            // Pass the user and purchase variables to the view
            with: [
                'user' => $this->user,
                'purchase' => $this->purchase,
            ]
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
