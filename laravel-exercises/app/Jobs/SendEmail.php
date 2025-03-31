<?php

namespace App\Jobs;

use App\Mail\MailNotify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Queueable;
    private $users;
    private $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data, $users)
    {
        $this->$data = $data;
        $this->$users = $users;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->users)->send(new MailNotify($this->data));
    }
}