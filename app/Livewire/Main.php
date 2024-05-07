<?php

namespace App\Livewire;

use \App\Models\{
    Device as DeviceModel,
    Proces as ProcesModel,
    Ticket as TicketModel,
    User as UserModel
};

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Main extends Component
{
    public $isVisible = true;

    public function showAllData()
    {
        $this->isVisible = false;
    }

    public function hideAllData()
    {
        $this->isVisible = true;
    }

    public function render()
    {
        $devices = DeviceModel::where('user_id', Auth::user()->id);
        $tickets = TicketModel::whereIn('device_id', $devices->pluck('id'))->orderBy('created_at', 'asc')->get();
        $process =  ProcesModel::whereIn('ticket_id', $tickets->pluck('id'))->orderBy('created_at', 'asc')->get();
        $users = UserModel::all();

        return view('livewire.main', [
            'tickets' => $tickets,
            'devices' => $devices,
            'process' => $process,
            'users' => $users,
            'userJson' => json_encode($users),
            'procesJson' => json_encode($process),
            'ticketJson' => json_encode($tickets),
        ]);
    }
}
