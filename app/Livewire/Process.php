<?php

namespace App\Livewire;

use App\Models\Proces;
use App\Models\User;
use App\Models\Status;
use App\Models\Ticket; // Import model Ticket
use Clockwork\Request\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Process extends Component
{
    public $openModal = false;
    public $action = 'create';
    public $status_id;
    public $description;
    public $proces_id;
    public $device_id;
    public $employe_id;

    public function fresh()
    {
        $this->device_id = '';
        $this->description = '';
        $this->action = 'create';
    }
    public function render()
    {
        // $statuses = Status::get();
        $statuses = Status::get();
        $process = Proces::orderBy('created_at', 'asc')->paginate(5);
        $employees = User::where('role_id', '2')->get();
        // dd($statuses);

        return view('livewire.process', compact('process', 'employees', 'statuses'));
    }

    public function create(): void
    {
        $this->validate([
            'status_id' => 'required',
            'employe_id' => 'required'
        ]);
        $process = Process::findOrFail($this->id);
        $employee = User::findOrFail($this->id);
    }

    public function edit($id)
    {
        $this->action = 'edit';
        $this->openModal = true;
        $process = Proces::find($id);
        $this->proces_id = $process->id;
        $this->status_id = $process->status_id;
        $this->employe_id = $process->user_id;
    }

    public function store()
    {
        // Lakukan validasi sesuai kebutuhan Anda
        $this->validate([
            'status_id' => 'required',
            'employe_id' => 'required',
        ]);

        // $proces = Proces::findOrFail($this->status_id);
        $proces = Proces::findOrFail($this->proces_id);
        // $employee = User::findOrFail($this->employe_id);

        $proces->update([
            'status_id' => $this->status_id,
            'user_id' => $this->employe_id,
        ]);


        session()->flash('message', 'Data successfully updated!');
        $this->reset(['status_id', 'employe_id']);
    }
}
