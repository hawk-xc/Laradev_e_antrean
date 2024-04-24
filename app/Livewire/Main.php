<?php

namespace App\Livewire;

use \App\Models\Device as DeviceModel;
use \App\Models\Proces as ProcesModel;
use \App\Models\Ticket as TicketModel;
use Illuminate\Support\Carbon;
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

        return view('livewire.main', [
            'tickets' => $tickets,
            'devices' => $devices,
            'process' => $process,
        ]);
    }
}
