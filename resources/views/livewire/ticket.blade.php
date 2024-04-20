<div>
    {{-- In work, do what you enjoy. --}}
    <div class="overflow-x-auto">
        @if (!$tickets->isEmpty())
            <button onclick="my_modal_4.showModal()" wire:click='create' class="btn btn-sm"><i class="ri-add-line"></i> Add
                ticket</button>
        @endif

        <x-notification-laravel />

        @if (!$tickets->isEmpty())
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="text-lg">
                        <th><i class="ri-bubble-chart-line"></i></i></th>
                        <th>Device name</th>
                        <th class="hidden sm:table-cell">Description</th>
                        <th class="hidden sm:table-cell">added on</th>
                        <th>option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr class="cursor-pointer hover:bg-gray-50">
                            <th>
                                @if ($ticket->proces->status_id == 1)
                                    <div class="lg:tooltip" data-tip="currently registered">
                                        <button
                                            class="max-sm:btn-xs sm:btn-xs max-sm:text-[10px] md:w-32 btn btn-secondary btn-sm"><i
                                                class="ri-flag-line max-sm:hidden"></i>
                                            registered</button>
                                    </div>
                                @elseif ($ticket->proces->status_id == 2)
                                    <div class="lg:tooltip" data-tip="vertified your ticket">
                                        <button class="w-32 btn btn-accent btn-sm"><i class="ri-flag-line"></i>
                                            vertified</button>
                                    </div>
                                @elseif ($ticket->proces->status_id == 3)
                                    <div class="lg:tooltip" data-tip="process by team">
                                        <button class="w-32 btn btn-info btn-sm"><i class="ri-flag-line"></i>
                                            process</button>
                                    </div>
                                @elseif ($ticket->proces->status_id == 4)
                                    <div class="lg:tooltip" data-tip="done">
                                        <button class="w-32 btn btn-success btn-sm"><i class="ri-flag-line"></i>
                                            done</button>
                                    </div>
                                @endif
                            </th>
                            <td>{{ $ticket->device->device_name }}</td>
                            <td class="hidden sm:table-cell">{{ $ticket->description }}</td>
                            <td class="hidden sm:table-cell">{{ $ticket->created_at->diffForHumans() }}
                            </td>
                            <td class="hidden sm:table-cell">
                                <button class="btn btn-neutral" onclick="my_modal_4.showModal()"
                                    wire:click="edit({{ $ticket->id }})">edit</button>

                                {{-- this is delete example --}}
                                <button type="button" class="btn btn-error"
                                    wire:click.prevent='deleteConfirmation({{ $ticket->id }})'>delete</button>
                            </td>
                            <td class="sm:table-cell md:hidden">
                                <button class="btn btn-sm" onclick="my_modal_4.showModal()"
                                    wire:click="edit({{ $ticket->id }})">
                                    <i class="ri-edit-box-fill"></i>
                                </button>
                                <button type="button" class="btn btn-sm"
                                    wire:click.prevent='deleteConfirmation({{ $ticket->id }})'>
                                    <i class="ri-delete-bin-fill"></i>
                                </button>
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
