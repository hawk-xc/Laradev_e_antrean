<?php

namespace App\Listeners;

use App\Events\UserInteraction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class Logger
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(UserInteraction $event): void
    {
        $data = date('Y-m-d H:i:s') . " -> user [{$event->user->name}] : {$event->message}";
        Storage::append('interact.log', $data);
    }
}
