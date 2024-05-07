<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $mailto, public $name, public $type, public $ticket)
    {
        $this->mailto = $mailto;
        $this->name = $name;
        $this->type = $type;
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Mail::to($this->mailto)->send(new \App\Mail\SendMailer($this->name, $this->mailto, 'done', $this->ticket));
        event(new \App\Events\sendNotification($this->mailto, $this->name, $this->mailto, $this->type, $this->ticket));
    }
}
