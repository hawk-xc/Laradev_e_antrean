<!DOCTYPE html>
<html lang="en" data-theme="synthwave">
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <nav class="flex justify-between w-full px-10 py-3 shadow-xl backdrop-blur-lg brightness-75 max-sm:text-xs">
        <span>e-service</span>
        <span>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="m-1">panel</div>
                <ul tabindex="0"
                    class="dropdown-content translate-x-8 z-[1] menu p-2 shadow backdrop-blur-md mt-4 rounded-box w-52">
                    <li><a href="{{ route('login') }}">login</a></li>
                    <li><a href="{{ route('register') }}">register</a></li>
                </ul>
            </div>
        </span>
    </nav>
    <title>halaman Servi-Kom</title>
</head>

<body class="w-screen h-screen bg-center bg-no-repeat bg-cover"
    style="background-image: url('{{ asset('images/background.png') }}')">
    <div class="flex flex-col items-center justify-center w-full h-screen align-middle" data-aos="zoom-in-down">
        <span
            class="text-8xl max-sm:text-[4rem] font-extrabold font-times bg-gradient-to-r from-primary to-blue-800 opacity-90 bg-clip-text text-transparent">Servi-Kom</span>
        <span class="flex flex-row gap-4 p-5">
            <div class="badge badge-neutral">cepat</div>
            <div class="badge badge-primary">efisien</div>
            <div class="badge badge-secondary">integritas</div>
        </span>
        <span class="w-[40rem] text-center max-sm:text-xs max-sm:w-72">
            aplikasi e-service merupakan sebuah layanan multiplatform yang dirancang untuk mempermudah proses
            pengelolaan data service pernangkat komputer anda, aplikasi ini dapat mempercepat dan mempermudah proses
            pendaftaran antrean melalui aplikasi membuat perbaikan menjadi efisien.
        </span>
        <span class="mt-32 text-xs font-light text-slate-200">&copy; 2023-2024 tim ABC-Komputer</span>
    </div>
</body>

<script>
    AOS.init();
</script>

</html>
