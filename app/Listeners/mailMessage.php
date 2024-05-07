<?php

namespace App\Listeners;

use App\Events\sendNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class mailMessage implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(sendNotification $event): void
    {
        Mail::to($event->mailto)->send(new \App\Mail\SendMailer($event->name, $event->mailto, $event->type, $event->ticket));
    }
}
