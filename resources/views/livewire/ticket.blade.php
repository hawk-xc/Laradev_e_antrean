<div>
    <x-notification-laravel />

    <div wire:loading class="absolute flex flex-col justify-center m-10 text-lg text-white align-middle">
        <span class="block mx-auto mt-10 loading loading-infinity loading-lg"></span>
        <span class="block mx-auto mb-10">please wait a moment...</span>
    </div>

    <div class="overflow-x-auto">
        @if (!$devices->isEmpty())
            <button class="btn max-sm:btn-xs" onclick="createModal.showModal()" wire:click='insert_testing'>
                tambah antrean <i class="ri-add-line"></i>
            </button>
        @endif

        @if (!$devices->isEmpty())
            <table class="table max-sm:text-xs">
                <!-- head -->
                <thead>
                    <tr class="text-lg">
                        <th>no tiket</th>
                        <th>status</th>
                        <th class="hidden sm:table-cell">nama perangkat</th>
                        <th class="hidden sm:table-cell">ditambahkan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $key => $ticket)
                        <tr class="cursor-pointer bg-gray-50 hover:bg-gray-100" onclick="editModal.showModal()"
                            wire:click='edit_testing({{ $ticket->id }})'>
                            <th
                                class="bg-gradient-to-r {{ $ticket->proces->status_id == 5 ? 'from-red-400 to-red-200' : 'from-sky-400 to-sky-200' }} rounded-r-full text-xl text-white">
                                tiket#{{ $ticket->id_ticket }}</th>
                            <th>
                                @if ($ticket->proces->status_id == 1)
                                    <div class="lg:tooltip" data-tip="currently registered">
                                        <button class="w-32 btn btn-secondary btn-sm"><i
                                                class="ri-flag-line max-sm:hidden"></i>
                                            registrasi</button>
                                    </div>
                                @elseif ($ticket->proces->status_id == 2)
                                    <div class="lg:tooltip" data-tip="vertified your ticket">
                                        <button class="w-32 btn btn-accent btn-sm"><i class="ri-flag-line"></i>
                                            vertifikasi</button>
                                    </div>
                                @elseif ($ticket->proces->status_id == 3)
                                    <div class="lg:tooltip" data-tip="process by team">
                                        <button class="w-32 btn btn-info btn-sm"><i class="ri-flag-line"></i>
                                            proses</button>
                                    </div>
                                @elseif ($ticket->proces->status_id == 4)
                                    <div class="lg:tooltip" data-tip="done">
                                        <button class="w-32 btn btn-success btn-sm"><i class="ri-flag-line"></i>
                                            selesai</button>
                                    </div>
                                @elseif ($ticket->proces->status_id == 5)
                                    <div class="lg:tooltip" data-tip="rejected">
                                        <button class="w-32 btn btn-error btn-sm"><i class="ri-flag-line"></i>
                                            ditolak</button>
                                    </div>
                                @endif
                            </th>
                            <td class="hidden sm:table-cell"><i class="ri-device-line"></i>
                                {{ $ticket->device->device_name }}</td>
                            <td class="hidden sm:table-cell"><i class="ri-calendar-schedule-line"></i>
                                {{ $ticket->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <span class="flex flex-row items-center gap-4 my-10 align-middle">
                <p class="inline text-xs font-light">
                    <i class="ri-database-2-line"></i> menampilkan
                    {{ $loadCount > $tickets->count() ? $tickets->count() : $loadCount }}
                    dari
                    {{ \App\Models\Ticket::where('device_id', \App\Models\Device::where('user_id', Auth::user()->id)->pluck('id'))->count() }}
                    perangkat
                </p>

                @if ($tickets->count() >= 10)
                    <button wire:click='loadAll'
                        class="btn btn-xs btn-neutral {{ $tickets->count() > 10 ? 'hidden' : '' }}">
                        tampilkan semua
                    </button>
                @endif

                @if (
                    $loadCount ==
                        \App\Models\Ticket::where(
                            'device_id',
                            \App\Models\Device::where('user_id', Auth::user()->id)->pluck('id'))->count())
                    <button wire:click='loadAllLess' class="btn btn-xs btn-neutral">
                        sembunyikan semua
                    </button>
                @endif

                @if (
                    $loadCount <
                        \App\Models\Ticket::where(
                            'device_id',
                            \App\Models\Device::where('user_id', Auth::user()->id)->pluck('id'))->count())
                    <button wire:click='loadMore(5)' class="btn btn-xs btn-neutral">+ 5 lebih</button>
                @endif
                @if ($loadCount > 5)
                    <button wire:click='loadLess(5)' class="btn btn-xs btn-neutral">- 5 kurang</button>
                @endif
            </span>
        @endif
        @if ($devices->isEmpty())
            <div class="py-20 hero">
                <div class="text-center hero-content">
                    <div class="max-w-md">
                        <h1 class="text-5xl font-bold">Hello there</h1>
                        <p class="py-6">Currently the data is still empty, you can add data via the button below!</p>
                        <button class="btn max-sm:btn-xs btn-neutral" onclick="createModal.showModal()"
                            wire:click='insert_testing'>
                            <i class="ri-menu-search-line"></i> tambah tiket <i class="ri-add-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <dialog id="editModal" class="modal" wire:ignore.self>
            <div class="modal-box">
                <h3 class="text-lg font-bold">Edit data tiket!</h3>
                <div class="w-full p-5 my-3 text-xs rounded-md bg-stone-100">
                    <span class="font-semibold text-md"><i class="ri-information-2-line"></i> perhatian</span>
                    <ul class="pl-4 mt-2 list-disc">
                        <li>pastikan menambahkan perangkat yang anda pilih benar</li>
                        <li>berikan deskripsi yang jelas untuk kendala yang dialami</li>
                        <li>apabila status tiket ditutup anda tidak bisa memulihkan kembali</li>
                        <li>anda dapat melakukan perubahan tiket apabila status tiket belum diverifikasi oleh tim kami
                        </li>
                    </ul>
                </div>

                {{-- form in here --}}
                <label class="hidden w-full form-control">
                    <div class="label">
                        <span class="label-text">Id tiket</span>
                    </div>
                    <input id="ticketIdForm" disabled type="number" placeholder="Type here"
                        class="w-full input input-bordered" />
                </label>
                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">Id tiket</span>
                    </div>
                    <input id="idTicket" disabled type="number" placeholder="Type here"
                        class="w-full input input-bordered" />
                </label>
                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">terakhir update</span>
                    </div>
                    <input id="ticketLastUpdateForm" disabled type="text" placeholder="Type here"
                        class="w-full input input-bordered" />
                </label>
                <label class="w-full form-control">
                    <label class="w-full form-control">
                        <div class="label">
                            <span class="label-text">id perangkat</span>
                            @error('device_id')
                                <span class="label-text-alt">{{ $message }}</span>
                            @enderror
                        </div>
                        <select
                            class="select select-bordered @error('device_id')
                        select-error
                        @enderror"
                            wire:model="device_id">
                            <option selected value="null">Pilih salah satu</option>
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}" {{ $device->id == $device_id ? 'selected' : '' }}>
                                    {{ $device->device_name }}</option>
                            @endforeach
                        </select>
                    </label>
                </label>
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Deskripsi kendala</span>
                        @error('description')
                            <span class="label-text-alt">{{ $message }}</span>
                        @enderror
                    </div>
                    <textarea id="ticketDescriptionForm" wire:model="description"
                        class="h-36 textarea textarea-bordered @error('description') textarea-warning @enderror" rows="3"
                        placeholder="Deskripsi..."></textarea>
                </label>

                <div class="flex flex-row justify-between modal-action">
                    <label class="btn btn-error max-sm:btn-xs" wire:click.prevent='deleteConfirmation'>
                        <i class="ri-inbox-archive-line"></i> Tutup
                    </label>
                    <span class="flex flex-row gap-3">
                        <button class="btn btn-neutral max-sm:btn-xs" wire:click='update_testing'><i
                                class="ri-check-line"></i>
                            perbahrui</button>
                        <form method="dialog" class="flex flex-row gap-3">
                            <!-- if there is a button in form, it will close the modal -->
                            <button id="closeButton" class="btn max-sm:btn-xs" wire:click='fresh'><i
                                    class="ri-arrow-go-back-line"></i>
                                Batal</button>
                        </form>
                    </span>
                </div>
            </div>
        </dialog>
        <dialog id="createModal" class="modal" wire:ignore.self>
            <div class="modal-box">
                <h3 class="text-lg font-bold">Tambah data tiket!</h3>
                <div class="w-full p-5 my-3 text-xs rounded-md bg-stone-100">
                    <span class="font-semibold text-md"><i class="ri-information-2-line"></i> perhatian</span>
                    <ul class="pl-4 mt-2 list-disc">
                        <li>pastikan menambahkan perangkat yang anda pilih benar</li>
                        <li>berikan deskripsi yang jelas untuk kendala yang dialami</li>
                    </ul>
                </div>
                {{-- form in here --}}

                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">pilih perangkat</span>
                    </div>

                    <select
                        class="select select-bordered @error('device_id')
                    select-error
                    @enderror"
                        wire:model="device_id">
                        <option selected value="null">Pilih salah satu</option>
                        @foreach ($devices as $device)
                            <option value="{{ $device->id }}">{{ $device->device_name }}</option>
                        @endforeach
                    </select>
                    @error('device_id')
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    @enderror
                </label>

                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">Deskripsi kendala</span>
                    </div>

                    <textarea id="ticketDescriptionForm" wire:model="description"
                        class="h-36 textarea textarea-bordered @error('description') textarea-warning @enderror" rows="3"
                        placeholder="Deskripsi..."></textarea>
                    @error('description')
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    @enderror
                </label>
                {{-- form in here --}}

                <div class="flex flex-row modal-action">
                    <span class="flex flex-row gap-3">
                        <button class="btn btn-neutral max-sm:btn-xs" wire:click='store_testing'><i
                                class="ri-edit-line"></i>
                            simpan</button>
                        <form method="dialog" class="flex flex-row gap-3">
                            <!-- if there is a button in form, it will close the modal -->
                            <button id="closeModal" class="btn max-sm:btn-xs" wire:click='fresh'><i
                                    class="ri-arrow-go-back-line"></i>
                                Batal</button>
                        </form>
                    </span>
                </div>
            </div>
        </dialog>
    </div>
</div>
