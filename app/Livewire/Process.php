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
    // public $action = '';
    public $status_id;
    public $description;
    public $proces_id;
    public $device_id;
    public $employe_id;
    public $sortBy = 'status';
    public $sortDirection = 'asc';

    public function sortByDate($direction)
    {
        $this->sortBy = 'date';
        $this->sortDirection = $direction;
    }

    public function fresh()
    {
        $this->reset(['status_id', 'employe_id', 'proces_id']);
        $this->reset('status_id');
        // $this->reset('employe_id');
        // $this->reset('proces_id');
        $this->openModal = false;
        // $this->action = '';
    }
    public function render()
    {
        // $statuses = Status::get();
        $statuses = Status::get();
        $user = Auth::user();

        if ($user->role_id === 1) {
            if ($this->sortBy === 'date') {
                $process = Proces::orderBy('created_at', $this->sortDirection)->paginate(5);
            } else {
                $process = Proces::latest()->paginate(5);
            }
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

    public function edit(int $id)
    {
        // $this->action = 'edit';
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

        $data = $this->validate([
            'status_id' => 'required',
        ]);
        $data['user_id'] = $this->employe_id;
        $proces = Proces::find($this->proces_id);
        if ($proces->update($data)) {
            $this->fresh();
            $this->dispatch('closeButton');
            $this->dispatch('notify', type: 'success', message: 'Data successfully updated!');
            event(new \App\Events\UserInteraction(Auth::user(), "Process => update proces from customer {$proces->ticket->device->user->name} with id " . $proces->id));
            // redirect('/process')->dispatch('notify', type: 'success', message: 'Data successfully updated!'));
            // session()->flash('message', 'Data successfully updated broww!');
            redirect('/process');
            // redirect('/process')->with('message', 'Data successfully updated broww!');
            // redirect('/process');
            // $this->dispatch('notify', type: 'success', message: 'Data successfully updated!');
            // $this->dispatch('closeButton');
        }
    }
}
