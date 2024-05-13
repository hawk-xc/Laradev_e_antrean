<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9" />
                    </a>
                </div>


                <!-- Navigation Links -->

                @if (Auth::check())
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="gap-2">
                            <i class="ri-dashboard-line"></i>
                            {{ __('Halaman Utama') }}
                        </x-nav-link>
                    </div>
                @endif

                <!-- Device Links -->
                @if (\App\Helpers\RoleHelper::isUser())
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('device')" :active="request()->routeIs('device')" class="gap-2">
                            <i class="ri-macbook-line"></i>
                            {{ __('Perangkat') }}
                        </x-nav-link>
                    </div>
                @endif


                <!-- Ticket Links -->
                @if (\App\Helpers\RoleHelper::isUser())
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('ticket')" :active="request()->routeIs('ticket')" class="gap-2">
                            <i class="ri-coupon-3-line"></i>
                            {{ __('Tiket') }}
                        </x-nav-link>
                    </div>
                @endif

                <!-- Process Links -->
                @if (
                    \App\Helpers\RoleHelper::isAdmin() ||
                        \App\Helpers\RoleHelper::isTechnician() ||
                        \App\Helpers\RoleHelper::isHelpdesk())
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('process')" :active="request()->routeIs('process')" class="gap-2">
                            <i class="ri-stack-line"></i>
                            {{ __('Proses') }}
                        </x-nav-link>
                    </div>
                @endif

                @if (\App\Helpers\RoleHelper::isAdmin())
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('manageuser')" :active="request()->routeIs('manageuser')" class="gap-2">
                            <i class="ri-user-settings-line"></i>
                            {{ __('Pengaturan User') }}
                        </x-nav-link>
                    </div>
                @endif

                @if (\App\Helpers\RoleHelper::isAdmin())
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('log')" :active="request()->routeIs('log')" class="gap-2">
                            <i class="ri-alarm-warning-line"></i>
                            {{ __('Web Log') }}
                        </x-nav-link>
                    </div>
                @endif
            </div>



            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                            <div><i class="ri-user-3-line"></i> {{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">

        @if (Auth::check())
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Halaman Utama') }}
                </x-responsive-nav-link>
            </div>
        @endif

        @if (\App\Helpers\RoleHelper::isUser())
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('device')" :active="request()->routeIs('device')">
                    {{ __('Perangkat') }}
                </x-responsive-nav-link>
            </div>
        @endif

        @if (\App\Helpers\RoleHelper::isUser())
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('ticket')" :active="request()->routeIs('ticket')">
                    {{ __('Tiket') }}
                </x-responsive-nav-link>
            </div>
        @endif

        @if (
            \App\Helpers\RoleHelper::isAdmin() ||
                \App\Helpers\RoleHelper::isTechnician() ||
                \App\Helpers\RoleHelper::isHelpdesk())
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('process')" :active="request()->routeIs('process')">
                    {{ __('Proses') }}
                </x-responsive-nav-link>
            </div>
        @endif

        @if (\App\Helpers\RoleHelper::isAdmin())
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('manageuser')" :active="request()->routeIs('manageuser')">
                    {{ __('Pengaturan User') }}
                </x-responsive-nav-link>
            </div>
        @endif

        @if (\App\Helpers\RoleHelper::isAdmin())
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('log')" :active="request()->routeIs('log')">
                    {{ __('Web Log') }}
                </x-responsive-nav-link>
            </div>
        @endif

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
