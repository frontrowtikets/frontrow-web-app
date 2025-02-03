<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Barryvdh\DomPDF\Facade\Pdf;

class EventTicketPurchaseMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    protected array $pdfContents = [];
    public $ticketDetails;
    public $clientName;
    public $amount;
    public $merchant_reference;
    public $confirmation_code;
    public $payment_method;
    public $paymentDate;

    public function __construct(
        $clientName,
        $amount,
        $merchant_reference,
        $confirmation_code,
        $payment_method,
        $paymentDate,
        $ticketDetails,
    )
    {
        $this->clientName          = $clientName;
        $this->amount              = $amount;
        $this->merchant_reference  = $merchant_reference;
        $this->confirmation_code   = $confirmation_code;
        $this->payment_method      = $payment_method;
        $this->paymentDate         = $paymentDate;
        $this->ticketDetails       = $ticketDetails;

        foreach ($ticketDetails as $index => $ticketData) {
            $pdfContent = Pdf::loadView('EventTicket', $ticketData)->output();
            $this->pdfContents[] = [
                'content'  => base64_encode($pdfContent),
                'filename' => 'ticket_' . ($index + 1) . '.pdf',
            ];
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.TicketPurchaseMail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->pdfContents as $pdf) {
            $attachments[] =
                Attachment::fromData(
                    fn() => base64_decode($pdf['content']),
                    $pdf['filename'],
                    'application/pdf'
                );
        }

        return $attachments;
    }
}
