<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Hapus Akun Pengguna') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Setelah akun anda dihapus, Semua data pada system otomatis akan terhapus. Sebelum menghapus akun, mohon dipastikan ulang dengan teliti.') }}
        </p>
    </header>

    <x-danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Apakah kamu yakin ingin menghapus akun mu?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Setelah menghapus akun, Semua data pada system otomatis akan terhapus. Mohon masukkan password konfirmasi untuk menghapus semua data pengguna.') }}
            </p>

            <div class="mt-6">
                <label class="flex items-center gap-2 input input-bordered">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" class="disabled grow" required
                        autofocus autocomplete="off" />
                </label>
                <x-input-error class="mt-2" :messages="$errors->userDeletion->get('password')" />
            </div>

            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
