<?php

namespace App\Livewire;

use \App\Models\Device;
use \App\Models\Proces;
use \App\Models\Ticket as TicketModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;


class Ticket extends Component
{
    public $ticket_id, $device_id, $description;
    public $isEdit = false;

    public function fresh(): void
    {
        $this->device_id = '';
        $this->description = '';
        $this->isEdit = false;
    }

    public function store()
    {
        $validate = $this->validate([
            'device_id' => 'required|numeric',
            'description' => 'required|min:3'
        ]);

        TicketModel::find($this->ticket_id)->update($validate);

        $this->fresh();
    }

    public function message()
    {
        // session()->flash('notify', 'this is message');
        $this->render();
    }

    public function create(): void
    {
        $this->isEdit = false;
        $validate = $this->validate([
            'device_id' => 'required',
            'description' => 'required|min:3'
        ]);

        if ($validate) :
            $ticket = TicketModel::create($validate);
            $data = [
                'status_id' => 1,
                'ticket_id' => $ticket->id,
                'user_id' => Auth::user()->id
            ];

            if (Proces::create($data)) {
                session()->flash('notify', 'data successfull create!');
            }
        endif;

        $this->fresh();
    }

    public function delete(int $id): void
    {
        $ticket = TicketModel::find($id);

        if ($ticket->delete()) {
            session()->flash('notify', 'data successfull delete!');
        }

        $this->fresh();
    }

    public function edit($id)
    {
        // $this->fresh();
        $this->isEdit = true;
        $ticket = TicketModel::find($id);
        $this->ticket_id = $id;
        $this->device_id = $ticket->device_id;
        $this->description = $ticket->description;
        // dd($this->device_id, $this->description);
    }

    public function render(): View
    {
        $tickets = TicketModel::orderBy('created_at', 'asc')->paginate(5);
        $devices = Device::where('user_id', Auth::user()->id)->get();

        session()->flash('notify', 'data successfull delete!');
        return view('livewire.ticket', [
            'tickets' => $tickets,
            'devices' => $devices,
            // 'description' => $this->description
        ]);
    }
}
