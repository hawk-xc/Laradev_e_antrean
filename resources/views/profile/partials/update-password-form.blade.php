<section>
    @if (!Auth::user()->google_id && !Auth::user()->github_id)
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Ubah Password') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Pastikan password kamu menggunakan password yang panjang dengan kombinasi yang unik.') }}
            </p>
        </header>

        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <div>
                <label class="flex items-center gap-2 input input-bordered">
                    <x-input-label for="update_password_current_password" :value="__('Password saat ini')" />
                    <x-text-input id="update_password_current_password" name="current_password" type="password"
                        class="grow" autocomplete="current-password" />
                </label>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <label class="flex items-center gap-2 input input-bordered">
                    <x-input-label for="update_password_password" :value="__('Password baru')" />
                    <x-text-input id="update_password_password" name="password" type="password" class="grow"
                        autocomplete="new-password" />
                </label>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <label class="flex items-center gap-2 input input-bordered">
                    <x-input-label for="update_password_password_confirmation" :value="__('Ulangi Password')" />
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation"
                        type="password" class="grow" autocomplete="new-password" />
                </label>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Simpan') }}</x-primary-button>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"><i class="ri-check-line"></i> {{ __('Tersimpan.') }}</p>
                @endif
            </div>
        </form>
    @endif
</section>
