<div class="w-full flex flex-row max-sm:flex-col gap-3 mt-5">
    <x-notification-laravel />

    <div class="px-10 py-2 flex flex-col gap-2 h-60 aspect-square align-middle items-center max-sm:hidden">
        <button class="btn {{ $userpanel ? 'btn-neutral' : '' }} text-xs w-full" wire:click="userPanel"><i
                class="ri-user-2-line"></i> ruang pegawai</button>
        <button class="btn {{ !$userpanel ? 'btn-neutral' : '' }} text-xs w-full" wire:click="userPanelClient"><i
                class="ri-user-3-line"></i> ruang pelanggan</button>
    </div>
    <div class="w-full flex justify-end items-end align-middle md:hidden">
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn m-1">pilih data</div>
            <ul tabindex="0" class="dropdown-content z-[1] flex gap-3 menu p-2 shadow bg-base-100 rounded-box w-52">
              <li class="cursor-pointer btn {{ $userpanel ? 'btn-neutral' : '' }}" wire:click='userPanel'><a><i
                class="ri-user-2-line"></i> ruang pegawai</a></li>
              <li class="cursor-pointer btn {{ !$userpanel ? 'btn-neutral' : '' }}" wire:click='userPanelClient'><a><i
                class="ri-user-3-line"></i> ruang pelanggan</a></li>
            </ul>
          </div>
    </div>
    <div class="shadow-md rounded-lg md:p-10 w-full border border-slate-200">
        @if ($userpanel)
            <div class="flex flex-col gap-3">
                @foreach ($coreUsers as $user)
                    <div wire:click='detail({{ $user->id }})' onclick="my_modal_5.showModal()"
                        class="flex flex-row justify-between hover:bg-slate-50 cursor-pointer p-4 shadow-md border border-slate-100 rounded-xl align-middle items-center">
                        <span class="flex flex-row gap-4">
                            <span>
                                <img class="w-12 rounded-full" src="{{ $user->user_image }}"
                                    alt="{{ $user->name }} image">
                            </span>
                            <span class="flex flex-col">
                                <span class="text-md">{{ $user->name }}</span>
                                <span class="text-xs italic">{{ '@' . $user->username }} </span>
                            </span>
                        </span>
                        <span>
                            <button class="badge badge-neutral">{{ $user->role->name }}</button>
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div>
                <div>
                    <div class="w-full max-sm:hidden py-3">
                        <label class="flex items-center gap-2 input input-bordered">
                            <input wire:model.live='search' id="searchquery" type="text" class="grow"
                                placeholder="Cari berdasarkan username atau nama..." />
                            <kbd class="kbd kbd-sm">ctrl</kbd>
                            <kbd class="kbd kbd-sm">shift</kbd>
                            <kbd class="kbd kbd-sm">K</kbd>
                        </label>
                    </div>
                    <table class="table text-xs">
                        <!-- head -->
                        @if (!$clientUsers->isEmpty())
                            <thead>
                                <tr class="p-2 rounded-md bg-slate-200">
                                    <th class="cursor-pointer hover:underline" wire:click='sortname'>Nama Pelanggan <i
                                            class="ri-expand-up-down-line"></i></th>
                                    <th><i class="ri-phone-line"></i> Telepon</th>
                                    <th class="hidden cursor-pointer hover:underline sm:table-cell"
                                        wire:click='sortdate'>
                                        Ditambahkan
                                        <i class="ri-expand-up-down-line"></i>
                                    </th>
                                </tr>
                            </thead>
                        @endif
                        <tbody>
                            @forelse ($clientUsers as $user)
                                <tr class="hover:bg-slate-50 cursor-pointer" wire:click='detail({{ $user->id }})'
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
            </div>
            @if (!$search)
                        <span class="flex my-5 flex-row max-sm:flex-col gap-4 align-middle items-center justify-between">
                            <p class="inline text-xs font-light">
                                menampilkan
                                {{ $loadCount > \App\Models\User::where('role_id', '=', '4')->count() ? \App\Models\User::where('role_id', '=', '4')->count() : $loadCount }}
                                dari {{ \App\Models\User::where('role_id', '=', '4')->count() }}
                            </p>
                            <span>
                                @if ($loadCount < \App\Models\User::where('role_id', '=', '4')->count())
                                    <button wire:click='loadMore(5)' class="btn btn-xs btn-neutral">+ 5 lebih</button>
                                @endif
                                @if ($loadCount > 5)
                                    <button wire:click='loadLess(5)' class="btn btn-xs btn-neutral">- 5 kurang</button>
                                @endif
                                @if ($loadCount <= 5)
                                    <button wire:click="loadAll" class="btn btn-xs btn-neutral">
                                        tampilkan semua
                                    </button>
                                @endif
                                @if ($loadCount >= \App\Models\User::where('role_id', '=', '4')->count())
                                    <button wire:click='loadAllLess' class="btn btn-xs btn-neutral">
                                        sembunyikan semua
                                    </button>
                                @endif
                            </span>
                        </span>
                    @endif
        @endif
    </div>
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
</div>
