<div>
    <x-notification-laravel />

    <div class="overflow-x-auto">
        @if (!$devices->isEmpty())
            <button class="btn max-sm:btn-xs" onclick="createModal.showModal()" wire:click='insert_testing'>
                <i class="ri-menu-search-line"></i> tambah perangkat <i class="ri-add-line"></i>
            </button>
        @endif

        @if (!$devices->isEmpty())
            <table class="table max-sm:text-xs">
                <!-- head -->
                <thead>
                    <tr class="text-lg">
                        <th><i class="ri-hashtag"></i></th>
                        <th>device name</th>
                        <th class="hidden sm:table-cell">device year</th>
                        <th class="hidden sm:table-cell">added on</th>
                        <th>option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $key => $device)
                        <tr class="cursor-pointer hover:bg-gray-50">
                            <th>
                                {{ $key + 1 }}
                            </th>
                            <td>{{ $device->device_name }}</td>
                            <td class="hidden sm:table-cell">{{ $device->device_year }}</td>
                            <td class="hidden sm:table-cell">{{ $device->created_at->diffForHumans() }}</td>
                            <td class="">
                                {{-- <label wire:click="edit({{ $device->id }})" class="btn btn-neutral" --}}
                                <button class="btn max-sm:btn-xs" onclick="editModal.showModal()"
                                    wire:click='edit_testing({{ $device->id }})'>
                                    <i class="ri-menu-search-line"></i> lihat!
                                </button>
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

        <dialog id="editModal" class="modal" wire:ignore.self>
            <div class="modal-box">
                <h3 class="text-lg font-bold">Edit data perangkat!</h3>

                {{-- form in here --}}
                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">Id perangkat</span>
                    </div>
                    <input id="deviceIdForm" disabled type="number" placeholder="Type here"
                        class="w-full input input-bordered" />
                </label>
                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">terakhir update</span>
                    </div>
                    <input id="deviceLastUpdateForm" disabled type="text" placeholder="Type here"
                        class="w-full input input-bordered" />
                </label>
                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">Nama perangkat</span>
                    </div>
                    <input id="deviceNameForm" wire:model='device_name' wire:load.attr='disabled' type="text"
                        placeholder="Type here" class="w-full input input-bordered" />
                    @error('device_name')
                        <div class="label">
                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                        </div>
                    @enderror
                </label>
                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">Tahun perangkat</span>
                    </div>
                    <input id="deviceYearForm" wire:model='device_year' type="text" placeholder="Type here"
                        class="w-full input input-bordered" />
                    @error('device_year')
                        <div class="label">
                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                        </div>
                    @enderror
                </label>
                {{-- form in here --}}

                <div class="flex flex-row justify-between modal-action">
                    <label class="btn btn-error max-sm:btn-xs" wire:click.prevent='deleteConfirmation'>
                        <i class="ri-delete-bin-7-line"></i> Delete
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
                <h3 class="text-lg font-bold">tambah data perangkat!</h3>
                <div class="w-full p-5 my-3 text-xs rounded-md bg-stone-100">
                    <span class="font-semibold text-md"><i class="ri-information-2-line"></i> perhatian</span>
                    <ul class="pl-4 mt-2 list-disc">
                        <li>pastikan menambahkan nama perangkat anda dengan lengkap, merk dan type</li>
                        <li>pastikan tahun produksi laptop anda dengan benar</li>
                        <li>data perangkat yang anda inputkan akan menjadi pertimbangan kami untuk menentukan metode
                            perbaikan
                        </li>
                    </ul>
                </div>
                {{-- form in here --}}
                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">Nama perangkat</span>
                    </div>
                    <input id="deviceNameForm" wire:model='device_name' wire:load.attr='disabled' type="text"
                        placeholder="Type here" class="w-full input input-bordered" />
                    @error('device_name')
                        <div class="label">
                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                        </div>
                    @enderror
                </label>
                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">Tahun perangkat</span>
                    </div>
                    <input id="deviceYearForm" wire:model='device_year' type="text" placeholder="Type here"
                        class="w-full input input-bordered" />
                    @error('device_year')
                        <div class="label">
                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                        </div>
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
        <div wire:loading class="absolute flex flex-col justify-center m-10 text-lg text-white align-middle">
            <span class="block mx-auto mt-10 loading loading-infinity loading-lg"></span>
            <span class="block mx-auto mb-10">please wait a moment...</span>
        </div>
    </div>
</div>
