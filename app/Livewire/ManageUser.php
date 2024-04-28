<?php

namespace App\Livewire;

use Livewire\Component;
use \App\Models\User as UserModel;
use Illuminate\Support\Facades\Auth;
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
