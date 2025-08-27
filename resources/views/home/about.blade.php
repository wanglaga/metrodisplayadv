<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Halaman About</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        .hero-fade {
            transition: opacity 1s ease-in-out;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    @if (app()->environment('local'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Production: pakai hasil build Vite -->
        <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
        <script type="module" src="{{ asset('build/assets/app.js') }}"></script>
    @endif


    @livewireStyles
</head>

<body class="mx-auto">
    @include('partials.header')

    <section class="p-5 mx-auto mt-[5rem]">
        <h1 class="text-blue-500 font-bold">Halaman About</h1>

        <livewire:contact-form />
    </section>


    @livewireScripts
    @include('partials.footer')
    @include('partials.button-to-top')

    <script src="{{ asset('js/main.js') }}"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}
</body>

</html>
