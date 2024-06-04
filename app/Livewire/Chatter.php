<?php

namespace App\Livewire;

use Livewire\Component;
use \App\Models\{
    Ticket,
    Notification,
    Device,
    User
};

use Illuminate\Support\Facades\Auth;

use PHPUnit\Framework\TestStatus\Notice;

class Chatter extends Component
{
    public $usrId;
    public $Message;
    public $openTextEditor = false;

    public function sendMessage()
    {
        $validate = $this->validate([
            'Message' => 'required|min:3'
        ]);
        if ($validate) {
            $pesan = Notification::create([
                'user_id' => $this->usrId,
                'message' => $this->Message,
                'is_user' => false
            ]);
        }
    }

    public function selectMessage(int $id)
    {
        $this->usrId = $id;
        $this->openTextEditor = true;
        // dd($this);
        // Notification::where('user_id', $this->usrId)->update(['is_read' => 1]);
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
