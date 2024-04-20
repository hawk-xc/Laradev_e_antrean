<?php

namespace App\Livewire;

use App\Models\Proces;
use App\Models\User;
use App\Models\Ticket; // Import model Ticket
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

    public function fresh()
    {
        $this->device_id = '';
        $this->description = '';
        $this->action = 'create';
    }
    public function render()
    {
        $process = Proces::orderBy('created_at', 'asc')->paginate(5);
        // $process = Proces::orderBy('created_at', 'asc')->get();
        $employees = User::where('role_id', '2')->get();
        // $devices = Device::where('user_id');
        return view('livewire.process', compact('process', 'employees',));
        // dd($process);
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

    public function store()
    {
        // Lakukan validasi sesuai kebutuhan Anda
        $this->validate([
            'status_id' => 'required',
            'employe_id' => 'required', // Ubah user_id menjadi employe_id
            // Tambahkan aturan validasi lainnya jika diperlukan
        ]);

        // Temukan dan perbarui entitas Proces yang sesuai dengan id yang diinginkan
        $proces = Proces::findOrFail($this->proces_id);

        // Lakukan pembaruan nilai status_id dan user_id
        $proces->update([
            'status_id' => $this->status_id,
            'user_id' => $this->employe_id, // Ubah user_id menjadi employe_id
            // Masukkan kolom lainnya yang perlu diperbarui sesuai kebutuhan Anda
        ]);

        // Setelah melakukan pembaruan, Anda bisa melakukan beberapa tindakan lainnya,
        // seperti menampilkan pesan sukses atau melakukan reset input
        session()->flash('message', 'Data successfully updated!');
        $this->reset(['status_id', 'employe_id']); // Ubah user_id menjadi employe_id
    }
}
