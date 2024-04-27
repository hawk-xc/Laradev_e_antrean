<?php

namespace App\Livewire;

// model definition
use \App\Models\User as UserModel;
use \App\Models\Device as DeviceModel;
use \App\Models\Ticket as TicketModel;
use \App\Models\Proces as ProcesModel;

// component support
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ManageUser extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search = '';
    public $sortby = 'username';
    public $delete_id;

    protected $listeners = ['confirmDelete' => 'deleteUser'];

    public function sortname()
    {
        $this->sortby = 'name';
    }

    public function sortdate()
    {
        $this->sortby = 'created_at';
    }

    public function deleteConfirmation(int $id): void
    {
        $this->delete_id = $id;
        $this->dispatch('show-delete');
    }

    public function deleteUser(): void
    {
        $user = UserModel::find($this->delete_id);
        $device = DeviceModel::where('user_id', $user->id);
        $ticket = TicketModel::where('device_id', $device->pluck('id'));
        $proces = ProcesModel::where('ticket_id', $ticket->pluck('id'));

        if (!$proces->isEmpty()) {
            $proces->delete();
        }

        if (!$ticket->isEmpty()) {
            $ticket->delete();
        }

        if (!$device->isEmpty()) {
            $device->delete();
        }

        if ($user->delete()) {
            $this->dispatch('notify', type: 'success', message: 'data successfully deleted!');
            event(new \App\Events\UserInteraction(Auth::user(), "User => delete user " . $user->name . " with id " . $user->id));
        }
    }

    public function render()
    {
        $coreUsers = UserModel::orderBy('role_id', 'asc')->whereIn('role_id', [1, 2, 3])->get();
        $clientUsers = UserModel::orderBy($this->sortby, 'asc')->where('role_id', '=', 4)->where(function ($query) {
            $query->where('username', 'like', '%' . $this->search . '%')->orWhere('name', 'like', '%' . $this->search . '%');
        })->simplePaginate(5);

        return view('livewire.manage-user', [
            'coreUsers' => $coreUsers,
            'clientUsers' => $clientUsers
        ]);
    }
}
