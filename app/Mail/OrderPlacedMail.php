<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $order;
    public function __construct(array $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Your Order has been placed!')
            ->view('emails.order_placed');
    }
}
