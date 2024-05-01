<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <label class="flex items-center gap-2 mt-2 bg-white input-bordered input input-sm">
                <x-text-input id="email" class="block w-full mt-1" type="email" name="email" required
                    autocomplete="email" />
            </label>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <label class="flex items-center gap-2 mt-2 bg-white input-bordered input input-sm">
                <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                    autocomplete="password" />
            </label>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <label class="flex items-center gap-2 mt-2 bg-white input-bordered input input-sm">
                <x-text-input id="password_confirmation" class="block w-full mt-1 " type="password" name="password"
                    required autocomplete="new-password" />
            </label>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
