<div>
    <dialog id="my_modal_4" class="modal" wire:ignore.self>
        <div class="modal-box">
            <h3 class="text-lg font-bold">Hello!</h3>
            <div class="flex flex-col gap-2">
                <form wire:submit='testing'>
                    <label class="w-full max-w-xs form-control">
                        <div class="label">
                            <span class="label-text">Device name?</span>
                        </div>
                        <input type="text" placeholder="Type here" class="w-full max-w-xs input input-bordered"
                            wire:model="device_name" value="{{ $device_name }}" />
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
                </form>
            </div>
            <div class="modal-action">

                <div class="modal-action">
                    <button wire:click="store" class="btn btn-neutral">update!</button>
                    <form method="dialog" class="flex gap-3">
                        <!-- if there is a button, it will close the modal -->
                        <button id="closeButton" class="btn" wire:click='close'
                            wire:loading.attr="disabled">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </dialog>
</div>
