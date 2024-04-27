<div>
    {{-- In work, do what you enjoy. --}}
    <div class="overflow-x-auto">
        @if ($process->isEmpty())
            <div class="py-20 hero">
                <div class="text-center hero-content">
                    <div class="max-w-md">
                        <h1 class="text-5xl font-bold">Hello there</h1>
                        <p class="py-6">Currently the data is still empty, Done bang!</p>
                        {{-- <button wire:click='create' onclick="my_modal_4.showModal()" class="btn btn-neutral btn-sm"><i class="ri-add-line"></i> Add ticket</button> --}}
                        <button class="btn btn-neutral btn-sm">No Antrean<i class="text-xl ri-check-double-line"></i></button>
                        <h1></h1>
                    </div>
                </div>
            </div>
        @else
            <x-notification-laravel />
            <table class="table">
                <thead>
                    <tr class="text-lg">
                        <th><i class="ri-bubble-chart-line"></i> Status</th>
                        <th>Customer name</th>
                        <th>Device Name</th>
                        <th>Employee Name</th>
                        <th>Added on</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($process as $proces)
                        <tr class="cursor-pointer hover:bg-gray-50">
                            <td>
                                    @if ($proces->status_id == 1)
                                        <div class="lg:tooltip" data-tip="currently registered">
                                            <button class="w-32 btn btn-secondary btn-sm"><i class="ri-flag-line"></i> registered</button>
                                        </div>
                                    @elseif ($proces->status_id == 2)
                                        <div class="lg:tooltip" data-tip="verified your ticket">
                                            <button class="w-32 btn btn-accent btn-sm"><i class="ri-flag-line"></i> verified</button>
                                        </div>
                                    @elseif ($proces->status_id == 3)
                                        <div class="lg:tooltip" data-tip="processed by team">
                                            <button class="w-32 btn btn-info btn-sm"><i class="ri-flag-line"></i> process</button>
                                        </div>
                                    @elseif ($proces->status_id == 4)
                                        <div class="lg:tooltip" data-tip="done">
                                            <button class="w-32 btn btn-success btn-sm"><i class="ri-flag-line"></i> done</button>
                                        </div>
                                    @endif
                            </td>
                             <td>{{ $proces->ticket->device->user->name ?? 'null Undefined'}}</td>
                            @if($proces->ticket)
                                <td>{{ optional($proces->ticket->device)->device_name }}</td>
                            @else
                                <td>No device</td>
                            @endif
                            <td>{{ $proces->user->name }}</td>
                            <td>{{ $proces->created_at->diffForHumans() }}</td>
                            <td>
                                @if ($proces->status_id == 1 && $user->role_id == 1)
                                    <button class="btn btn-warning" onclick="my_modal_4.showModal()" wire:click="edit({{ $proces->id }})">update</button>
                                @endif
                                @if ($proces->status_id == 2 && $user->role_id == 2)
                                    <button class="btn btn-secondary" onclick="my_modal_4.showModal()" wire:click="processed({{ $proces->id }})">Process</button>
                                @endif
                                @if ($proces->status_id == 3 && $user->role_id == 2)
                                    <button class="btn btn-primary" onclick="my_modal_4.showModal()" wire:click="done({{ $proces->id }})">Done</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <span>{{ $process->links() }}</span>
        @endif

        @if ($openModal)
            @if ($action == 'edit')
                <x-update-status :process="$process" :employees="$employees" :statuses="$statuses" />
            @elseif ($action == 'create')
                {{-- <x-create-form-modal :process="$process" :employees="$employees" :devices="$devices" /> --}}
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
                        setTimeout(function() {
                            notification.fadeOut('slow');
                        }, 4000);
                    }

                    showNotification()

                    closeButton.on("click", function() {
                        notification.fadeOut('slow');
                    });

                    notification.hide();
                });
            });
        </script>
    @endpush
</div>
