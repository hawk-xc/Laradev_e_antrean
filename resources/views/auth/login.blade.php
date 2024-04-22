<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <label class="flex items-center gap-2 mt-2 bg-white input input-sm input-bordered">
                <x-text-input id="email" class="w-full max-w-xs input-sm" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" />
            </label>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <label class="flex items-center gap-2 mt-2 bg-white input input-sm input-bordered">
                <x-text-input id="password" class="w-full max-w-xs input-sm" type="password" name="password" required
                    autocomplete="current-password" />
            </label>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex justify-between mt-4 align-middle ">
            <label for="remember_me" class="inline-flex">
                <input id="remember_me" type="checkbox" name="remember" class="checkbox checkbox-sm" />
                <span class="text-sm text-gray-600 ms-2">{{ __('Remember me') }}</span>
            </label>
            <span class="left-0 text-sm">Create an new account <a class="font-semibold text-blue-400 underline"
                    href="{{ route('register') }}">here!</a></span>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
