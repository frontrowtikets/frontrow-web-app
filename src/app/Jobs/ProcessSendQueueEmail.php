<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessSendQueueEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $mail;
    protected $sendTo;
    public function __construct(Mailable $mail, $sendTo)
    {
        $this->mail = $mail;
        $this->$sendTo = $sendTo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->sendTo)->send($this->mail);
        } catch (\Throwable $th) {
            Log::error("Email Sending Failed: " . $th->getMessage() . $this->sendTo);
        }
    }
}
