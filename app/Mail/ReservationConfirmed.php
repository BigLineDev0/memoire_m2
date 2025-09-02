<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation->load(['user','laboratoire','equipements','horaires']);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Confirmation de votre réservation')
            ->view('emails.reservation-confirmed')
            ->with([
                'reservation' => $this->reservation,
            ]);
    }
}
