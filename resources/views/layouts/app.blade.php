<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" class="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind CSS -->
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-no-repeat bg-cover bg-custom-bg">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        <!-- The button to open modal -->

        <input type="checkbox" id="my_modal_7" class="modal-toggle" />
        <div class="modal" role="dialog">
            <div class="w-11/12 max-w-6xl modal-box">
                <div class="w-full carousel">
                    <div id="slide1" class="relative flex flex-col w-full carousel-item">
                        <span class="my-2 text-xl">Halaman dashboard</span>
                        <img src="{{ asset('images/dashboard1.png') }}" class="w-full border rounded-lg" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide4" class="btn btn-circle">❮</a>
                            <a href="#slide2" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide2" class="relative flex flex-col w-full carousel-item">
                        <span class="my-2 text-xl">Halaman Perangkat</span>
                        <img src="{{ asset('images/perangkat1.png') }}" class="w-full" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide1" class="btn btn-circle">❮</a>
                            <a href="#slide3" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide3" class="relative flex flex-col w-full carousel-item">
                        <span class="my-2 text-xl">Halaman Perangkat</span>
                        <img src="{{ asset('images/perangkat2.png') }}" class="w-full" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide2" class="btn btn-circle">❮</a>
                            <a href="#slide4" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide4" class="relative flex flex-col w-full carousel-item">
                        <span class="my-2 text-xl">Halaman Antean</span>
                        <img src="{{ asset('images/antrean1.png') }}" class="w-full" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide3" class="btn btn-circle">❮</a>
                            <a href="#slide5" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide5" class="relative flex flex-col w-full carousel-item">
                        <span class="my-2 text-xl">Halaman Antean</span>
                        <img src="{{ asset('images/antrean2.png') }}" class="w-full" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide4" class="btn btn-circle">❮</a>
                            <a href="#slide6" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide6" class="relative flex flex-col w-full carousel-item">
                        <span class="my-2 text-xl">Halaman Dashboard</span>
                        <img src="{{ asset('images/dashboard2.png') }}" class="w-full" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide5" class="btn btn-circle">❮</a>
                            <a href="#slide7" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide7" class="relative flex flex-col w-full carousel-item">
                        <span class="my-2 text-xl">Halaman Dashboard</span>
                        <img src="{{ asset('images/dashboard3.png') }}" class="w-full" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide6" class="btn btn-circle">❮</a>
                            <a href="#slide8" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide8" class="relative flex flex-col w-full carousel-item">
                        <span class="my-2 text-xl">Halaman Dashboard</span>
                        <img src="{{ asset('images/dashboard4.png') }}" class="w-full" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide7" class="btn btn-circle">❮</a>
                            <a href="#slide9" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide9" class="relative flex flex-col w-full carousel-item">
                        <span class="my-2 text-xl">Halaman Profile</span>
                        <img src="{{ asset('images/profile1.png') }}" class="w-full" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide8" class="btn btn-circle">❮</a>
                            <a href="#slide10" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide10" class="relative flex flex-col w-full carousel-item">
                        <span class="my-2 text-xl">Halaman Profile</span>
                        <img src="{{ asset('images/profile2.png') }}" class="w-full" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide9" class="btn btn-circle">❮</a>
                            <a href="#slide1" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide9" class="relative flex flex-col w-full carousel-item">
                        <span class="my-2 text-xl">Halaman Profile</span>
                        <img src="{{ asset('images/profile1.png') }}" class="w-full" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide8" class="btn btn-circle">❮</a>
                            <a href="#slide10" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                </div>
            </div>
            <label class="modal-backdrop" for="my_modal_7">Close</label>
        </div>
        <label for="my_modal_7"
            class="absolute flex items-center justify-center w-12 text-white align-middle transition-all duration-150 rounded-lg cursor-pointer btn hover:bg-slate-600 right-10 aspect-square bottom-10 bg-slate-800">
            <i class="ri-hand-heart-line"></i>
        </label>
    </div>
</body>

</html>
