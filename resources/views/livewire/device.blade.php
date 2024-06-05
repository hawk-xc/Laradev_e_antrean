<div>
    <x-notification-laravel />

    <div wire:loading class="absolute flex flex-col justify-center m-10 text-lg text-white align-middle">
        <span class="block mx-auto mt-10 loading loading-infinity loading-lg"></span>
        <span class="block mx-auto mb-10">please wait a moment...</span>
    </div>

    <div class="overflow-x-auto">
        @if (!$devices->isEmpty())
            <button class="btn max-sm:btn-xs" onclick="createModal.showModal()" wire:click='insert_testing'>
                tambah perangkat <i class="ri-add-line"></i>
            </button>
        @endif

        @if (!$devices->isEmpty())
            <table class="table max-sm:text-xs">
                <!-- head -->
                <thead>
                    <tr class="text-lg">
                        <th><i class="ri-hashtag"></i></th>
                        <th>nama perangkat</th>
                        <th class="hidden sm:table-cell">tahun perangkat</th>
                        <th class="hidden sm:table-cell">ditambahkan pada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $key => $device)
                        <tr class="cursor-pointer hover:bg-gray-50" onclick="editModal.showModal()"
                            wire:click='edit_testing({{ $device->id }})'>
                            <th>
                                {{ $key + 1 }}
                            </th>
                            <td>{{ $device->device_name }}</td>
                            <td class="hidden sm:table-cell">{{ $device->device_year }}</td>
                            <td class="hidden sm:table-cell">{{ $device->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <span class="flex flex-row gap-4 align-middle items-center my-10">
                <p class="inline text-xs font-light">
                    <i class="ri-database-2-line"></i> menampilkan
                    {{ $loadCount > \App\Models\Device::where('user_id', Auth::user()->id)->count() ? \App\Models\Device::where('user_id', Auth::user()->id)->count() : $loadCount }}
                    dari {{ \App\Models\Device::where('user_id', Auth::user()->id)->count() }} perangkat
                </p>

                @if ($loadCount < \App\Models\Device::where('user_id', Auth::user()->id)->count())
                    <button wire:click='loadMore(5)' class="btn btn-xs btn-neutral">+ 5 lebih</button>
                @endif
                @if ($loadCount > 5)
                    <button wire:click='loadLess(5)' class="btn btn-xs btn-neutral">- 5 kurang</button>
                @endif
                @if ($loadCount <= 5)
                    <button wire:click='loadAll({{ Auth::user()->id }})'
                        class="btn btn-xs btn-neutral {{ \App\Models\Device::where('user_id', Auth::user()->id)->count() < 10 ? 'hidden' : '' }}">
                        tampilkan semua
                    </button>
                @endif
                @if ($loadCount >= \App\Models\Device::where('user_id', Auth::user()->id)->count())
                    <button wire:click='loadAllLess'
                        class="btn btn-xs btn-neutral {{ \App\Models\Device::where('user_id', Auth::user()->id)->count() < 10 ? 'hidden' : '' }}">
                        sembunyikan semua
                    </button>
                @endif
            </span>
        @endif
        @if ($devices->isEmpty())
            <div class="py-20 hero">
                <div class="text-center hero-content">
                    <div class="max-w-md">
                        <h1 class="text-5xl font-bold">Hallo!</h1>
                        <p class="py-6">Saat ini data masih kosong, Anda dapat menambahkan data melalui tombol di
                            bawah ini!</p>
                        <button class="btn max-sm:btn-xs btn-neutral" onclick="createModal.showModal()"
                            wire:click='insert_testing'>
                            <i class="ri-menu-search-line"></i> tambah perangkat <i class="ri-add-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <dialog id="editModal" class="modal" wire:ignore.self>
            <div class="modal-box">
                <h3 class="text-lg font-bold">Edit data perangkat!</h3>
                <div class="w-full p-5 my-3 text-xs rounded-md bg-stone-100">
                    <span class="font-semibold text-md"><i class="ri-information-2-line"></i> perhatian</span>
                    <ul class="pl-4 mt-2 list-disc">
                        <li>pastikan merubah nama perangkat anda dengan lengkap, merk dan type</li>
                        <li>pastikan tahun produksi laptop anda dengan benar</li>
                        <li>data perangkat yang anda inputkan akan menjadi pertimbangan kami untuk menentukan metode
                            perbaikan
                        </li>
                    </ul>
                </div>

                @if ($device_image != '-')
                    <div class="">
                        <img id="preview" src="storage/device_assets/{{ $device_image }}" class="my-1 rounded-lg">
                    </div>
                @endif

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
                        placeholder="Nama perangkat" class="w-full input input-bordered" />
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
                    <input id="deviceYearForm" wire:model='device_year' wire:loading.attr='disabled' type="text"
                        placeholder="Tahun perangkat" class="w-full input input-bordered" />
                    @error('device_year')
                        <div class="label">
                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                        </div>
                    @enderror
                </label>
                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">File pendukung</span>
                    </div>
                    <input id="driveLinkForm" wire:model='drive_link' type="text"
                        placeholder="contoh. https://drive.google.com/file/d/contoh-gambar-&-video-drive"
                        class="w-full input input-bordered" wire:loading.attr='disabled' />
                    @error('drive_link')
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

                <div class="">
                    <img id="preview" src="" class="my-1 rounded-lg" wire:ignore.self>
                </div>

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">sematkan gambar</span>
                    </div>
                    <input type="file" wire:model="device_image" class="file-input file-input-bordered w-full"
                        id="imageInput" accept="image/*" />
                    <div class="label">
                        <span class="label-text-alt">gambar format yang didukung : <i>jpg, jpeg, png</i></span>
                    </div>
                    @error('device_image')
                        <div class="label">
                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                        </div>
                    @enderror
                    <div wire:loading wire:target="device_image" class="text-sm text-gray-500 italic">Uploading...
                    </div>
                </label>

                {{-- form in here --}}
                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">Nama perangkat</span>
                    </div>
                    <input id="deviceNameForm" wire:model='device_name' wire:load.attr='disabled' type="text"
                        placeholder="Nama perangkat" class="w-full input input-bordered" />
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
                    <input id="deviceYearForm" wire:model='device_year' type="text" placeholder="Tahun perangkat"
                        class="w-full input input-bordered" wire:loading.attr='disabled' />
                    @error('device_year')
                        <div class="label">
                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                        </div>
                    @enderror
                </label>

                <label class="w-full form-control">
                    <div class="label">
                        <span class="label-text">Dokumentasi pendukung</span>
                    </div>
                    <input id="driveLinkForm" wire:model='drive_link' type="text"
                        placeholder="contoh. https://drive.google.com/file/d/contoh-gambar-&-video-drive"
                        class="w-full input input-bordered" wire:loading.attr='disabled' />
                    @error('drive_link')
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
    </div>
</div>
