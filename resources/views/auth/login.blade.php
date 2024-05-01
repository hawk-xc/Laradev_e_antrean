<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
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
        </div>

        <div class="divider">OR</div>

        <div class="flex flex-row justify-center w-48 gap-2 mx-auto ">
            <a href="auth/google/redirect" class="w-full text-xl btn btn-info"><i class="ri-google-fill"></i>
                Google</a>
            <a href="auth/github/redirect" class="w-full text-xl btn"><i class="ri-github-fill"></i>
                Github</a>
        </div>

        <div class="flex items-center justify-center w-full py-5 align-middle">
            <span class="text-sm">create an new account <a class="font-semibold text-sky-600 hover:underline"
                    href="{{ route('register') }}">here</a></span>
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
