<dialog id="my_modal_4" class="modal" wire:ignore.self>
    <div class="w-11/12 max-w-5xl modal-box">
        <h3 class="text-lg font-bold">Hello!</h3>
        <div class="flex flex-col gap-2">
            <label class="max-w-xs w-96 form-control">
                <div class="label">
                    <span class="label-text">Select Device</span>
                    @error('device_id')
                        <span class="label-text-alt">{{ $message }}</span>
                    @enderror
                </div>
                <select
                    class="select select-bordered @error('device_id')
                select-error
                @enderror"
                    wire:model="device_id">
                    <option selected value="null">Pick one</option>
                    @foreach ($devices as $device)
                        <option value="{{ $device->id }}">{{ $device->device_name }}</option>
                    @endforeach
                </select>
            </label>
            <label class="form-control">
                <div class="label">
                    <span class="label-text">Description</span>
                    @error('description')
                        <span class="label-text-alt">{{ $message }}</span>
                    @enderror
                </div>
                <textarea wire:model="description"
                    class="h-36 textarea textarea-bordered @error('description')
textarea-warning
@enderror" rows="3"
                    placeholder="Description..."></textarea>
                {{-- <input type="text" @if ($isEdit) value="{{ $description }}" @endif> --}}
            </label>
            <input type="text" wire:model='description'>
        </div>
        <div class="modal-action">
            <button class="btn btn-neutral" wire:click="edit()">update</button>
            <form method="dialog" class="flex gap-3">
                <!-- if there is a button, it will close the modal -->
                <button class="btn" wire:click="fresh">Close</button>
            </form>
        </div>
    </div>
</dialog>
