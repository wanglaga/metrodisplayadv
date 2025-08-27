@if (app()->environment('local'))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <!-- Production: pakai hasil build Vite -->
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <script type="module" src="{{ asset('build/assets/app.js') }}"></script>
@endif
<div class="flex flex-col items-center mt-5">
    <div class="p-2 bg-white rounded-lg shadow">
        {!! $qr !!}
    </div>

    <a href="{{ route('users.qrcode.download', $user->id) }}"
        class="mt-5 inline-block px-3 py-1 bg-gray-800 text-white text-xs rounded-lg shadow hover:bg-gray-700 transition">
        Download QR
    </a>
</div>
