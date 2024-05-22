<?php

namespace App\Listeners;

use App\Events\UserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotification
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
    public function handle(UserNotification $event): void
    {
        \App\Models\Notification::create([
            'user_id' => $event->user->id,
            'message' => $event->message,
            'client_side' => false
        ]);
    }
}
