<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThankYouEmail;

class SendThankYouEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $feedback;


    /**
     * Create a new job instance.
     *
     * @param string $email
     * @return void
     */
    public function __construct($feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $feedback = $this->feedback;
        Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
            $message->to($feedback->email)
                ->subject('Cảm ơn bạn đã phản hồi');
        });
    }
}
