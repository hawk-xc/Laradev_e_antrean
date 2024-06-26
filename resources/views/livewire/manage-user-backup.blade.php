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
    public $role_id = '', $user_id = '', $name = '', $date = '', $mail = '', $username = '', $phone = '', $user_image = '';

    protected $listeners = [
        'confirmDelete' => 'deleteUser',
        'updateToTechnician' => 'userTechnician',
        'updateToHelpdesk' => 'userHelpdesk',
    ];

    public function fresh()
    {
        $this->reset('user_id', 'name', 'date', 'mail', 'username', 'phone', 'user_image');
    }

    public function redirecting()
    {
        return redirect()->to('/register');
    }

    public function detail(int $id): void
    {
        $this->fresh();
        $user = UserModel::find($id);
        $this->user_id = $user->id;
        $this->role_id = $user->role_id;
        $this->name = $user->name;
        $this->date = $user->created_at->diffForHumans();
        $this->mail = $user->email;
        $this->phone = $user->phone;
        $this->user_image = $user->user_image;
        $this->username = $user->username;
        // $this->user_data['name'] = UserModel::find($id)->name;
        // $this->user_data['username'] = UserModel::find($id)->username;
    }

    public function userTechnician()
    {
        $user = UserModel::find($this->user_id);
        if ($user->update(['role_id' => 3])) {
            $this->dispatch('notify', type: 'success', message: 'data successfully updated!');
            event(new \App\Events\UserInteraction(Auth::user(), "User => update user " . $user->name . " with id " . $user->id . " to Technician"));
        }
        $this->fresh();
    }

    public function userHelpdesk()
    {
        $user = UserModel::find($this->user_id);
        if ($user->update(['role_id' => 2])) {
            $this->dispatch('notify', type: 'success', message: 'data successfully updated!');
            event(new \App\Events\UserInteraction(Auth::user(), "User => update user " . $user->name . " with id " . $user->id . " to Helpdesk"));
        }
        $this->fresh();
    }

    public function makeTechnician(): void
    {
        $user = UserModel::find($this->user_id);
        $this->dispatch('closeButton');
        $this->dispatch('confirmation', ['user' => $user, 'type' => 'Technician', 'message' => 'Technician can update process and cancel process', 'response' => 'updateToTechnician']);
    }

    public function makeHelpdesk(): void
    {
        $user = UserModel::find($this->user_id);
        $this->dispatch('closeButton');
        $this->dispatch('confirmation', ['user' => $user, 'type' => 'Helpdesk', 'message' => 'The helpdesk can schedule processes, update processes and reject processes', 'response' => 'updateToHelpdesk']);
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


<div class="flex gap-5 md:flex-row max-sm:flex-col">
    {{-- notification pack --}}
    <x-notification-laravel />
    @if (session('notify'))
        <x-notification-laravel :message="session('notify')" />
    @endif

    <div
        class="max-sm:w-full text-xs md:w-4/12 py-5 overflow-y-scroll border rounded-md shadow-md h-[32rem] px-7 border-slate-200">
        <span class="text-xl font-semibold">Daftar Team</span>
        <div class="divider"></div>
        <ul class="flex flex-col gap-2">
            @foreach ($coreUsers as $user)
                <div wire:click='detail({{ $user->id }})' onclick="my_modal_5.showModal()"
                    class="flex items-center gap-5 p-2 transition-all duration-150 rounded-md cursor-pointer hover:bg-slate-100">
                    <div class="avatar">
                        <div class="w-12 h-12 shadow-sm mask mask-squircle">
                            <img src="{{ $user->user_image }}" alt="{{ $user->username . 'image' }}" />
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold text-md">{{ $user->name }}</div>
                        <div class="mt-2 text-xs opacity-90">
                            <div
                                class="flex items-center justify-center gap-2 align-middle badge badge-accent badge-outline">
                                <i class="ri-heart-2-line"></i> {{ $user->role->name }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    </div>

    <div class="w-full p-5 border rounded-md shadow-md border-slate-200">
        <label class="flex items-center gap-2 mb-4 md:hidden input input-sm input-bordered">
            <input wire:model.live='search' type="text" class="grow" placeholder="Search" />
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70">
                <path fill-rule="evenodd"
                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                    clip-rule="evenodd" />
            </svg>
        </label>
        <div class="overflow-x-auto">
            <table class="table text-xs">
                <!-- head -->
                @if (!$clientUsers->isEmpty())
                    <thead>
                        <tr class="p-2 rounded-md bg-slate-200">
                            <th class="cursor-pointer hover:underline" wire:click='sortname'>Nama Pelanggan <i
                                    class="ri-expand-up-down-line"></i></th>
                            <th><i class="ri-phone-line"></i> Telepon</th>
                            <th class="hidden cursor-pointer hover:underline sm:table-cell" wire:click='sortdate'>
                                Ditambahkan
                                <i class="ri-expand-up-down-line"></i>
                            </th>
                        </tr>
                    </thead>
                @endif
                <tbody>
                    @forelse ($clientUsers as $user)
                        <tr class="hover:bg-slate-50" wire:click='detail({{ $user->id }})'
                            onclick="my_modal_5.showModal()">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="w-12 h-12 mask mask-squircle">
                                            <img src="{{ asset($user->user_image) }}"
                                                alt="{{ $user->name . ' image' }}" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $user->name }}</div>
                                        <div class="text-sm opacity-50">{{ '@' . $user->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->phone ? $user->phone : '-' }}</td>
                            <td class="hidden sm:table-cell">
                                <span
                                    class="badge badge-ghost badge-sm">{{ $user->created_at->format('d M Y') }}</span>
                            </td>
                        </tr>
                    @empty
                        <div class="py-20 hero">
                            <div class="text-center hero-content">
                                <div class="max-w-md">
                                    <h1 class="text-5xl font-bold">Hallo User</h1>
                                    <p class="py-6">Untuk saat ini data kosong!
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforelse
            </table>
        </div>
        <div class="flex flex-col items-center justify-center w-full gap-3 mt-4 align-middle lg:flex-row">
            <div class="@if ($clientUsers->hasPages()) w-3/4 @else w-full @endif max-sm:hidden">
                <label class="flex items-center gap-2 input input-bordered">
                    <input wire:model.live='search' id="searchquery" type="text" class="grow"
                        placeholder="Cari berdasarkan username atau nama..." />
                    <kbd class="kbd kbd-sm">ctrl</kbd>
                    <kbd class="kbd kbd-sm">shift</kbd>
                    <kbd class="kbd kbd-sm">K</kbd>
                </label>
            </div>
            @if ($clientUsers->hasPages())
                <div class="w-1/4">
                    {{ $clientUsers->links(data: ['scrollTo' => false]) }}
                </div>
            @endif
        </div>
    </div>
    <dialog id="my_modal_5" wire:ignore.self class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <span class="font-semibold text-md">Profil Akun</span>
            <div class="flex items-center justify-center w-full mt-10 align-middle">
                <div class="flex flex-row gap-7">
                    <div class="">
                        <img class="w-32 mask mask-squircle" src="{{ $user_image }}" alt="">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-semibold">{{ $name }}</span>
                        <span><i class="ri-at-line"></i> {{ $username }}</span>
                        <span><i class="ri-phone-line"></i> {{ $phone ?? '-' }}</span>
                        <span><i class="ri-mail-line"></i> {{ $mail }}</span>
                        <span class="text-sm badge badge-ghost">bergabung {{ $date }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-between mt-16 modal-action">
                @if (!($role_id === 1))
                    <div>
                        @if ($role_id == 2 || $role_id == 4)
                            <button class="btn btn-sm btn-ghost max-sm:btn-xs" wire:click.prevent='makeTechnician'
                                wire:loading.attr='disabled'><i class="ri-exchange-2-line"></i> jadikan teknisi</button>
                        @elseif ($role_id == 3 || $role_id == 4)
                            <button class="btn btn-sm btn-ghost max-sm:btn-xs" wire:click.prevent='makeHelpdesk'
                                wire:loading.attr='disabled'><i class="ri-exchange-2-line"></i> jadikan
                                helpdesk</button>
                        @endif
                        @if ($role_id == 2 || $role_id == 3 || $role_id == 4)
                            <button class="btn btn-sm btn-error max-sm:btn-xs"
                                wire:click.prevent='deleteConfirmation({{ $user_id }})'
                                wire:loading.attr='disabled'>
                                <i class="ri-delete-bin-line"></i> hapus
                            </button>
                        @endif
                    </div>
                @endif
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button id="closeButton" class="btn btn-sm" wire:loading.attr='disabled'>Close</button>
                </form>
            </div>
        </div>
        <div wire:loading class="absolute flex flex-col justify-center m-10 text-lg align-middle text-slate-800">
            <span class="block mx-auto mt-10 loading loading-infinity loading-lg"></span>
            <span class="block mx-auto mb-10">mohon tunggu sebentar...</span>
        </div>
    </dialog>
    @script
        <script type="text/javascript">
            $(document).ready(function() {
                var ctrlPressed = false;
                var shiftPressed = false;

                $(document).keydown(function(event) {
                    if (event.which === 17) {
                        ctrlPressed = true;
                    }
                    if (event.which === 16) {
                        shiftPressed = true;
                    }

                    if (ctrlPressed && shiftPressed && event.which === 75) {

                        $('#searchquery').focus();
                    }
                });
            })
        </script>
    @endscript
</div>
