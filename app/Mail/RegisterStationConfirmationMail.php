<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterStationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $station;
    public $confirmationUrl;

    public function __construct($station)
    {
        $this->station = $station;
        // Generate the URL with the confirmation token
        $this->confirmationUrl = url('/confirm-station/' . $station->confirmation_token);
    }

    public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Register Station Confirmation Mail'
        );
    }

    public function content(): \Illuminate\Mail\Mailables\Content
{
    return new \Illuminate\Mail\Mailables\Content(
        markdown: 'email.station_confirmation', 
        with: [
            'station' => $this->station,
            'confirmationUrl' => $this->confirmationUrl,
        ]
    );
}

    public function attachments(): array
    {
        return [];
    }
}
