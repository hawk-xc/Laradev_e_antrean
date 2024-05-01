<div class="flex flex-row gap-5 m-4">
    {{-- notification pack --}}
    <x-notification-laravel />
    @if (session('notify'))
        <x-notification-laravel :message="session('notify')" />
    @endif
    <div class="w-4/12 py-5 border rounded-md shadow-md px-7 border-slate-200">
        <span class="font-semibold text-md">Our Team</span>
        <div class="divider"></div>
        <ul class="flex flex-col gap-2">
            @foreach ($coreUsers as $user)
                <div
                    class="flex items-center gap-5 p-2 transition-all duration-150 rounded-md cursor-pointer hover:bg-slate-100">
                    <div class="avatar">
                        <div class="w-12 h-12 shadow-sm mask mask-squircle">
                            <img src="{{ asset('images/computercat.jpeg') }}" alt="{{ $user->username . 'image' }}" />
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold text-md">{{ $user->name }}</div>
                        <div class="flex flex-row text-sm opacity-90" >
                            <div
                                class="items-center justify-center gap-2 align-middle badge badge-accent badge-outline">
                                <i class="ri-heart-2-line"></i> {{ $user->role->name }}
                            </div>
                            <div class="items-center justify-center gap-2 ml-6 align-middle">
                                <a class="badge badge-accent badge-outline" onclick="my_modal_1.showModal()"><i class="mr-2 ri-edit-2-line"></i>Edit</a>
        <input type="checkbox" id="my_modal_1" class="modal-toggle" />
        <div class="modal" role="dialog" wire:ignore.self>
            <div class="modal-box" wire:loading.remove>
                <h3 class="text-lg font-bold">Edit Role Account</h3>
                <div class="flex gap-2 md:flex-row max-sm:flex-col">
                    <label class="w-full max-w-xs form-control">
                        <div class="label">
                            <span class="label-text">Role name?</span>
                        </div>
                        <input type="text" placeholder="Type here" class="w-full max-w-xs input input-bordered"
                            wire:model="role_name" />
                        @error('role')
                            <div class="label">
                                <span class="label-text-alt">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>
                    <label class="w-full max-w-xs form-control">
                        <div class="label">
                            <span class="label-text">Role Account?</span>
                        </div>
                        <input type="number" min="1980" max="{{ now()->year }}" placeholder="Type here"
                            class="w-full max-w-xs input input-bordered" wire:model="device_year" />
                        @error('device_year')
                            <div class="label">
                                <span class="label-text-alt">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>
                </div>
                <div class="modal-action">
                    @if ($action == 'create')
                        <button wire:click="create" class="btn btn-neutral">save!</button>
                    @elseif($action == 'update')
                        <button wire:click="store" class="btn btn-neutral">update!</button>
                    @endif
                    <label wire:click='close' id="closeButton" for="my_modal_6" class="btn">Close!</label>
                </div>
            </div>
            <div wire:loading class="absolute flex flex-col justify-center m-10 text-lg text-white align-middle">
                <span class="block mx-auto mt-10 loading loading-infinity loading-lg"></span>
                <span class="block mx-auto mb-10">please wait a moment...</span>
            </div>
        </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    </div>

    <!-- Pengguna Klien -->
    <div class="w-full p-5 border rounded-md shadow-md border-slate-200">
        <div class="overflow-x-auto">
            <table class="table">
                <!-- kepala -->
                <thead>
                    <tr class="p-2 rounded-md bg-slate-200">
                        <th class="cursor-pointer hover:underline" wire:click='sortname'>Client Name <i
                                class="ri-expand-up-down-line"></i></th>
                        <th class="cursor-pointer hover:underline" wire:click='sortdate'>Joined <i
                                class="ri-expand-up-down-line"></i></th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientUsers as $user)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="w-12 h-12 mask mask-squircle">
                                            <img src="{{ asset('images/user-guest.png') }}  "
                                                alt="Avatar Tailwind CSS Component" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $user->name }}</div>
                                        <div class="text-sm opacity-50">{{ '@' . $user->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-ghost badge-sm">{{ $user->created_at->format('d M Y') }}</span>
                            </td>
                            <th>
                                <button class="btn btn-ghost btn-xs" wire:click='detail({{ $user->id }})'
                                    onclick="my_modal_5.showModal()">
                                    <i class="ri-search-2-line"></i>
                                    details
                                </button>
                                <button wire:click.prevent='deleteConfirmation({{ $user->id }})'
                                    class="btn btn-warning btn-xs">
                                    <i class="ri-delete-bin-line"></i>
                                    delete
                                </button>
                                <button wire:click.prevent='toEmployee({{ $user->id }})'
                                    class="btn btn-warning btn-xs">
                                    <i class="ri-account-pin-box-line"></i>
                                    To Employee
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">tidak ada data</td>
                        </tr>
                    @endforelse
            </table>
        </div>
        <div class="flex flex-col items-center justify-center w-full gap-3 mt-4 align-middle lg:flex-row">
            <div class="w-3/4">
                <label class="flex items-center gap-2 input input-bordered">
                    <input wire:model.live='search' id="searchquery" type="text" class="grow"
                        placeholder="Search" />
                    <kbd class="kbd kbd-sm">ctrl</kbd>
                    <kbd class="kbd kbd-sm">shift</kbd>
                    <kbd class="kbd kbd-sm">K</kbd>
                </label>
            </div>
            <div class="w-1/4">
                {{ $clientUsers->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>
    <dialog id="my_modal_5" wire:ignore.self class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <div class="flex items-center justify-center w-full mt-10 align-middle">
                <div class="flex flex-row gap-7">
                    <div>
                        <img class="w-32 mask mask-squircle" src="{{ asset('images/computercat.jpeg') }}"
                            alt="">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-semibold">{{ $name }}</span>
                        <span>{{ '@' . $username }}</span>
                        <span>{{ $mail }}</span>
                        <span>joined {{ $date }}</span>
                    </div>
                </div>
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">Close</button>
                </form>
            </div>
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
