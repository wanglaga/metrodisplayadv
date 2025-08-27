    @vite('resources/css/app.css')
    <div class="flex flex-col items-center mt-5">
        <div class="p-2 bg-white rounded-lg shadow">
            {!! $qr !!}
        </div>

        <a href="{{ route('users.qrcode.download', $user->id) }}"
            class="mt-5 inline-block px-3 py-1 bg-gray-800 text-white text-xs rounded-lg shadow hover:bg-gray-700 transition">
            Download QR
        </a>
    </div>
