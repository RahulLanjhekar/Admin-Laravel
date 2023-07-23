<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\NewMail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $mailData;
    protected $address;

    public function __construct($mailData, $address)
    {
        $this->mailData = $mailData;
        $this->address = $address;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->address)->send(new NewMail($this->mailData));
    }
}
