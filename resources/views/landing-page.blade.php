<!DOCTYPE html>
<html lang="en" data-theme='cupcake'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script> --}}
</head>

<body>
    <div class="flex flex-col items-center justify-center h-screen gap-3 align-middle">
        <code class="">Welcome to the landing page, <p>run code bellow to do installation</p>
        </code>
        <div class="mockup-code">
            <pre data-prefix="$"><code>npm install</code></pre>
            <pre data-prefix="$"><code>composer install</code></pre>
            <pre data-prefix="$"><code>php ./artisan.php migrate</code></pre>
            <pre data-prefix=">" class="text-success"><code>Done!</code></pre>
        </div>
        <footer class="p-4 mt-10 shadow-sm footer footer-center text-base-content">
            <aside>
                <p>Copyright © 2024 - <i>prekersi</i> pemdes Gedompol</p>
            </aside>
        </footer>
    </div>
</body>

</html>
