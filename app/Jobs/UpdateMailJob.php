<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\UpdateMail;

class UpdateMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

     protected $mailData;
    protected $address;
    protected $id;
    protected $defaultUrl;

    public function __construct($mailData, $address, $id, $defaultUrl)
    {
        $this->mailData = $mailData;
        $this->address = $address;
        $this->id = $id;
        $this->defaultUrl = $defaultUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->address)->send(new UpdateMail($this->mailData, $this->id, $this->defaultUrl));
    }
}
