<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('User phone') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's phone number.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updatephone') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label class="flex items-center gap-2 input input-bordered">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" name="phone" type="text" class="grow" :value="old('username', $user->phone)" required
                    autofocus autocomplete="off" />
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
