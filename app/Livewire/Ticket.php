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

    // delete functionality
    public $delete_id;
    protected $listeners = ['confirmDelete' => 'deleteTicket'];

    public function fresh(): void
    {
        $this->reset('device_id');
        $this->reset('device_id');
        $this->reset('description');
        $this->action = 'create';
        // $this->openModal = false;
    }

    public function create(): void
    {
        $this->openModal = true;
        $this->action = 'create';
        $validate = $this->validate([
            'device_id' => 'required',
            'description' => 'required|min:3'
        ]);

        $validate['closed_at'] = now()->addDay(3)->format('Y-m-d H:i:s');

        if ($validate) :
            $ticket = TicketModel::create($validate);
            $data = [
                'status_id' => 1,
                'ticket_id' => $ticket->id,
                'user_id' => Auth::user()->id
            ];

            $create = Proces::create($data);
            if ($create) {
                $this->dispatch('notify', type: 'success', message: 'data successfully created!');
                event(new \App\Events\UserInteraction(Auth::user(), "Ticket => create ticket " . $create->id));
                $this->fresh();
            }
            $this->dispatch('closeButton');
        endif;
    }

    public function close()
    {
        $this->fresh();
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

        $ticket = TicketModel::find($this->ticket_id);
        event(new \App\Events\UserInteraction(Auth::user(), "Ticket => update ticket " . $ticket->id));

        if ($create = $ticket->update($validate)) {
            $this->dispatch('notify', type: 'success', message: 'data successfull updated!');

            $this->fresh();
            $this->dispatch('closeButton');
        }
    }

    public function deleteConfirmation(int $id): void
    {
        $this->delete_id = $id;
        $this->dispatch('show-delete');
        $this->dispatch('closeButton');
    }

    public function deleteTicket(): void
    {
        Proces::where('ticket_id', $this->delete_id)->delete();
        $ticket = TicketModel::find($this->delete_id);

        event(new \App\Events\UserInteraction(Auth::user(), "Ticket => delete ticket " . $ticket->id));
        if ($create = $ticket->delete()) {
            $this->dispatch('notify', type: 'success', message: 'data successfully deleted!');
            $this->fresh();
        }
    }

    public function render(): View
    {
        $devices = Device::where('user_id', Auth::user()->id)->get();
        $tickets = TicketModel::whereIn('device_id', $devices->pluck('id'))->orderBy('created_at', 'asc')->paginate(5);

        // session()->flash('notify', 'data successfull delete!');
        return view('livewire.ticket', [
            'tickets' => $tickets,
            'devices' => $devices,
            // 'description' => $this->description
        ]);
    }
}
