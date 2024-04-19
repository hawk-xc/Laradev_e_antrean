<?php

namespace App\Livewire;

use App\Models\Proces;
use App\Models\Ticket; // Import model Ticket
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Process extends Component
{
    public $openModal = false; // Atur nilai default untuk $openModal
    public $action = 'create';
    public $status_id;
    public $description;
    public $proces_id; // Tambahkan variabel ini
    public $device_id; // Tambahkan variabel ini

    public function render()
    {
        $process = Proces::orderBy('created_at', 'asc')->paginate(5);
        return view('livewire.process', compact('process'));
    }

    public function create(): void
    {
        $this->validate([
            'status_id' => 'required',
            'description' => 'required|min:3'
        ]);

        $ticket = Ticket::create([
            'status_id' => 1, // Asumsikan status_id default adalah 1
            'description' => $this->description
        ]);

        $data = [
            'status_id' => $this->status_id,
            'ticket_id' => $ticket->id,
            'user_id' => Auth::user()->id
        ];

        if (Proces::create($data)) {
            $this->openModal = false; // Tutup modal setelah proses berhasil
            session()->flash('message', 'Data successfully created!');
            $this->reset(['status_id', 'description']); // Reset nilai input setelah proses berhasil
        }
    }

    public function edit(int $id): void
    {
        $this->action = 'edit';
        $this->openModal = true;
        $process = Proces::find($id);

        // Assign nilai variabel dari hasil query
        $this->proces_id = $process->id;
        $this->status_id = $process->status_id;
        $this->status_id = $process->status->name;
    }
}
