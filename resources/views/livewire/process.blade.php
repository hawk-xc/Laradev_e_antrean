<div>
    {{-- In work, do what you enjoy. --}}
    <div class="overflow-x-auto">
        {{-- @if (!$process->isEmpty())
            <button onclick="my_modal_4.showModal()" wire:click='create' class="btn btn-sm"><i class="ri-add-line"></i> Add
                Process</button>
        @endif --}}

        <x-notification-laravel />

        @if (!$process->isEmpty())
            <table class="table">
                <!-- head -->
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
                            <th>

                                @if ($proces->status_id == 1)
                                    <div class="lg:tooltip" data-tip="currently registered">
                                        <button class="w-32 btn btn-secondary btn-sm"><i class="ri-flag-line"></i>
                                            registered</button>
                                    </div>
                                @elseif ($proces->status_id == 2)
                                    <div class="lg:tooltip" data-tip="vertified your ticket">
                                        <button class="w-32 btn btn-accent btn-sm"><i class="ri-flag-line"></i>
                                            vertified</button>
                                    </div>
                                @elseif ($proces->status_id == 3)
                                    <div class="lg:tooltip" data-tip="process by team">
                                        <button class="w-32 btn btn-info btn-sm"><i class="ri-flag-line"></i>
                                            process</button>
                                    </div>
                                @elseif ($proces->status_id == 4)
                                    <div class="lg:tooltip" data-tip="done">
                                        <button class="w-32 btn btn-success btn-sm"><i class="ri-flag-line"></i>
                                            done</button>
                                    </div>
                                @endif
                            </th>
                            {{-- <td>{{ $proces->device->device_name }}</td> --}}

                            <td>{{ $proces->ticket->device->user->name }}</td>
                            
                            {{-- <td>{{ $proces->ticket->device->device_name }}</td> --}}
                            @if($proces->ticket)
                            <td>{{ optional($proces->ticket->device)->device_name }}</td>
                            @else
                            <td>No device</td>
                            @endif
                            <td>{{ $proces->user->name }}</td>

                            <td>{{ $proces->created_at->diffForHumans() }}</td>
                            <td>
                                <button class="btn btn-warning" onclick="my_modal_4.showModal()"
                                    wire:click="edit({{ $proces->id }})">update</button>

                                {{-- this is delete example --}}
                                
                                {{-- <button type="button" class="btn btn-error"
                                    wire:click.prevent='deleteConfirmation({{ $proces->id }})'>delete</button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <span>{{ $process->links() }}</span>
            
        @endif
        @if ($process->isEmpty())
            <div class="py-20 hero">
                <div class="text-center hero-content">
                    <div class="max-w-md">
                        <h1 class="text-5xl font-bold">Hello there</h1>
                        <p class="py-6">Currently the data is still empty, you can add data via the button below!
                        </p>
                        <button wire:click='create' onclick="my_modal_4.showModal()" class="btn btn-neutral btn-sm"><i
                                class="ri-add-line"></i> Add
                            ticket</button>
                    </div>
                </div>
            </div>
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
