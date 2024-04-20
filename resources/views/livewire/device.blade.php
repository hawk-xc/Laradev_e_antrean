<div>
    <x-notification-laravel />
    <div class="overflow-x-auto">
        @if (!$devices->isEmpty())
            <label for="my_modal_6" class="btn btn-sm"><i class="ri-add-line"></i> Add device</label>
            <span class="mx-5">
                @if (!empty($checks))
                    <div class="badge badge-secondary badge-outline">{{ count($checks) }} data selected!</div>

                    <button wire:click="bulkDelete" wire:confirm="delete selected data?"
                        class="ml-3 btn btn-outline btn-error btn-sm">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                @endif
            </span>
        @endif
        @if (!$devices->isEmpty())
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="text-lg">
                        <th><i class="ri-list-check-3"></i></th>
                        <th>device name</th>
                        <th>device year</th>
                        <th>added on</th>
                        <th>option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                        <tr class="cursor-pointer hover:bg-gray-50">
                            <th>
                                <input type="checkbox" wire:key="{{ $device->id }}" value="{{ $device->id }}"
                                    wire:model.live='checks' class="checkbox" />
                            </th>
                            <td>{{ $device->device_name }}</td>
                            <td>{{ $device->device_year }}</td>
                            <td>{{ $device->created_at->diffForHumans() }}</td>
                            <td>
                                {{-- <label wire:click="edit({{ $device->id }})" class="btn btn-neutral" --}}
                                <label wire:click.live="add({{ $device->id }})" class="btn btn-neutral"
                                    for="my_modal_6">Edit</label>
                                <label class="btn btn-error"
                                    wire:click.prevent='deleteConfirmation({{ $device->id }})'>
                                    Delete
                                </label>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <span>{{ $devices->links() }}</span>
        @endif
        @if ($devices->isEmpty())
            <div class="py-20 hero">
                <div class="text-center hero-content">
                    <div class="max-w-md">
                        <h1 class="text-5xl font-bold">Hello there</h1>
                        <p class="py-6">Currently the data is still empty, you can add data via the button below!</p>
                        <label for="my_modal_6" class="btn btn-neutral btn-sm"><i class="ri-add-line"></i> Add
                            device</label>
                    </div>
                </div>
            </div>
        @endif

        <!-- Open the modal using ID.showModal() method -->
        <input type="checkbox" id="my_modal_6" class="modal-toggle" />
        <div class="modal" role="dialog" wire:ignore.self>
            <div class="modal-box">
                <h3 class="text-lg font-bold">Edit Device!</h3>
                <div class="flex gap-2 md:flex-row max-sm:flex-col">
                    <label class="w-full max-w-xs form-control">
                        <div class="label">
                            <span class="label-text">Device name?</span>
                        </div>
                        <input type="text" placeholder="Type here" class="w-full max-w-xs input input-bordered"
                            wire:model="device_name" />
                        @error('device_name')
                            <div class="label">
                                <span class="label-text-alt">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>
                    <label class="w-full max-w-xs form-control">
                        <div class="label">
                            <span class="label-text">Device year?</span>
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
                    <button wire:click="create" class="btn btn-neutral">save!</button>
                    <label id="closeButton" for="my_modal_6" class="btn">Close!</label>
                </div>
            </div>
        </div>
    </div>
</div>
