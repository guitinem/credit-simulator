<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

use App\Helpers\Sanitize;

class LoanSimulation extends Mailable
{
    use Queueable, SerializesModels;

    public $loanSimulation;
    /**
     * Create a new message instance.
     */
    public function __construct($loanSimulation)
    {
        $this->loanSimulation = [
            'monthly_installment' => Sanitize::formatCurrencyBRL($loanSimulation['monthly_installment']),
            'total_amount_to_be_paid' => Sanitize::formatCurrencyBRL($loanSimulation['total_amount_to_be_paid']),
            'total_interest_paid' => Sanitize::formatCurrencyBRL($loanSimulation['total_interest_paid']),
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('guizstinem@gmail.com', 'Simulador INC'),
            subject: 'Sua simulção de crédito chegou!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.loanSimulation',
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
