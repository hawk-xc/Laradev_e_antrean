<?php

namespace App\Livewire;

use \App\Models\Device;
use \App\Models\Proces;
use \App\Models\Ticket as TicketModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;


class Ticket extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $ticket_id, $device_id, $description;
    public $openModal = true;
    public $action = 'create';

    public $notif = false;

    public function fresh(): void
    {
        $this->device_id = '';
        $this->description = '';
        $this->action = 'create';
        $this->openModal = false;
    }

    public function create(): void
    {
        $this->openModal = true;
        $this->action = 'create';
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
                $this->dispatch('notify', type: 'success', message: 'data successfully created!');
                $this->fresh();
            }
        endif;
    }

    public function edit(int $id): void
    {
        $this->action = 'edit';
        $this->openModal = true;
        $ticket = TicketModel::find($id);
        $this->ticket_id = $id;
        $this->device_id = $ticket->device_id;
        $this->description = $ticket->description;
    }

    public function store()
    {
        $validate = $this->validate([
            'device_id' => 'required|numeric',
            'description' => 'required|min:3'
        ]);

        if (TicketModel::find($this->ticket_id)->update($validate)) {
            $this->dispatch('notify', type: 'success', message: 'data successfull updated!');
            $this->fresh();
        }
    }

    public function delete(int $id): void
    {
        $ticket = TicketModel::find($id);

        if ($ticket->delete()) {
            $this->dispatch('notify', type: 'success', message: 'data successfully deleted!');
            $this->fresh();
        }
    }

    public function render(): View
    {
        $tickets = TicketModel::orderBy('created_at', 'asc')->paginate(5);
        $devices = Device::where('user_id', Auth::user()->id)->get();

        // session()->flash('notify', 'data successfull delete!');
        return view('livewire.ticket', [
            'tickets' => $tickets,
            'devices' => $devices,
            // 'description' => $this->description
        ]);
    }
}
