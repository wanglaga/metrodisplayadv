    @if (app()->environment('local'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Production: pakai hasil build Vite -->
        <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
        <script type="module" src="{{ asset('build/assets/app.js') }}"></script>
    @endif
    <div class="p-6 rounded-lg space-y-8">

        {{-- QR Code di atas --}}
        <div class="flex flex-col items-center justify-center space-y-4">
            <div class="p-2 bg-white rounded-lg shadow-lg">
                {!! app(\App\Services\QRCodeService::class)->svg(url('/' . $user->slug), 180) !!}
            </div>

            <p class="text-sm text-gray-300 text-center px-4">
                <a href="{{ url('/' . $user->slug) }}" target="_blank" class="text-blue-400 hover:underline break-all">
                    {{ url('/' . $user->slug) }}
                </a>
            </p>

            <a href="{{ route('users.qrcode.download', $user->id) }}"
                class="px-6 py-2 bg-gray-800 text-slate-900 text-sm font-medium rounded-lg shadow transition-colors">
                Download QR
            </a>
        </div>

        {{-- 2 kolom di bawah --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-[3rem]">

            {{-- Kolom 1 - Info User --}}
            <div class="space-y-4">
                <div class="text-sm text-gray-300">
                    <p class="font-bold mb-1 text-md">Username</p>
                    <p class="text-white font-semibold text-lg mb-4">{{ $user->name }}</p>
                </div>

                <div class="text-sm text-gray-300">
                    <p class="font-bold mb-1 text-md">Email</p>
                    <p class="text-white font-semibold text-lg mb-4">{{ $user->email }}</p>
                </div>

                <div class="text-sm text-gray-300">
                    <p class="font-bold mb-1 text-md">No. Telp</p>
                    <p class="text-white font-semibold text-lg mb-4">{{ $user->whatsapp_number ?? '-' }}</p>
                </div>

                <div class="text-sm text-gray-300">
                    <p class="font-bold mb-1 text-md">Role</p>
                    <p class="text-white font-semibold text-lg mb-4">{{ $user->role ?? '-' }}</p>
                </div>
            </div>

            {{-- Kolom 2 - Sosial Media Links --}}
            <div class="space-y-4">
                <div class="text-sm text-gray-300">
                    <p class="font-bold mb-1 text-md">Tokopedia Link</p>
                    <a href="{{ $user->detail->tokopedia ?? '#' }}" target="_blank"
                        class="text-white hover:underline font-semibold text-lg mb-4">
                        {{ $user->detail->tokopedia ?? '-' }}
                    </a>
                </div>

                <div class="text-sm text-gray-300">
                    <p class="font-bold mb-1 text-md">Facebook Link</p>
                    <a href="{{ $user->detail->facebook ?? '#' }}" target="_blank"
                        class="text-white hover:underline font-semibold text-lg mb-4">
                        {{ $user->detail->facebook ?? '-' }}
                    </a>
                </div>

                <div class="text-sm text-gray-300">
                    <p class="font-bold mb-1 text-md">Instagram Link</p>
                    <a href="{{ $user->detail->instagram ?? '#' }}" target="_blank"
                        class="text-white hover:underline font-semibold text-lg mb-4">
                        {{ $user->detail->instagram ?? '-' }}
                    </a>
                </div>

                <div class="text-sm text-gray-300">
                    <p class="font-bold mb-1 text-md">Tiktok Link</p>
                    <a href="{{ $user->detail->tiktok ?? '#' }}" target="_blank"
                        class="text-white hover:underline font-semibold text-lg mb-4">
                        {{ $user->detail->tiktok ?? '-' }}
                    </a>
                </div>
            </div>

        </div>
    </div>
