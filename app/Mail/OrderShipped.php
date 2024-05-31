<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $customer)
    {
        $this->email = $email;
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Sử dụng email đã truyền để gửi
        return $this->to($this->email, $this->customer)
                    ->view('mail.success');
    }
}

