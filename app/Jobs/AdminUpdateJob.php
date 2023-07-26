<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\AdminUpdateMail;

class AdminUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $emails;
    protected $id;
    protected $defaultUrl;

    public function __construct($emails, $id, $defaultUrl)
    {
        $this->emails = $emails;
        $this->id = $id;
        $this->defaultUrl = $defaultUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->emails as $email){
            Mail::to($email)->send(new AdminUpdateMail($this->id, $this->defaultUrl));
        }
    }
}
