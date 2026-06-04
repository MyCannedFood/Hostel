<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $guest;

    public function __construct($booking, $guest)
    {
        $this->booking = $booking;
        $this->guest = $guest;
    }

    public function build()
    {
        return $this->subject('Proof of Payment - AlaSare Hostel')
                    ->view('emails.booking_receipt');
    }
}