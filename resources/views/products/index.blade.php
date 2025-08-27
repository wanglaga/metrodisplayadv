<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <title>{{ $title ?? 'Metro Display ADV' }}</title>
</head>

<body>
    @include('partials.header')
    <section class="max-w-screen-lg justify-center mx-auto p-5 mt-[5rem] ">
        <div class="breadcrumbs text-md font-semibold">
            <ul>
                <li><a href="/">Home</a></li>
                <li>Product List</li>
            </ul>
        </div>
    </section>
    <section class="max-w-screen-lg justify-center mx-auto p-5">
        <div class="relative w-full h-72 rounded-xl overflow-hidden shadow-lg">
            <!-- Background Image -->
            <img src="{{ asset('img/pattern/bg-text.jpg') }}" alt="Background"
                class="absolute inset-0 w-full h-full object-cover" />

            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>

            <!-- Text Content -->
            <div class="relative z-10 p-5 sm:p-10 text-white flex flex-col justify-end h-full">
                <h2 class="text-2xl sm:text-4xl font-bold mb-1">Product List</h2>
                <p class="text-lg sm:text-xl text-gray-200">Jelajahi berbagai kategori dan temukan produk terbaik dari
                    katalog
                    kami.</p>
            </div>
        </div>
    </section>
    <section class="max-w-screen-lg justify-center items-center mx-auto p-5">
        <form action="{{ route('products.index') }}" method="GET"
            class="w-full max-w-7xl flex flex-col sm:flex-row sm:items-center sm:justify-start gap-4 sm:gap-x-3 mx-auto">

            <!-- Search Input -->
            <div class="relative w-full sm:w-[60%]">
                <!-- Icon -->
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                    <svg class="w-5 h-5 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m.6-4.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>

                <!-- Input -->
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Produk..."
                    class="w-full rounded-xl border border-slate-300 bg-white pl-10 pr-4 py-3 text-sm sm:text-base font-semibold text-slate-700 shadow-sm transition-all duration-300 focus:border-slate-500 focus:ring-2 focus:ring-slate-300 hover:border-slate-400" />
            </div>


            <!-- Select Dropdown -->
            <div class="w-full sm:w-[25%]">
                <div class="relative">
                    <select name="category"
                        class="w-full appearance-none rounded-xl border border-slate-300 bg-white px-4 py-3 pr-10 text-sm sm:text-base font-semibold text-slate-700 shadow-sm transition-all duration-300 focus:border-slate-500 focus:ring-2 focus:ring-slate-300 hover:border-slate-400 cursor-pointer">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Custom arrow -->
                    <div
                        class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-500 transition-transform duration-300">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>


            <!-- Search Button -->
            <div class="w-full sm:w-[15%]">
                <button type="submit" class="btn bg-slate-900 text-white text-[16px] rounded-md w-full">
                    Submit
                </button>
            </div>
        </form>
        @if (request('q'))
            <h2 class="text-lg text-slate-900 mt-4">
                Hasil pencarian : <span class="font-semibold text-slate-900">"{{ request('q') }}"</span>
            </h2>
        @else
            <h2 class="text-lg text-slate-900 mt-4">
                Hasil pencarian : <span class="font-semibold text-slate-900">{{ request('q') }}</span>
            </h2>
        @endif
    </section>
    <section class="max-w-screen-lg justify-center items-center mx-auto px-5 pb-5">
        <div class="max-w-7xl mx-auto">
            @if ($products->count())
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4 sm:gap-6 mb-5">
                    @foreach ($products as $product)
                        <!-- Product Card -->
                        <div
                            class="flex flex-col bg-white rounded-xl border border-gray-200 hover:border-slate-400 shadow-sm p-2 sm:p-4 text-center transition duration-300 ease-in-out">

                            <!-- Gambar -->
                            <img src="{{ $product->main_image ? asset('storage/' . $product->main_image) : '/dist/img/default.jpg' }}"
                                alt="{{ $product->nama_produk }}"
                                class="w-full h-28 sm:h-40 md:h-48 object-contain rounded-md">

                            <!-- Konten -->
                            <div class="flex flex-col flex-1 mt-3">
                                <h3 class="text-sm sm:text-base md:text-lg font-semibold text-slate-900">
                                    {{ $product->nama_produk }}
                                </h3>

                                <p class="text-xs sm:text-sm md:text-base text-slate-600 my-2 flex-1">
                                    {!! Str::limit($product->mini_deskripsi, 60) !!}
                                </p>

                                <!-- Tombol selalu di bawah -->
                                <div class="mt-auto">
                                    <a href="{{ route('product.detail', $product->slug) }}"
                                        class="inline-block w-full sm:w-auto px-3 sm:px-4 py-1.5 sm:py-2 border border-slate-900 rounded-md font-medium text-xs sm:text-sm md:text-base hover:bg-slate-900 hover:text-white transition">
                                        See Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <!-- Pagination -->
                <div class="mt-6">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                    <!-- Icon/Ilustrasi -->
                    <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20.25 7.5l-8.955 8.955c-.44.44-1.155.44-1.595 0L3.75 12.5" />
                        </svg>
                    </div>

                    <!-- Teks -->
                    <h2 class="mt-6 text-xl font-semibold text-slate-900 dark:text-white">
                        Produk tidak ditemukan
                    </h2>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-md">
                        Kami tidak menemukan produk yang sesuai dengan pencarian Anda.<br>
                        Coba ubah filter pencarian atau jelajahi koleksi terbaru kami.
                    </p>

                    <!-- Tombol -->
                    <a href="{{ route('products.index') }}"
                        class="mt-6 inline-block rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-medium text-white shadow hover:bg-slate-700 transition">
                        Lihat Semua Produk
                    </a>
                </div>


            @endif
        </div>
    </section>
    @livewireScripts
    @include('partials.footer')
    @include('partials.button-to-top')


    <script src="{{ asset('js/main.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
