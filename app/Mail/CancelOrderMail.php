<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelOrderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $OrderData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($OrderData)
    {
        $this->OrderData = $OrderData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $Subject = 'Your order has been cancelled';

        return $this->subject($Subject)->view('emails.cancelOrder')->with('OrderData', $this->OrderData);
    }
}
