<div>
    {{-- modal --}}
<dialog id="my_modal_4" class="modal" wire:ignore.self>
    <div class="w-11/12 max-w-5xl modal-box">
        <h3 class="text-lg font-bold">Hello, input update process!</h3>
        <div class="flex flex-col gap-2">
            <form wire:submit='testing'>
                <label class="max-w-xs w-96 form-control">
                    <div class="label">
                        <span class="label-text">Select Status</span>
                        @error('status_id')
                            <span class="label-text-alt">{{ $message }}</span>
                        @enderror
                    </div>
                    <select class="select select-bordered @error('status_id') select-error @enderror" wire:model="status_id">
                        <option selected value="null">Pick one</option>
                        @foreach ($statuses as $status)
                            @if ($status->id === $status_id && \App\Helpers\RoleHelper::isAdmin() )
                            <option selected value="{{ $status_id }}">{{ $status->name }}</option>
                            @else
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </label>
                
                <label class="max-w-xs w-96 form-control">
                    <div class="label">
                        <span class="label-text">Select Employee</span>
                        @error('employe_id')
                            <span class="label-text-alt">{{ $message }}</span>
                        @enderror
                    </div>
                    <select class="select select-bordered @error('employe_id') select-error @enderror" wire:model="employe_id">
                        <option selected value="null">Pick one</option>
                        @foreach ($employees as $employee)
                            @if ($employee->id === $employe_id && \App\Helpers\RoleHelper::isAdmin() )
                                <option selected value="{{ $employee->id }}">{{ $employee->username }}</option>
                            @else
                                <option value="{{ $employee->id }}">{{ $employee->username }}</option>
                            @endif
                        @endforeach
                    </select>
                </label>
                <label class="form-control">
                </label>
            </form>
        </div>
        <div class="modal-action">
            <button type="button" class="btn btn-neutral" wire:click='store'>update</button>
            <form method="dialog" class="flex gap-3">
                <!-- if there is a button, it will close the modal -->
                <button class="btn" wire:click="fresh">Close</button>
            </form>
        </div>
    </div>
</dialog>
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
                {{-- dropdown sorted data --}}
                <details id="dropdown" class=" dropdown">
                    <summary id="sumy" class="m-1 btn"><i class="ri-database-line"></i></i>Sort By </summary>
                    <ul class="p-2 shadow-lg menu dropdown-content z-[1] bg-base-100 rounded-box w-52">
                        <li><a wire:click='sortByDate("desc")'><i class="ri-sort-asc"></i>Newest Process</a></li>
                        <li><a wire:click='sortByDate("asc")'><i class="ri-sort-desc"></i>Oldest Process</a></li>
                    </ul>
                </details>
                
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
                                            <button class="w-32 btn btn-secondary btn-sm"><i class="ri-flag-line"></i> Registrasi</button>
                                        </div>
                                    @elseif ($proces->status_id == 2)
                                        <div class="lg:tooltip" data-tip="verified your ticket">
                                            <button class="w-32 btn btn-accent btn-sm"><i class="ri-flag-line"></i> Verifikasi</button>
                                        </div>
                                    @elseif ($proces->status_id == 3)
                                        <div class="lg:tooltip" data-tip="processed by team">
                                            <button class="w-32 btn btn-info btn-sm"><i class="ri-flag-line"></i> Pengerjaan</button>
                                        </div>
                                    @elseif ($proces->status_id == 4)
                                        <div class="lg:tooltip" data-tip="done">
                                            <button class="w-32 btn btn-success btn-sm"><i class="ri-flag-line"></i> Selesai</button>
                                        </div>
                                    @elseif($proces->status_id==5)
                                        <div class="lg:tooltip" data-tip="ditolak">
                                            <button class="w-32 btn btn-error btn-sm"><i class="ri-flag-line"></i> Ditolak</button>
                                        </div>
                                    @endif
                            </td>
                             <td>{{ $proces->ticket->device->user->name ?? 'null Undefined'}}</td>
                            @if($proces->ticket)
                                <td>{{ optional($proces->ticket->device)->device_name }}</td>
                            @else
                                <td>No device</td>
                            @endif
                            <td>{{ $proces->user->name ?? "Is Null" }}</td>
                            <td>{{ $proces->created_at->diffForHumans() }}</td>
                            <td>
                                @if ($user->role_id == 1)
                                    <button class="btn btn-neutral" onclick="my_modal_4.showModal()" wire:click="edit({{ $proces->id }})" >Ubah</button>
                                @endif
                                @if ($proces->status_id == 1 && $user->role_id == 2)
                                    <button class="btn btn-warning" onclick="my_modal_4.showModal()" wire:click="edit({{ $proces->id }})">Ubah</button>
                                @endif
                                @if ($proces->status_id == 2 && $user->role_id == 3)
                                    <button class="btn btn-secondary" wire:click="processed({{ $proces->id }})">Proses</button>
                                    
                                @endif
                                @if ($proces->status_id == 3 && $user->role_id == 3)
                                    <button class="btn btn-primary" wire:click="done({{ $proces->id }})">Proses Selesai</button>
                                    @elseif ($proces->status_id == 4 && $user->role_id == 3)
                                    <div class="lg:tooltip" data-tip="done bang">
                                        <button class="btn btn-success btn-sm" >Proses Kosong</button>
                                    </div>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <span>{{ $process->links() }}</span>
        @endif

        {{-- @if ($openModal)
            <x-update-status :process="$process" :employees="$employees" :statuses="$statuses" />
        @endif --}}
        



    </div>

    @if (session('notify'))
        <x-notification-laravel :message="session('notify')" />
    @endif

    <script>
                const dropdown = document.querySelector("#dropdown");
                const summary = dropdown.querySelector("summary");

                summary.addEventListener("click", () => {
                    dropdown.classList.toggle("mb-20");
                });
        </script>
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
            <div class="overflow-x-auto" wire:loading>
        <div class="absolute inset-0 flex items-center justify-center bg-gray-200 bg-opacity-75">
            <div class="text-lg text-gray-800 loading loading-infinity loading-lg"></div>
            <div class="text-lg text-gray-800">please wait a moment Loading...</div>
        </div>
    </div>
</div>