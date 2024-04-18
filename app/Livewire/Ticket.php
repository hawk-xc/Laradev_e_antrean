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
    public $openModal = true;
    public $isEdit = false;
    public $messa = 'ksong';

    // public function dehydrate()
    // {
    //     session()->flash('notify', 'nanskdnas');
    // }

    public function fresh(): void
    {
        $this->device_id = '';
        $this->description = '';
        $this->isEdit = false;
        $this->openModal = false;
    }

    public function updated()
    {
        $this->openModal = true;
        session()->flash('notify', $this->messa);
    }

    public function create(): void
    {
        // $this->openModal = true;
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
                $this->messa = 'sukses dibuat teman';
                $this->fresh();
            }
        endif;
    }

    public function delete(int $id): void
    {
        $ticket = TicketModel::find($id);

        $this->messa = 'dihapus aja';
        if ($ticket->delete()) {
            $this->fresh();
        }
    }

    public function edit(int $id): void
    {
        $this->openModal = true;
        $this->isEdit = true;
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
            session()->flash('notify', 'data successfull updated!');
        }

        $this->fresh();
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
