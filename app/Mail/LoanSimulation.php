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
            'monthly_installment' => Sanitize::formatCurrency($loanSimulation['monthly_installment'], $loanSimulation['currency']),
            'total_amount_to_be_paid' => Sanitize::formatCurrency($loanSimulation['total_amount_to_be_paid'], $loanSimulation['currency']),
            'total_interest_paid' => Sanitize::formatCurrency($loanSimulation['total_interest_paid'], $loanSimulation['currency']),
            'original_loan_amount' => Sanitize::formatCurrency($loanSimulation['original_loan_amount'], 'BRL'),
            'currency' => $loanSimulation['currency']
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
