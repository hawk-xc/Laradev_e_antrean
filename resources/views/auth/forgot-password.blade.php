<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <label class="flex items-center gap-2 mt-2 bg-white text-slate-800 input-bordered input input-sm">
                <x-text-input id="email" class="block w-full mt-1" type="email" name="email" required
                    autocomplete="email" />
            </label>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
    <script>
        input: -webkit - autofill {
            /* Override default styles */
            -webkit - box - shadow: 0 0 0 30 px white inset!important; /* Change box shadow color */
            background - color: inherit; /* Set your desired background color */
            color: inherit; /* Inherit text color */
        }
    </script>
</x-guest-layout>
