<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendingOrdersNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $pendingOrder;
    public $totalPending;
    public $totalRevenue;
    /**
     * Create a new message instance.
     */
    public function __construct(
        $pendingOrder,
        $totalRevenue,
        $totalPending
    ) {
        $this->pendingOrder = $pendingOrder;
        $this->totalRevenue = $totalRevenue;
        $this->totalPending = $totalPending;
    }

    public function build()
    {
        return $this->subject('Pending Order Notification')
            ->view('emails.pending-order')
            ->with([
                $this->pendingOrder,
                $this->totalPending,
                $this->totalRevenue
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pending Orders Notification',
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
