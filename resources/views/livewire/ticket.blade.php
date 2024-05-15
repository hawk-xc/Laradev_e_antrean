<div>
    {{-- In work, do what you enjoy. --}}
    <div class="overflow-x-auto">
        @if (!$tickets->isEmpty())
            <button onclick="my_modal_4.showModal()" wire:click='create' class="btn btn-sm"><i class="ri-add-line"></i>
                Tambah Ticket</button>
        @endif

        <div class="overflow-x-auto" wire:loading>
            <div class="absolute inset-0 flex items-center justify-center bg-gray-200 bg-opacity-75">
                <div class="text-lg text-gray-800 loading loading-infinity loading-lg"></div>
                <div class="text-lg text-gray-800">mohon ditunggu...</div>
            </div>
        </div>

        <x-notification-laravel />
        @if (!$tickets->isEmpty())
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="text-lg">
                        <th><i class="ri-bubble-chart-line"></i></i></th>
                        <th>Nama Perangkat</th>
                        <th class="hidden sm:table-cell">Deskripsi</th>
                        <th class="hidden sm:table-cell">Ditambahkan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr class="cursor-pointer hover:bg-gray-50">
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
                            <td>{{ $ticket->device->device_name }}</td>
                            <td class="hidden sm:table-cell">{{ $ticket->description }}</td>
                            <td class="hidden sm:table-cell">{{ $ticket->created_at->diffForHumans() }}
                            </td>
                            <td class="hidden sm:table-cell">
                                @if ($ticket->proces->status_id < 2)
                                    <button class="px-4 btn btn-neutral" onclick="my_modal_4.showModal()"
                                        wire:click="edit({{ $ticket->id }})">ubah</button>
                                    <button type="button" class="btn btn-error"
                                        wire:click.prevent='deleteConfirmation({{ $ticket->id }})'
                                        {{ $ticket->proces->status_id >= 2 ? 'disabled' : false }}>hapus</button>
                                @else
                                    <button class="btn btn-secondary"><i class="ri-hourglass-line"></i> Tiket
                                        diproses</button>
                                @endif
                            </td>
                            <td class="sm:table-cell md:hidden">
                                @if ($ticket->proces->status_id < 2)
                                    <button class="px-5 btn" onclick="my_modal_4.showModal()"
                                        wire:click="edit({{ $ticket->id }})">
                                        <i class="ri-edit-box-fill"></i>
                                    </button>
                                    <button type="button" class="px-5 btn"
                                        wire:click.prevent='deleteConfirmation({{ $ticket->id }})'>
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                @else
                                    <button class="btn btn-secondary"><i class="ri-hourglass-line"></i> Ticket on
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <span>{{ $tickets->links() }}</span>
        @endif
        @if ($tickets->isEmpty())
            <div class="py-20 hero">
                <div class="text-center hero-content">
                    <div class="max-w-md">
                        <h1 class="text-5xl font-bold">Hallo {{ Auth::user()->username }} </h1>
                        <p class="py-6">Saat ini data masih kosong, Anda dapat menambahkan data melalui tombol di bawah ini!
                        </p>
                        <button wire:click='create' onclick="my_modal_4.showModal()" class="btn btn-neutral btn-sm"><i
                                class="ri-add-line"></i> Tambahkan Tiket</button>
                    </div>
                </div>
            </div>
        @endif

        @if ($openModal)
            @if ($action == 'edit')
                <x-update-form-modal :devices="$devices" />
            @elseif ($action == 'create')
                <x-create-form-modal :devices="$devices" />
            @endif
        @endif

    </div>
    @if (session('notify'))
        <x-notification-laravel :message="session('notify')" />
    @endif

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                // Eksekusi JavaScript setelah Livewire selesai dimuat
                Livewire.on('messageReceived', function(message) {
                    // Tampilkan pesan notifikasi
                    var notification = document.getElementById("notification");
                    var closeButton = document.getElementById("close-button");

                    function showNotification() {
                        // var notification = $("#notification");
                        setTimeout(function() {
                            // notification.addClass("opacity-0");
                            notification.fadeOut('slow');
                        }, 4000);
                    }

                    showNotification()

                    closeButton.on("click", function() {
                        notification.fadeOut('slow');
                        // notification.addClass("opacity-0");
                    });

                    notification.hide();
                });
            });
        </script>
    @endpush
</div>
