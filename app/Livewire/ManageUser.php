<?php

namespace App\Livewire;

use Livewire\Component;
use \App\Models\User as UserModel;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ManageUser extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $search = '';
    public $sortby = 'username';

    public function sortname()
    {
        $this->sortby = 'name';
    }

    public function sortdate()
    {
        $this->sortby = 'created_at';
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
