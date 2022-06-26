<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmOrderEmail extends Mailable
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
        $subject = 'Your UEE.com order #'.$this->OrderData['order_id'].' has been placed';
        return $this->subject($subject)->view('emails.confirmOrderEmail')->with('orderData',$this->OrderData);
    }
}
