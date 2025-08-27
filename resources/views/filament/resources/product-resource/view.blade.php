<link href="{{ asset('css/app.css') }}" rel="stylesheet">


<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="max-w-xl mx-auto px-2">
        <!-- Main Image -->
        <div class="border border-slate-200 shadow-sm rounded-lg overflow-hidden mb-4">
            <img id="mainImage"
                class="w-full h-[300px] sm:h-[400px] object-contain bg-white transition-opacity duration-500 ease-in-out opacity-100"
                src="{{ asset('storage/' . $record->main_image) }}" alt="Main Image" />

        </div>
    </div>
    <div class="max-w-xl mx-auto px-2">
        <h1 class="font-bold text-2xl sm:text-xl text-slate-900">Digital Signage OS Windows Touchscreen &
            Non Touchscreen</h1>
    </div>
</div>


<div class="space-y-4">
    <div class="text-lg font-bold">{{ $record->name }}</div>


    <div>
        <span class="text-gray-500">Kategori:</span>
        {{ $record->category->nama_kategori ?? '-' }}
    </div>

    <div>
        <span class="text-gray-500">Harga:</span>
        Rp {{ number_format($record->harga, 0, ',', '.') }}
    </div>

    <div>
        <span class="text-gray-500">Deskripsi:</span>
        <p>{{ $record->deskripsi }}</p>
    </div>

    <ul class="space-y-1">
        @foreach ($record->spesifikasi as $spek)
            <li class="@if ($spek['featured']) font-bold text-blue-600 @endif">
                {{ $spek['label'] }} : {{ $spek['value'] }}
            </li>
        @endforeach
    </ul>
</div>
