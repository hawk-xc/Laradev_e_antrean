<div class="flex flex-row gap-5 m-4">
    {{-- notification pack --}}
    <x-notification-laravel />
    @if (session('notify'))
        <x-notification-laravel :message="session('notify')" />
    @endif

    <div class="w-4/12 py-5 overflow-y-scroll border rounded-md shadow-md h-[27rem] px-7 border-slate-200">
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
                        <div class="text-sm opacity-90">
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
        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                @if (!$clientUsers->isEmpty())
                    <thead>
                        <tr class="p-2 rounded-md bg-slate-200">
                            <th class="cursor-pointer hover:underline" wire:click='sortname'>Client Name <i
                                    class="ri-expand-up-down-line"></i></th>
                            <th class="cursor-pointer hover:underline" wire:click='sortdate'>Joined <i
                                    class="ri-expand-up-down-line"></i></th>
                            <th>Option</th>
                        </tr>
                    </thead>
                @endif
                <tbody>
                    @forelse ($clientUsers as $user)
                        <tr>
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
                            </th>
                        </tr>
                    @empty
                        <div class="py-20 hero">
                            <div class="text-center hero-content">
                                <div class="max-w-md">
                                    <h1 class="text-5xl font-bold">Hello there</h1>
                                    <p class="py-6">Currently the data is still empty!
                                    </p>
                                </div>
                            </div>
                        </div>
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
            <span class="font-semibold text-md">User profile</span>
            <div class="flex items-center justify-center w-full mt-10 align-middle">
                <div class="flex flex-row gap-7">
                    <div>
                        <img class="w-32 mask mask-squircle" src="{{ asset($user_image) }}" alt="">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-semibold">{{ $name }}</span>
                        <span><i class="ri-at-line"></i> {{ $username }}</span>
                        <span><i class="ri-phone-line"></i> {{ $phone }}</span>
                        <span><i class="ri-mail-line"></i> {{ $mail }}</span>
                        <span class="text-sm badge badge-ghost">joined {{ $date }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-between mt-16 modal-action">
                <div>
                    <button class="btn btn-sm btn-ghost" wire:click.prevent='makeTechnician'>make technician</button>
                    <button class="btn btn-sm btn-ghost" wire:click.prevent='makeHelpdesk'>make helpdesk</button>
                </div>
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button id="closeButton" class="btn btn-sm">Close</button>
                </form>
            </div>
        </div>
        <div wire:loading class="absolute flex flex-col justify-center m-10 text-lg align-middle text-slate-800">
            <span class="block mx-auto mt-10 loading loading-infinity loading-lg"></span>
            <span class="block mx-auto mb-10">please wait a moment...</span>
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
