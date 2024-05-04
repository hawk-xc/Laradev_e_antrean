<?php

namespace App\Livewire;

use App\Models\Device as ModelsDevice;
use App\Models\Proces;
use App\Models\User;
use App\Models\Status;
use App\Models\Ticket; // Import model Ticket
use App\View\Components\device;
use Clockwork\Request\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Process extends Component
{
    use WithPagination, WithoutUrlPagination;
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
        $user = Auth::user();

        // $process = Proces::orderBy('id', 'asc')->paginate(5);
        if ($user->role_id === 1) {

            // $process = Proces::orderBy('id', 'asc')->latest()->paginate(5);
            $process = Proces::latest()->paginate(5);
        } else {
            $process = Proces::where('user_id', Auth::user()->id)->orderBy('id', 'asc')->latest()->paginate(5);
        }
        $employees = User::where('role_id', '3')->get();
        $task = Proces::where('user_id', Auth::user()->id)->get();
        // dd($statuses);
        return view('livewire.process', compact('process', 'employees', 'user', 'statuses', 'task'));
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

    public function processed($id)
    {

        Proces::find($id)->update(['status_id' => 3]);
        // find($this->device_id);
        $proces = Proces::find($id);
        $this->dispatch('notify', type: 'success', message: 'data successfull updated! ');
        event(new \App\Events\UserInteraction(Auth::user(), "Proces => update proces {$proces->ticket->device->device_name} with id " . $proces->id));
        $this->fresh();
        $this->dispatch('closeButton');
    }

    public function done($id)
    {
        Proces::find($id)->update(['status_id' => 4]);
        $this->dispatch('notify', type: 'success', message: 'Device Has Been Final!');
        $this->fresh();
        $this->dispatch('closeButton');
    }

    public function store()
    {

        // Lakukan validasi sesuai kebutuhan Anda
        $validate = $this->validate([
            'status_id' => 'required',
            'employe_id' => 'required',
        ]);
        // dd($validate);

        // $proces = Proces::findOrFail($this->status_id);
        $proces = Proces::findOrFail($this->proces_id);
        // $employee = User::findOrFail($this->employe_id);

        // $proces->update([
        //     'status_id' => $this->status_id,
        //     'user_id' => $this->employe_id,
        // ]);

        // if (Proces::find($this->proces_id)->update($validate)) {
        // if (Proces::find($proces)->update([
        //     'status_id' => $validate['status_id'],
        //     'user_id' => $validate['employe_id']
        // ])) {
        //     $this->dispatch('notify', type: 'success', message: 'data successfull updated!');
        //     $this->fresh();
        //     $this->dispatch('closeButton');
        // }
        $proces->update([
            'status_id' => $validate['status_id'],
            'user_id' => $validate['employe_id'],
        ]);

        // Jika proses update berhasil
        $this->dispatch('notify', type: 'success', message: 'data successfully updated!');
        $this->fresh();
        $this->dispatch('closeButton');

        session()->flash('message', 'Data successfully updated!');
        $this->reset(['status_id', 'employe_id']);
    }
}
