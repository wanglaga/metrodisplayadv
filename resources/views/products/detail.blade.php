<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Temukan {{ $product->nama_produk }} dengan harga terbaik di Metro Display ADV">

    {{-- Open Graph untuk preview link --}}
    <meta property="og:title" content="{{ $product->nama_produk }}" />
    <meta property="og:description" content="Harga: Rp {{ number_format($product->harga, 0, ',', '.') }}" />
    <meta property="og:image" content="{{ asset('storage/' . $product->main_image) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="product" />

    {{-- Untuk Twitter card --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $product->nama_produk }}" />
    <meta name="twitter:description" content="Harga: Rp {{ number_format($product->harga, 0, ',', '.') }}" />
    <meta name="twitter:image" content="{{ asset('storage/' . $product->main_image) }}" />
    {{-- Title --}}
    <title>{{ $title . $product->nama_produk ?? 'Metro Display ADV' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .fade {
            transition: opacity 0.3s ease;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE & Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        /* For Collapsible Spesification */
        .fade-gradient {
            background-image: linear-gradient(to top, white, transparent);
            pointer-events: none;
            user-select: none;
        }

        .fade-hidden {
            opacity: 0;
        }

        .fade-visible {
            opacity: 1;
        }
    </style>
</head>

<body>
    <div
        class="absolute inset-0 z-[-2] bg-white bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(120,119,198,0.3),rgba(255,255,255,0))]">
    </div>
    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-[2px] bg-opacity-40 hidden z-1 lg:hidden">
    </div>

    <section class="max-w-screen-lg py-10 justify-center mx-auto p-5 mt-[3rem] ">
        <div class="breadcrumbs text-md font-semibold no-scrollbar touch-pan-x scroll-smooth">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="{{ route('products.index') }}">Product List</a></li>
                <li>Product Detail</li>
                <li>{{ $product->nama_produk }}</li>
            </ul>
        </div>
    </section>
    <section class="max-w-screen-lg mx-auto p-2 sm:p-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="w-full max-w-xl mx-auto px-2">
                <!-- Main Image -->
                <div id="zoomContainer"
                    class="border border-slate-200 shadow-sm rounded-lg overflow-hidden mb-4 relative">
                    <img id="mainImage"
                        class="w-full h-[300px] sm:h-[400px] object-contain bg-white transition-transform duration-200 ease-in-out"
                        src="{{ asset('storage/' . $product->main_image) }}" alt="Main Image" />
                </div>

                <!-- Thumbnail Slider -->
                <div class="relative mt-4">
                    <!-- Prev Button -->
                    <button id="prevBtn"
                        class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white border border-slate-200 shadow-md px-2 py-1 text-slate-700 hover:bg-slate-200 rounded-md">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <!-- Wrapper thumbnail scroll -->
                    <div class="mx-8 overflow-hidden">
                        <div id="thumbs"
                            class="flex gap-3 overflow-x-auto no-scrollbar touch-pan-x scroll-smooth transition-transform duration-300 ease-in-out">
                            {{-- Thumbnail Main Image --}}
                            <button onclick="changeImage(this, '{{ asset('storage/' . $product->main_image) }}')">
                                <img src="{{ asset('storage/' . $product->main_image) }}"
                                    class="thumbnail-img w-20 h-20 min-w-[5rem] object-contain flex-shrink-0 rounded-xl border-2 border-slate-500 transition-all duration-300 ease-in-out" />
                            </button>
                            <!-- Thumbnail Buttons -->
                            @foreach ($product->thumbnails as $thumb)
                                <button onclick="changeImage(this, '{{ asset('storage/' . $thumb) }}')">
                                    <img src="{{ asset('storage/' . $thumb) }}"
                                        class="thumbnail-img w-20 h-20 min-w-[5rem] object-contain flex-shrink-0 rounded-xl border-2 border-slate-300 transition-all duration-300 ease-in-out" />
                                </button>
                            @endforeach
                            <!-- Tambahkan thumbnail lainnya -->
                        </div>
                    </div>

                    <!-- Next Button -->
                    <button id="nextBtn"
                        class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white border border-slate-200 shadow-md px-2 py-1 text-slate-700 hover:bg-slate-200 rounded-md">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="w-full max-w-xl px-2 gap-6">
                <h1 class="font-bold text-2xl sm:text-3xl text-slate-900">{{ $product->nama_produk }}</h1>
                <div class="mt-2">
                    <span class="font-semibold text-slate-700 text-lg sm:tex-xl">{!! $product->mini_deskripsi !!}</span>
                </div>
                {{-- Penentu Harga / Size --}}
                <div x-data x-init="$store.product.init()">
                    <!--  Harga -->
                    <div class="mb-6">
                        <h1 class="font-bold text-2xl my-2">
                            Rp <span
                                x-text="$store.product.selectedType ? Number($store.product.selectedType.harga).toLocaleString('id-ID') : '-'"></span>
                        </h1>
                        <!-- Featured Specs -->
                        <div class="p-2 mx-2"
                            x-show="$store.product.selectedType && $store.product.selectedType.spesifikasi">
                            <ul class="list-none space-y-2">
                                <template
                                    x-for="(spec, index) in $store.product.selectedType.spesifikasi.filter(s => s.featured)"
                                    :key="index">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-slate-900 mt-1"></i>
                                        <span class="text-md" x-text="spec.label + ': ' + spec.value"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            <template x-for="(t, index) in $store.product.types" :key="index">
                                <button type="button" @click="$store.product.selectedType = t"
                                    :class="$store.product.selectedType?.type === t.type ?
                                        'bg-slate-900 text-white' :
                                        'bg-white text-slate-900 border border-slate-300'"
                                    class="inline-block text-sm font-medium px-3 py-1 rounded-md transition">
                                    <span x-text="t.type"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>


                <div class="flex flex-wrap mt-4 gap-4 mb-5">
                    <!-- Modal Get Quote -->
                    <button onclick="info.showModal()"
                        class="inline-flex w-full md:w-auto items-center justify-center gap-2 px-3 py-2 text-md
                     font-medium text-center text-white bg-slate-900 rounded-lg focus:ring-2 focus:ring-blue-gray-300
                        border border-slate-900 transition duration-300 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" stroke-width="1.5"
                            class="size-7 sm:size-6" fill="currentColor">
                            <path
                                d="M64 176C64 149.5 85.5 128 112 128L528 128C554.5 128 576 149.5 576 176L576 257.4C551.6 246.2 524.6 240 496 240C408.3 240 334.3 298.8 311.3 379.2C304.2 377.9 297.2 375 291.2 370.4L83.2 214.4C71.1 205.3 64 191.1 64 176zM304 432C304 460.6 310.2 487.6 321.4 512L128 512C92.7 512 64 483.3 64 448L64 260L262.4 408.8C275 418.2 289.3 424.2 304.1 426.7C304.1 428.5 304 430.2 304 432zM352 432C352 352.5 416.5 288 496 288C575.5 288 640 352.5 640 432C640 511.5 575.5 576 496 576C416.5 576 352 511.5 352 432zM553.4 371.1C546.3 365.9 536.2 367.5 531 374.6L478 447.5L451.2 420.7C445 414.5 434.8 414.5 428.6 420.7C422.4 426.9 422.4 437.1 428.6 443.3L468.6 483.3C471.9 486.6 476.5 488.3 481.2 487.9C485.9 487.5 490.1 485.1 492.9 481.4L556.9 393.4C562.1 386.3 560.5 376.2 553.4 371.1z" />
                        </svg>
                        Ekspedisi Tersedia
                    </button>
                    <dialog id="info" class="modal">
                        <div class="modal-box w-11/12 max-w-5xl">
                            <form method="dialog">
                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                            </form>
                            <h3 class="text-lg font-bold">Get a quote</h3>
                            <p class="py-4">Press ESC key or click on ✕ button to close</p>
                        </div>
                    </dialog>
                    <!-- Modal Get  -->
                    <!-- === Hubungi Sales (Button + Modal) — DROP-IN REPLACEMENT === -->
                    <!-- Trigger -->
                    <button onclick="document.getElementById('modal_call').showModal()"
                        class="inline-flex w-full md:w-auto items-center justify-center gap-2 px-3 py-2 text-md font-medium text-center text-slate-900 bg-white rounded-lg hover:bg-slate-900 hover:text-white focus:ring-2 focus:ring-blue-gray-300 border border-slate-900 transition duration-300 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" stroke-width="1.5"
                            class="size-7" fill="currentColor">
                            <path
                                d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z" />
                        </svg>
                        Hubungi Sales
                    </button>

                    <!-- Modal -->
                    <dialog id="modal_call" class="modal" x-data>
                        <div class="modal-box w-11/12 max-w-2xl relative">
                            <!-- Close -->
                            <form method="dialog">
                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                            </form>

                            <!-- Title -->
                            <h3 class="text-[20px] text-slate-900 font-bold">Hubungi Customer Sales</h3>
                            <p class="py-4 text-md">
                                Untuk proses Pembelian, <br>
                                silahkan hubungi customer sales kami,
                                <span class="text-slate-900 font-semibold">via WhatsApp berikut:</span>
                            </p>

                            <!-- WhatsApp Button -->
                            <div class="justify-center mx-auto">
                                <a href="#" id="btnHubungiSales" data-produk="{{ $product->nama_produk }}"
                                    data-link="{{ url()->current() }}" data-wa="6285806456134"
                                    :data-harga="$store.product?.selectedType?.harga ?? @json($product->harga ?? null)"
                                    :data-ukuran="$store.product?.selectedType?.type ?? @json($product->ukuran ?? '')"
                                    class="flex items-start p-4 rounded-lg border border-green-500 hover:bg-gray-50 transition-all duration-300 ease-in-out">

                                    <!-- Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" stroke-width="1.5"
                                        class="w-8 h-8 text-green-600 mt-1 mr-2 flex-shrink-0" fill="currentColor">
                                        <path
                                            d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z" />
                                    </svg>

                                    <!-- Text -->
                                    <div>
                                        <div class="font-semibold text-slate-900">Metro Display ADV Sales Care</div>
                                        <div class="text-gray-700 text-sm">Klik untuk memulai chat</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </dialog>

                </div>
                <div class="bg-slate-200 rounded-xl p-5 max-w-xl text-slate-900">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold">We appreciate your feedback.</h2>
                        <i class="fas fa-info-circle text-lg"></i>
                    </div>
                    <p class="mt-2 text-sm">
                        Let us know what you think about our products on
                        <a href="mailto:customer.service@metrodisplayadvpro.com"
                            class="underline font-semibold hover:text-blue-900">
                            customer.service@metrodisplayadvpro.com
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Video -->
    @if ($youtubeId)
        <section class="max-w-screen-lg mx-auto p-2 mt-5 sm:mt-[3rem]">
            <h1 class="font-bold px-2 text-2xl sm:text-3xl text-slate-900">Video Produk</h1>
            <div class="w-full max-w-6xl mx-auto px-4 md:px-6 py-6">
                <div class="flex justify-center">

                    <!-- Modal video component -->
                    <div class="[&_[x-cloak]]:hidden" x-data="{ modalOpen: false, videoId: '{{ $youtubeId }}' }">

                        <!-- Video thumbnail -->
                        <button
                            class="relative flex justify-center items-center focus:outline-none focus-visible:ring focus-visible:ring-slate-300 rounded-xl group"
                            @click="modalOpen = true" aria-controls="modal" aria-label="Watch the video">

                            <!-- Thumbnail otomatis dari YouTube -->
                            <img class="rounded-xl shadow-2xl transition-shadow duration-300 ease-in-out"
                                :src="`https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`" width="768"
                                height="432" alt="Modal video thumbnail" />

                            <!-- Play icon -->
                            <svg class="absolute pointer-events-none group-hover:scale-110 transition-transform duration-300 ease-in-out"
                                xmlns="http://www.w3.org/2000/svg" width="72" height="72">
                                <circle class="fill-white" cx="36" cy="36" r="36" fill-opacity=".6" />
                                <path class="fill-red-600 drop-shadow-2xl"
                                    d="M44 36a.999.999 0 0 0-.427-.82l-10-7A1 1 0 0 0 32 29V43a.999.999 0 0 0 1.573.82l10-7A.995.995 0 0 0 44 36V36c0 .001 0 .001 0 0Z" />
                            </svg>
                        </button>

                        <!-- Modal backdrop -->
                        <div class="fixed inset-0 z-[99999] bg-black/50 transition-opacity" x-show="modalOpen"
                            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            aria-hidden="true" x-cloak></div>

                        <!-- Modal dialog -->
                        <div id="modal"
                            class="fixed inset-0 z-[99999] flex items-center justify-center px-4 md:px-6 py-6"
                            role="dialog" aria-modal="true" x-show="modalOpen"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-75"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-out duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-75" x-cloak>
                            <div class="w-full max-w-5xl aspect-video bg-black rounded-3xl shadow-2xl overflow-hidden"
                                @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">

                                <template x-if="modalOpen">
                                    <iframe class="w-full h-full"
                                        :src="`https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`"
                                        title="YouTube video player" frameborder="0"
                                        allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                                </template>
                            </div>
                        </div>
                    </div>
                    <!-- End: Modal video component -->

                </div>
            </div>
        </section>
    @endif

    <!-- DESKRIPSI -->
    <section class="max-w-screen-lg mx-auto p-2 mt-3 sm:mt-[2rem]">
        <h1 class="font-bold px-2 text-2xl sm:text-3xl text-slate-900">Deskripsi</h1>
        <div class="font-normal mt-3 px-2 text-slate-900 text-justify text-md">{!! $product->deskripsi !!}</div>
    </section>
    <!-- SPECIFICATION  -->
    <section class="max-w-screen-lg mx-auto p-2 mt-3 sm:mt-[2rem]">
        <div class="flex flex-col gap-2 sm:flex-row justify-between items-start sm:items-center">
            <h1 class="font-bold px-2 text-2xl sm:text-3xl text-slate-900">Spesifikasi</h1>
            <a href="#"
                class="inline-flex items-center justify-center w-full sm:w-auto gap-2 px-6 py-2 text-md font-medium text-center bg-slate-900 border border-white text-white rounded-lg  focus:ring-2 focus:ring-blue-gray-300">
                Download Spec Sheet
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" stroke-width="1.5"
                    class="fill-current size-6">
                    <path
                        d="M352 96C352 78.3 337.7 64 320 64C302.3 64 288 78.3 288 96L288 306.7L246.6 265.3C234.1 252.8 213.8 252.8 201.3 265.3C188.8 277.8 188.8 298.1 201.3 310.6L297.3 406.6C309.8 419.1 330.1 419.1 342.6 406.6L438.6 310.6C451.1 298.1 451.1 277.8 438.6 265.3C426.1 252.8 405.8 252.8 393.3 265.3L352 306.7L352 96zM160 384C124.7 384 96 412.7 96 448L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 448C544 412.7 515.3 384 480 384L433.1 384L376.5 440.6C345.3 471.8 294.6 471.8 263.4 440.6L206.9 384L160 384zM464 440C477.3 440 488 450.7 488 464C488 477.3 477.3 488 464 488C450.7 488 440 477.3 440 464C440 450.7 450.7 440 464 440z" />
                </svg>
            </a>
        </div>
        <div class="container mb-5 mt-6" x-data>
            <div id="specWrapper" class="relative max-w-screen-md px-2">
                <div id="specContent"
                    class="divide-y divide-gray-300 overflow-hidden transition-all duration-700 ease-in-out max-h-[340px]">

                    <template x-if="$store.product.selectedType && $store.product.selectedType.spesifikasi">
                        <template x-for="(spec, index) in $store.product.selectedType.spesifikasi"
                            :key="index">
                            <div class="grid grid-cols-2 gap-2 py-2 sm:py-2">
                                <div><span class="text-md font-bold" x-text="spec.label"></span></div>
                                <div><span class="text-md font-normal" x-text="spec.value"></span></div>
                            </div>
                        </template>
                    </template>
                </div>

                <div id="fadeMask"
                    class="absolute bottom-0 left-0 w-full h-16 fade-gradient transition-opacity duration-500 fade-visible">
                </div>
            </div>

            <div class="text-center mt-4">
                <button id="toggleBtn"
                    class="border border-slate-900 text-slate-900 hover:text-white bg-white hover:bg-slate-900 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center transition duration-300 ease-in-out">
                    Show more
                </button>
            </div>
        </div>



    </section>
    <!-- WARANTY -->
    <section class="max-w-screen-lg mx-auto p-4 mt-[2rem] sm:mt-[2rem]">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 sm:gap-[5rem]">

            <!-- Gambar di atas saat mobile -->
            <div class="w-1/2 md:w-1/3 order-1 md:order-2">
                <img src="{{ asset('img/icon/service.png') }}" alt="Ilustrasi garansi"
                    class="w-full max-w-sm mx-auto" />
            </div>

            <!-- Keterangan garansi di bawah gambar pada mobile -->
            <div class="w-full md:w-1/2 order-2 md:order-1">
                <h2 class="text-3xl font-bold text-slate-900 mb-2">
                    Garansi Produk
                </h2>
                <p class="text-slate-700 mb-4">
                    Layanan garansi resmi untuk produk-produk pilihan. Dapatkan perlindungan menyeluruh dengan jaminan
                    servis dan penggantian unit.
                </p>
                <ul class="space-y-2 text-slate-800 px-2">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle text-slate-900 mt-1"></i>
                        <span>Dukungan teknis 24/7</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle text-slate-900 mt-1"></i>
                        <span>Penggantian unit langsung</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle text-slate-900 mt-1"></i>
                        <span>Garansi ketenangan pikiran</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle text-slate-900 mt-1"></i>
                        <span>Cakupan nasional</span>
                    </li>
                </ul>

                <div class="mt-6 flex gap-4 flex-wrap">
                    <button onclick="modal_call.showModal()"
                        class="bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-6 py-2 rounded transition-all">
                        Hubungi Kami
                    </button>
                </div>
            </div>

        </div>
    </section>

    <!-- SIMILAR PRODUCTS -->
    <section class="max-w-screen-lg mx-auto p-2 mt-[3rem] mb-[3rem]">
        <div class="flex flex-wrap justify-between items-center gap-y-2 mb-4">
            <h1 class="font-bold px-2 text-2xl sm:text-3xl text-slate-900">
                Similar Products
            </h1>

            @if ($relatedProducts->isNotEmpty())
                <a href="#" class="px-2 text-md font-medium text-slate-900 hover:underline">
                    View all
                </a>
            @endif
        </div>

        <div
            class="lg:grid lg:grid-cols-4 lg:gap-6 flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-4">

            @forelse ($relatedProducts as $product)
                <!-- Card Product -->
                <div
                    class="min-w-[280px] max-w-[300px] sm:min-w-[300px] sm:max-w-[320px] lg:min-w-0 lg:max-w-none lg:w-full shrink-0 snap-start border border-slate-300 shadow-sm rounded-lg p-4 text-center bg-white flex flex-col h-[250px]">
                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}"
                        class="mx-auto mb-3 h-28 object-contain" />
                    <div class="flex-1 flex flex-col">
                        <h3 class="font-semibold text-base mb-1 break-words leading-tight">{{ $product->nama_produk }}
                        </h3>
                        @if (!empty($product->mini_deskripsi))
                            <p class="text-sm text-gray-600 leading-snug break-words">
                                {!! Str::limit($product->mini_deskripsi, 60) !!}
                            </p>
                        @endif
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('product.detail', $product->slug) }}"
                            class="inline-block px-4 py-1 border border-slate-900 rounded-md font-medium text-sm hover:bg-slate-900 hover:text-white transition">
                            Lihat lebih lengkap
                        </a>
                    </div>
                </div>
            @empty
                <!-- State kosong -->
                <div
                    class="min-w-full lg:col-span-4 text-center p-8 border border-dashed border-slate-300 rounded-lg bg-gray-50">
                    <i class="fa-solid fa-circle-exclamation text-slate-600 text-3xl"></i>
                    <p class="text-slate-600 text-lg font-medium mt-2">Tidak ada produk serupa pada kategori ini</p>
                </div>
            @endforelse

        </div>
    </section>


    @include('partials.header')

    @include('partials.footer')

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-[2px] bg-opacity-40 hidden z-1 lg:hidden">
    </div>

    @include('partials.button-to-top')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('product', {
                types: @json($product->spesifikasi ?? []),
                selectedType: null,
                init() {
                    if (this.types.length > 0) {
                        this.selectedType = this.types[0];
                    }
                }
            });
        });
    </script>
    {{-- <script src="{{ asset('js/img-magnifier.js') }}"></script> --}}
    <script src="{{ asset('js/img-thumbnail.js') }}"></script>

    <script src="{{ asset('js/whatsapp.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/collapsible.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
