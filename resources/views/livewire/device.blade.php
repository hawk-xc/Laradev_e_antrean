<?php

namespace App\Livewire;

use \App\Models\Device as DeviceModel;
use \App\Models\Ticket as TicketModel;
use App\Rules\YearValidation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Device extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $device_name, $device_year, $device_id, $delete_id;

    public $openModal = false;

    // Pertahankan nilai action menggunakan session
    protected $listeners = ['confirmDelete' => 'deleteTicket', 'editMode' => 'setEditMode'];

    public array $checks = [];

    public $action = 'create'; // Default action

    public function bulkDelete(): void
    {
        DeviceModel::whereIn('id', $this->checks)->delete();
    }

    public function deleteConfirmation(int $id): void
    {
        $this->delete_id = $id;
        $this->dispatch('show-delete');
    }

    public function deleteTicket(): void
    {
        $device = DeviceModel::find($this->delete_id);
        if (TicketModel::where('device_id', $device->id)->exists()) {
            $this->dispatch('notify', type: 'error', message: 'Data cannot be deleted!');
        } else {
            if ($device->delete()) {
                $this->dispatch('notify', type: 'success', message: 'data successfully deleted!');
                event(new \App\Events\UserInteraction(Auth::user(), "Device => delete device " . $device->device_name . " with id " . $device->id));
                $this->fresh();
            }
        }
    }

    public function fresh()
    {
        $this->reset(['device_name', 'device_year', 'device_id']);
        $this->action = 'create';
        $this->openModal = false;
    }

    public function create()
    {
        // Pengaturan action dilakukan saat membuka modal
        $validate = $this->validate([
            'device_name' => ['required', 'min:3'],
            'device_year' => ['required', 'numeric', 'min:4', new YearValidation]
        ]);

        $validate['user_id'] = Auth::user()->id;

        $create = DeviceModel::create($validate);
        if ($create) {
            $this->dispatch('closeButton');
            $this->dispatch('notify', type: 'success', message: 'data successfully created!');
            event(new \App\Events\UserInteraction(Auth::user(), "Device => create new device " . $create->device_name . " with id " . $create->id));
            $this->fresh();
        }
    }

    public function setEditMode($id)
    {
        // Set action ke 'edit' dan buka modal
        $this->action = 'edit';
        $this->openModal = true;
        $this->device_id = $id;
        $device = DeviceModel::find($id);
        $this->device_name = $device->device_name;
        $this->device_year = $device->device_year;
    }

    // Metode untuk menangani update data
    public function store()
    {
        $validate = $this->validate([
            'device_name' => 'required|min:3',
            'device_year' => 'required|numeric|min:4'
        ]);

        $validate['user_id'] = Auth::user()->id;
        $device = DeviceModel::find($this->device_id);
        $created = $device->update($validate);
        if ($created) {
            $this->dispatch('closeButton');
            $this->dispatch('notify', type: 'success', message: 'data berhasil diupdate!');
            event(new \App\Events\UserInteraction(Auth::user(), "Device => update device {$device->device_name} with id " . $device->id));
            $this->fresh();
        }
    }

    public function render()
    {
        $auth = Auth::user();
        $devices = DeviceModel::with('User')->where('user_id', $auth->id)->orderBy('created_at', 'asc')->paginate(5);
        $devicess = DeviceModel::where('user_id', Auth::user()->id)->get();
        $is_empty = isset($devices);
        return view('livewire.device', compact('devices', 'devicess'));
    }
}
