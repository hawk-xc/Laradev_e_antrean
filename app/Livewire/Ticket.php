<?php

namespace App\Livewire;

use \App\Models\Device as DeviceModel;
use \App\Models\Ticket as TicketModel;
use \App\Models\Proces as ProcesModel;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class Ticket extends Component
{
    use WithFileUploads;
    public $id, $device_id, $description, $ticket_updated_at, $ticket_id, $closed_id, $device_image;

    public $loadCount = 5;
    protected $listeners = ['confirmDelete' => 'deleteTicket'];

    public function fresh()
    {
        $this->id = '';
        $this->device_id = '';
        $this->description = '';
        $this->ticket_id = '';
        $this->ticket_updated_at = '';
        $this->device_image = '';
    }

    // load more load less config
    public function loadMore(int $int): void
    {
        $this->loadCount += $int;
    }

    public function loadLess(int $int): void
    {
        $this->loadCount -= $int;
    }

    public function loadAll(): void
    {
        $this->loadCount = \App\Models\Ticket::where('device_id', \App\Models\Device::where('user_id', Auth::user()->id)->pluck('id'))->count();
    }

    public function loadAllLess(): void
    {
        $this->loadCount = 5;
    }

    public function insert_testing()
    {
        // $this->fresh();
        $this->resetValidation(['device_id', 'description']);
    }

    public function store_testing()
    {
        // dd($this);
        $validate = $this->validate([
            'device_id' => 'required|integer',
            'description' => 'required|min:3',
        ]);

        $this->validate([
            'device_image' => 'nullable|image|max:1024|mimes:jpg,png,jpeg',
        ]);

        if ($this->device_image) {
            $name = md5($this->device_image . microtime()) . '.' . $this->device_image->extension();
            $this->device_image->storeAs('public/ticket_assets', $name);
            $validate['image_link'] = $name;
        }

        $validate['created_at'] = now()->format('Y-m-d H:i:s');
        $validate['closed_at'] = now()->addDay(3)->format('Y-m-d H:i:s');

        $today = now()->format('Y-m-d');
        $count = TicketModel::whereDate('created_at', $today)->count();
        if ($validate['created_at'] == now()) {
            $validate['id_ticket'] = now()->format('ymd') . ($count + 1);
        } else {
            $validate['id_ticket'] = now()->format('ymd') . ($count = 1);
        }

        if ($validate) :
            $ticket = TicketModel::create($validate);
            $data = [
                'status_id' => 1,
                'ticket_id' => $ticket->id,
            ];

            $create = ProcesModel::create($data);
            if ($create) {
                $this->dispatch('notify', type: 'success', message: 'data successfully created!');
                event(new \App\Events\UserInteraction(Auth::user(), "Ticket => create ticket " . $create->id));
                $this->fresh();
            }
            $this->dispatch('closeButton');
        endif;
    }

    public function edit_testing(int $id): void
    {
        $ticket = \App\Models\Ticket::find($id);
        $this->id = $id;
        $this->device_id = $ticket->device->id;
        $this->description = $ticket->description;
        $this->ticket_updated_at = $ticket->updated_at;
        $this->ticket_id = $id;
        $this->device_image = $ticket->image_link;

        $this->resetValidation(['device_name', 'device_year']);

        $this->dispatch('modals-ticket', data: $ticket);

        // dd($this);
    }

    public function update_testing(): void
    {
        $validate = $this->validate([
            'device_id' => 'required|numeric',
            'description' => 'required|min:3',
        ]);

        $ticket = TicketModel::find($this->ticket_id);

        event(new \App\Events\UserInteraction(Auth::user(), "Ticket => update ticket " . $ticket->id));

        if ($create = $ticket->update($validate)) {
            $this->dispatch('notify', type: 'success', message: 'data successfull updated!');
            $this->fresh();
            $this->dispatch('closeButton');
        }
    }

    public function deleteConfirmation(): void
    {
        $this->dispatch('closeButton');
        $this->dispatch('show-delete');
        $this->closed_id = $this->ticket_id;
    }

    public function deleteTicket(): void
    {
        $update = ProcesModel::where('ticket_id', $this->closed_id)->update(['status_id' => 5]);
        // $ticket = TicketModel::find($this->delete_id);

        if (ProcesModel::where('ticket_id', $this->closed_id)->first()->status_id === 5) {
            event(new \App\Events\UserInteraction(Auth::user(), "Ticket => closed ticket " . $this->closed_id));
            if ($update) {
                $this->dispatch('notify', type: 'success', message: 'data berhasil diupdate!');
                $this->fresh();
            }
        }
    }

    public function close()
    {
        $this->fresh();
    }

    public function render()
    {
        $auth = Auth::user();
        $devices = DeviceModel::where('user_id', Auth::user()->id)->get();
        $tickets = TicketModel::whereIn('device_id', $devices->pluck('id'))->orderBy('created_at', 'asc')->limit($this->loadCount)->get();
        return view('livewire.ticket')->with([
            'tickets' => $tickets,
            'devices' => $devices,
        ]);
    }
}
