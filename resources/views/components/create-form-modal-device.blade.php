        <!-- Open the modal using ID.showModal() method -->
        <input type="checkbox" id="my_modal_6" class="modal-toggle" />
        <div class="modal" role="dialog" wire:ignore.self>
            <div class="modal-box" wire:loading.remove>
                <h3 class="text-lg font-bold">Tambah Perangkat!</h3>
                <div class="flex gap-2 md:flex-row max-sm:flex-col">
                    <label class="w-full max-w-xs form-control">
                        <div class="label">
                            <span class="label-text">Nama Perangkat?</span>
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
                            <span class="label-text">Tahun Perangkat?</span>
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
                        <button wire:click="create" class="btn btn-neutral">Tambah!</button>
                    <label wire:click='close' id="closeButton" for="my_modal_6" class="btn">Tutup!</label>
                </div>
            </div>
        </div>