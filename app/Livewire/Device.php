<?php

namespace App\Livewire;

use \App\Models\Device as DeviceModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Device extends Component
{
    public $device_name, $device_year;

    public array $checks = [];

    public function bulkDelete(): void
    {
        DeviceModel::whereIn('id', $this->checks)->delete();
    }

    public function fresh()
    {
        $this->reset('device_name');
        $this->reset('device_year');
    }

    public function create()
    {
        $validate = $this->validate([
            'device_name' => 'required|min:3',
            'device_year' => 'required|numeric|min:4'
        ]);

        $validate['user_id'] = Auth::user()->id;

        if (DeviceModel::create($validate)) {
            $this->dispatch('closeButton');
            $this->dispatch('notify', type: 'success', message: 'data successfully created!');
            $this->fresh();
        }
    }

    public function add($id)
    {
        $device = DeviceModel::find($id);
        // $this->data[] = $device->device_name;
        // $this->data[] = $device->device_year;

        dd($this->device_year, $this->device_name);
    }

    public function sets()
    {
        // $this->device_name = 'testing';
        // $this->device_year = "sdsdf";

        dd($this->data);
        // dd($this->device_name, $this->device_year);
    }

    public function edit($id)
    {
        // $device = DeviceModel::find($id);
        // $this->device_name = $device->device_name;
        // $this->device_year = $device->device_year;

        dd($this->device_name, $this->device_year);
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
