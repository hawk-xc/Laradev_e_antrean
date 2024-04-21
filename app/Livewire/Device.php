<?php

namespace App\Livewire;

use \App\Models\Device as DeviceModel;
use App\Rules\YearValidation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Device extends Component
{
    public $device_name, $device_year, $device_id, $delete_id;

    public $action = 'create';

    public array $checks = [];

    protected $listeners = ['confirmDelete' => 'deleteTicket'];

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
        if ($device->delete()) {
            $this->dispatch('notify', type: 'success', message: 'data successfully deleted!');
            $this->fresh();
        }
    }

    public function fresh()
    {
        $this->device_name = '';
        $this->device_year = '';
        $this->action = 'create';
    }

    public function create()
    {
        $this->action = 'create';
        $validate = $this->validate([
            'device_name' => ['required', 'min:3'],
            'device_year' => ['required', 'numeric', 'min:4', new YearValidation]
        ]);

        $validate['user_id'] = Auth::user()->id;

        if (DeviceModel::create($validate)) {
            $this->dispatch('closeButton');
            $this->dispatch('notify', type: 'success', message: 'data successfully created!');
            $this->fresh();
        }
    }

    public function edit($id)
    {
        $this->action = 'update';
        $this->device_id = $id;
        $device = DeviceModel::find($id);
        $this->device_name = $device->device_name;
        $this->device_year = $device->device_year;
    }

    public function close()
    {
        $this->fresh();
    }

    public function store()
    {
        $validate = $this->validate([
            'device_name' => 'required|min:3',
            'device_year' => 'required|numeric|min:4'
        ]);
        $validate['user_id'] = Auth::user()->id;
        $device = DeviceModel::find($this->device_id);
        if ($device->update($validate)) {
            $this->dispatch('closeButton');
            $this->dispatch('notify', type: 'success', message: 'data successfully updated!');
            $this->fresh();
        }
    }

    public function delete($id)
    {
        $device = DeviceModel::find($id);
        $device->delete();
        $this->fresh();
    }

    public function render()
    {
        $auth = Auth::user();
        $devices = DeviceModel::with('User')->where('user_id', $auth->id)->orderBy('created_at', 'asc')->paginate(5);
        $is_empty = isset($devices);
        return view('livewire.device')->with(['devices' => $devices]);
    }
}
