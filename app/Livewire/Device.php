<?php

namespace App\Livewire;

use \App\Models\{
    Device as DeviceModel,
    Ticket as TicketModel
};
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Device extends Component
{
    use WithFileUploads;
    public $device_name, $device_year, $drive_link, $device_id, $delete_id, $device_image;
    public $loadCount = 5;
    protected $listeners = ['confirmDelete' => 'deleteTicket'];

    public function fresh()
    {
        $this->device_name = '';
        $this->device_year = '';
        $this->drive_link = '';
        $this->device_id = '';
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

    public function loadAll(int $int): void
    {
        $this->loadCount = DeviceModel::where('user_id', $int)->count();
    }

    public function loadAllLess(): void
    {
        $this->loadCount = 5;
    }

    public function insert_testing()
    {
        // $this->fresh();
        $this->resetValidation(['device_name', 'device_year']);
    }

    public function store_testing()
    {
        $validate = $this->validate([
            'device_name' => 'required|min:3',
            'device_year' => 'required|numeric|digits:4|min:1990|max:' . date('Y'),
            'drive_link' => 'nullable|url',
        ]);

        $this->validate([
            'device_image' => 'nullable|image|max:1024|mimes:jpg,png,jpeg',
        ]);

        if ($this->device_image) {
            $name = md5($this->device_image . microtime()) . '.' . $this->device_image->extension();
            $this->device_image->storeAs('public/device_assets', $name);
            $validate['image_link'] = $name;
        }

        $validate['user_id'] = Auth::user()->id;

        $create = DeviceModel::create($validate);
        if ($create) {
            $this->dispatch('closeButton');
            $this->dispatch('notify', type: 'success', message: 'data successfully created!');
            event(new \App\Events\UserInteraction(Auth::user(), "Device => create new device " . $create->device_name . " with id " . $create->id));
            $this->fresh();
            $this->dispatch('refresh');
        }
    }

    public function edit_testing(int $id): void
    {
        $device = \App\Models\Device::find($id);
        $this->device_id = $id;
        $this->delete_id = $id;
        $this->device_name = $device->device_name;
        $this->device_year = $device->device_year;
        $this->device_image = $device->image_link;
        $this->resetValidation(['device_name', 'device_year']);
        $this->dispatch('modals', data: $device);

        // dd($this);
    }

    public function update_testing(): void
    {
        $validate = $this->validate([
            'device_name' => 'required|min:3',
            'device_year' => 'required|numeric|digits:4|min:1990|max:' . date('Y'),
            'drive_link' => 'nullable|min:3|url'
        ]);

        $validate['user_id'] = Auth::user()->id;
        $device = DeviceModel::find($this->device_id);
        $created = $device->update($validate);
        if ($created) {
            $this->dispatch('closeButton');
            $this->dispatch('notify', type: 'success', message: 'data successfully updated!');
            event(new \App\Events\UserInteraction(Auth::user(), "Device => update device {$device->device_name} with id " . $device->id));
            $this->fresh();
        }
    }

    public function deleteConfirmation(): void
    {
        // $this->delete_id = $this->device_id;
        $this->dispatch('closeButton');
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
        $devices = DeviceModel::with('User')->where('user_id', $auth->id)->orderBy('created_at', 'asc')->limit($this->loadCount)->get();
        return view('livewire.device')->with([
            'devices' => $devices,
        ]);
    }
}
