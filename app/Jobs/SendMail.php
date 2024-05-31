<?php

namespace App\Jobs;

use App\Mail\OrderShipped;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $customer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $customer)
    {
        $this->email = $email;
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Truyền email vào OrderShipped mà không cần truyền dữ liệu khách hàng
        Mail::to($this->email)->send(new OrderShipped($this->email, $this->customer));
    }
}