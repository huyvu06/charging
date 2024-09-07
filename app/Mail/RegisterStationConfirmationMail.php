<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterStationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $station;

    public function __construct($station)
    {
        $this->station = $station;

        
    }

    // public function build()
    // {
    //     $url = route('accept.station.registration', ['token' => $this->station->confirmation_token]);

    //     return $this->markdown('emails.station_confirmation')
    //                 ->with([
    //                     'acceptUrl' => $url,
    //                     'station' => $this->station,
    //                 ]);
    // }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Register Station Confirmation Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.station_confirmation',
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
