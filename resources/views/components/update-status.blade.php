<dialog id="my_modal_4" class="modal" wire:ignore.self>
    <div class="w-11/12 max-w-5xl modal-box">
        <h3 class="text-lg font-bold">Hello!</h3>
        <div class="flex flex-col gap-2">
            <form wire:submit='testing'>
                <label class="max-w-xs w-96 form-control">
                    <div class="label">
                        <span class="label-text">Select Status</span>
                        @error('device_id')
                            <span class="label-text-alt">{{ $message }}</span>
                        @enderror
                    </div>
                    <select
                        class="select select-bordered @error('device_id')
                select-error
                @enderror"
                        wire:model="status_id">
                        <option selected value="null">Pick one</option>
                        @foreach ($process as $proces)
                            <option value="{{ $proces->id }}">{{ $proces->status->name }}</option>
                        @endforeach
                    </select>
                </label>
                
                <label class="max-w-xs w-96 form-control">
                    <div class="label">
                        <span class="label-text">Select Employee</span>
                        @error('user_id')
                            <span class="label-text-alt">{{ $message }}</span>
                        @enderror
                    </div>
                    <select
                        class="select select-bordered @error('user_id')
                select-error
                @enderror"
                        wire:model="employe_id">
                        <option selected value="null">Pick one</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->username }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="form-control">
                    {{-- <div class="label">
                        <span class="label-text">Description</span>
                        @error('description')
                            <span class="label-text-alt">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    {{-- <textarea wire:model="description"
                        class="h-36 textarea textarea-bordered @error('description')
textarea-warning
@enderror" rows="3"
                        placeholder="Description..."></textarea> --}}
                    {{-- <input type="text" @if ($isEdit) value="{{ $description }}" @endif> --}}
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
