<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\DeleteMail;

class DeleteMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

     protected $title;
     protected $address;
     
    public function __construct($title, $address)
    {
        $this->title = $title;
        $this->address = $address;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->address)->send(new DeleteMail($this->title));
    }
}
