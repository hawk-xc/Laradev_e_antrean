<?php

namespace App\Livewire;

use Livewire\Component;
use \App\Models\{
    Ticket,
    Notification,
    Device,
    User
};

class Chatter extends Component
{
    public $usrId;

    public function selectMessage(int $id)
    {
        $this->usrId = $id;
    }

    public function render()
    {
        // $notifications = Notification::orderBy('created_at', 'desc')->distinct()->get();
        $notifications = User::whereIn('id', Notification::pluck('user_id'))->get();
        $tickets = Ticket::all();
        $selectedMessage = Notification::where('user_id', $this->usrId)->orderBy('created_at', 'asc')->get();

        return view('livewire.chatter', compact(['notifications', 'tickets', 'selectedMessage']));
    }
}
