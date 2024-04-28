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
    public $name = '', $date = '', $mail = '', $username = '';

    protected $listeners = ['confirmDelete' => 'deleteUser'];

    public function detail(int $id): void
    {
        $this->name = UserModel::find($id)->name;
        $this->date = UserModel::find($id)->created_at->diffForHumans();
        $this->mail = UserModel::find($id)->email;
        $this->username = UserModel::find($id)->username;
        // $this->user_data['name'] = UserModel::find($id)->name;
        // $this->user_data['username'] = UserModel::find($id)->username;
    }

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
        $this->dispatch('closeButton');
    }

    public function deleteUser(): void
    {
        // dd("Delete confirmation called with ID: " . $this->delete_id);
        $user = UserModel::find($this->delete_id);

        if (!$user) {
            $this->dispatch('notify', type: 'error', message: 'User not found!');
            return;
        }

        $deleted = $user->delete();
        if ($deleted) {
            $this->dispatch('notify', type: 'success', message: 'User successfully deleted!');
            // $this->fresh();
        } else {
            $this->dispatch('notify', type: 'error', message: 'Failed to delete user!');
        }
    }



    public function deleteConfirmation(int $id): void
    {
        $this->delete_id = $id;
        $this->dispatch('show-delete');
    }

    public function deleteUser(): void
    {
        $user = UserModel::find($this->delete_id);
        // $user = \App\Models\User::find(4);


        $device = DeviceModel::whereIn('user_id', $user->pluck('id'))->get();
        // $device = \App\Models\Device::whereIn('user_id', $user->pluck('id'))->get();


        $ticket = TicketModel::whereIn('device_id', $device->pluck('id'))->get();
        // $ticket = \App\Models\Ticket::whereIn('device_id', $device->pluck('id'))->get();


        $proces = ProcesModel::whereIn('ticket_id', $ticket->pluck('id'))->get();
        // $proces = \App\Models\Proces::whereIn('ticket_id', $ticket->pluck('id'))->get();

        if (!$proces->isEmpty()) {
            foreach ($proces as $data) {
                $data->delete();
            }
        }

        if (!$ticket->isEmpty()) {
            foreach ($ticket as $data) {
                $data->delete();
            }
        }

        if (!$device->isEmpty()) {
            foreach ($device as $data) {
                $data->delete();
            }
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
