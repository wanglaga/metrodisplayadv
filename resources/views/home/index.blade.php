<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Default Title' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ 'main.css' }}">
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

        /* default state */
        .fade-up {
            opacity: 0;
            transform: translateY(1.5rem);
            transition: all 0.7s ease-in-out;
            will-change: transform, opacity;
        }

        /* ketika terlihat */
        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    @vite('resources/css/app.css')


    @livewireStyles
</head>

<body>
    @include('partials.header')
    <div
        class="fade-up container mx-auto grid h-full gap-10 min-h-[60vh] w-full grid-cols-1 items-center lg:grid-cols-2 mt-15 sm:mt-20">
        <div class="row-start-2 lg:row-auto px-5">
            <h1
                class="block antialiased tracking-normal font-sans font-bold text-slate-900 mb-3 lg:text-5xl !leading-tight text-3xl">
                Metro Display ADV</h1>
            <p
                class="block antialiased font-sans text-sm sm:text-[17px] font-normal leading-relaxed mb-5 text-slate-700 md:pr-16 xl:pr-28">
                Partner Solusi Promosi Usaha, Program & Bisnis Besar Anda. Menggunakan Digital Signage, Video Wall,
                Videotron, Kiosk Touchcreen & Display LED-LCD Multimedia
            </p>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="#contact"
                    class="inline-block px-6 py-3 mb-2 sm:mb-0 text-md font-medium text-center text-white bg-slate-900 rounded-lg hover:bg-slate-800 focus:ring-4 focus:ring-blue-gray-300 transition duration-300 ease-in-out">
                    Hubungi Kami
                </a>
                <!-- Modal video component -->
                <div x-data="{ modalOpen: false }">

                    <!-- Play Button -->
                    <a href="#" @click.prevent="modalOpen = true"
                        class="inline-flex w-full md:w-auto items-center justify-center gap-2 px-6 py-3 text-md font-medium text-center text-slate-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-blue-gray-300 border border-slate-900 transition duration-300 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" stroke-width="1.5"
                            class="fill-slate-900 size-6">
                            <path
                                d="M64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM252.3 211.1C244.7 215.3 240 223.4 240 232L240 408C240 416.7 244.7 424.7 252.3 428.9C259.9 433.1 269.1 433 276.6 428.4L420.6 340.4C427.7 336 432.1 328.3 432.1 319.9C432.1 311.5 427.7 303.8 420.6 299.4L276.6 211.4C269.2 206.9 259.9 206.7 252.3 210.9z" />
                        </svg>
                        Play Trailer
                    </a>

                    <!-- Modal backdrop -->
                    <div class="fixed inset-0 z-[99999] bg-black/50 transition-opacity" x-show="modalOpen"
                        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak></div>

                    <!-- Modal dialog -->
                    <div id="modal"
                        class="fixed inset-0 z-[99999] flex items-center justify-center px-4 md:px-6 py-6"
                        role="dialog" aria-modal="true" x-show="modalOpen"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-out duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-75"
                        x-data="{ open: false }" x-show="open" x-cloak>
                        <div class="w-full max-w-5xl aspect-video bg-black rounded-3xl shadow-2xl overflow-hidden"
                            @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                            <!-- Hanya render iframe saat modalOpen = true -->
                            <template x-if="modalOpen">
                                <iframe class="w-full h-full"
                                    src="https://www.youtube.com/embed/z1UHq4tc9Dg?autoplay=1&rel=0&modestbranding=1"
                                    title="YouTube video player" frameborder="0"
                                    allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                            </template>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div
            class="relative w-full h-[20rem] sm:h-[36rem] overflow-hidden sm:rounded-br-[72px] sm:rounded-tl-[72px] sm:rounded-bl-xl sm:rounded-tr-xl shadow-lg">
            @forelse($jbanner as $key => $banner)
                <img src="{{ asset('storage/' . $banner->image) }}"
                    class="absolute inset-0 w-full h-full object-cover hero-fade opacity-100 transition-opacity duration-1000" />
            @empty
            @endforelse
        </div>
    </div>
    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-[2px] bg-opacity-40 hidden z-1 lg:hidden">
    </div>

    <!-- LAYANAN -->
    <section class="fade-up max-w-screen py-10 justify-center mx-auto p-5 mt-[3rem] bg-gradient-to-b from-white to-slate-100">
        <div class="flex flex-col max-w-screen-lg mx-auto md:flex-row gap-[25px]">
            <div class="flex-1 md:mx-auto p-2">
                <h2 class="text-[30px] font-bold text-slate-900 text-center">Layanan Kami</h2>
            </div>
        </div>
        <div class="flex flex-wrap justify-center items-center gap-5 px-4 py-6">
            <!-- Card 1 -->
            <div
                class="w-72 h-68 text-slate-900 bg-white border border-slate-400 rounded-tl-[64px] rounded-tr-md rounded-br-md rounded-bl-md sm:rounded-br-[64px] lg:rounded-br-md shadow-md hover:bg-slate-900 hover:text-white transition duration-300 ease-in-out p-6 flex flex-col justify-center items-center">
                <img src="{{ asset('img/icon/display.png') }}" alt="" class="w-20 h-20 mt-10">
                <p class="text-lg p-4 text-center font-semibold mb-4">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum, nihil.
                </p>
            </div>

            <!-- Card 2 -->
            <div
                class="w-72 h-68 text-slate-900 bg-white border border-slate-400 rounded-md sm:rounded-tr-[64px] sm:rounded-bl-[64px] lg:rounded-tr-md lg:rounded-bl-md shadow-md hover:bg-slate-900 hover:text-white transition duration-300 ease-in-out p-6 flex flex-col justify-center items-center">
                <img src="{{ asset('img/icon/billboard.png') }}" alt="" class="w-20 h-20 mt-10">

                <p class="text-lg p-5 text-center font-semibold mb-4">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae, necessitatibus!
                </p>
            </div>

            <!-- Card 3 -->
            <div
                class="w-72 h-68 text-slate-900 bg-white border border-slate-400 rounded-tr-[64px] rounded-tl-md rounded-bl-md rounded-br-md sm:rounded-bl-[64px] lg:rounded-bl-md shadow-md hover:bg-slate-900 hover:text-white transition duration-300 ease-in-out p-6 flex flex-col justify-center items-center">
                <img src="{{ asset('img/icon/puzzle.png') }}" alt="" class="w-20 h-20 mt-10">
                <p class="text-lg p-5 text-center font-semibold mb-4">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, veniam!
                </p>
            </div>

            <!-- Card 4 (dengan jarak ekstra) -->
            <div
                class="lg:ml-8 w-72 h-68 bg-[#0d1325] rounded-tl-[64px] rounded-br-[64px] rounded-tr-md rounded-bl-md shadow-md text-white p-6 flex flex-col justify-center items-center">

                <p class="text-lg p-5 text-center font-semibold mb-4">
                    Temukan solusi terbaik untuk kebutuhanmu dengan produk andalan kami.
                </p>
                <a href="/products"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 text-md font-medium text-center bg-slat-900 border border-white text-white rounded-lg hover:bg-white  focus:ring-2 focus:ring-blue-gray-300 hover:border-slate-900 hover:text-slate-900 transition duration-300 ease-in-out">
                    Cek Produk Kami
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" stroke-width="1.5"
                        class="fill-current size-6">
                        <path
                            d="M192 384L88.5 384C63.6 384 48.3 356.9 61.1 335.5L114 247.3C122.7 232.8 138.3 224 155.2 224L250.2 224C326.3 95.1 439.8 88.6 515.7 99.7C528.5 101.6 538.5 111.6 540.3 124.3C551.4 200.2 544.9 313.7 416 389.8L416 484.8C416 501.7 407.2 517.3 392.7 526L304.5 578.9C283.2 591.7 256 576.3 256 551.5L256 448C256 412.7 227.3 384 192 384L191.9 384zM464 224C464 197.5 442.5 176 416 176C389.5 176 368 197.5 368 224C368 250.5 389.5 272 416 272C442.5 272 464 250.5 464 224z" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <!-- SHOW PRODUCT -->
    <section class="max-w-screen py-10 justify-center mx-auto p-5 bg-gradient-to-b from-slate-100 to-slate-100">
        <div class="flex flex-col max-w-screen mx-auto md:flex-row gap-[25px]">
            <div class="flex-1 md:mx-auto p-2">
                <h2 class="text-[30px] font-bold text-slate-900 text-center">Produk Unggulan</h2>
            </div>
        </div>
        <div class="fade-up max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 py-8">
                @forelse ($products as $key => $product)
                    <div
                        class="relative flex w-full max-w-xs flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition duration-300 ease-in-out">

                        <!-- Gambar Produk -->
                        <a class="relative mx-3 mt-3 flex h-60 overflow-hidden rounded-xl"
                            href="{{ route('product.detail', $product->slug) }}">
                            <img class="object-cover w-full h-full" src="{{ asset('storage/' . $product->main_image) }}"
                                alt="{{ $product->nama_produk }}" />
                        </a>

                        <!-- Konten Produk -->
                        <div class="flex flex-col flex-1 justify-between px-5 pb-5 mt-4">
                            <div>
                                <a href="{{ route('product.detail', $product->slug) }}">
                                    <h5 class="text-md font-semibold tracking-tight text-slate-900">
                                        {{ $product->nama_produk }}
                                    </h5>
                                </a>
                                <p class="text-xs sm:text-sm text-slate-700 my-2">
                                    {!! $product->mini_deskripsi !!}
                                </p>
                            </div>

                            <!-- Tombol di bawah -->
                            <a href="{{ route('product.detail', $product->slug) }}"
                                class="mt-4 flex items-center justify-center rounded-md bg-slate-900 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Cek detail
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-slate-500">Produk belum tersedia</p>
                @endforelse
            </div>


            <div class="text-center">
                <a href="/products"
                    class="border border-slate-900 text-slate-900 hover:text-white bg-white hover:bg-slate-900 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center transition duration-300 ease-in-out">
                    View All Products
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m4.5 5.25 7.5 7.5 7.5-7.5m-15 6 7.5 7.5 7.5-7.5" />
                    </svg>
                </a>
            </div>
        </div>
    </section>


    <!-- KEUNTUNGAN -->
    <section class="w-full h-full mx-auto p-5 mb-[5rem] sm:mb-[9rem] bg-gradient-to-b from-slate-100 to-white">
        <div class="fade-up grid grid-cols-1 lg:grid-cols-2 max-w-6xl mx-auto gap-[25px] md:mt-[3rem] items-center">

            <!-- Carousel -->
            <div class="relative w-full max-w-full sm:max-w-[480px] mx-auto">

                <!-- Shadow solid belakang -->
                <div
                    class="absolute top-3 left-3 w-full h-full bg-slate-900 shadow-md rounded-bl-[40px] rounded-tl-[40px] rounded-tr-[40px] rounded-br-[40px] sm:rounded-tr-[60px] sm:rounded-br-[60px] z-0">
                </div>
                <!-- Carousel Wrapper -->
                <div class="relative w-full aspect-[26/17] h-[350px] overflow-hidden z-10 border-2 border-slate-900 rounded-bl-[40px] rounded-tl-[40px] rounded-tr-[40px] rounded-br-[40px] sm:rounded-bl-xl sm:rounded-tl-xl sm:rounded-tr-[60px] sm:rounded-br-[60px]"
                    id="carousel-benefit">
                    @forelse($mbanner as $key => $banner)
                        <img src="{{ asset('storage/' . $banner->image) }}"
                            class="absolute inset-0 w-full h-full object-fit opacity-100 transition-opacity duration-1000" />
                    @empty
                    @endforelse
                </div>
            </div>

            <!-- Teks dan List -->
            <div class="relative mx-auto ml-0 sm:ml-5">
                <h1 class="text-slate-900 text-3xl sm:text-4xl my-5 font-bold text-center lg:text-left">
                    Keuntungan Menggunakan Produk Kami
                </h1>
                <ol class="space-y-4 list-none mt-5">
                    <li class="flex items-start gap-3">
                        <div
                            class="w-8 aspect-square bg-slate-900 text-white flex items-center justify-center rounded-md font-bold text-base shrink-0">
                            1
                        </div>
                        <p class="font-medium text-lg">Digital signage tersedia untuk berbagai bisnis dengan banyak
                            cabang.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <div
                            class="w-8 aspect-square bg-slate-900 text-white flex items-center justify-center rounded-md font-bold text-base shrink-0">
                            2
                        </div>
                        <p class="font-medium text-lg">Kontrol konten mudah secara online dari satu tempat.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <div
                            class="w-8 aspect-square bg-slate-900 text-white flex items-center justify-center rounded-md font-bold text-base shrink-0">
                            3
                        </div>
                        <p class="font-medium text-lg">Kirim informasi real-time ke seluruh cabang sekaligus.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <div
                            class="w-8 aspect-square bg-slate-900 text-white flex items-center justify-center rounded-md font-bold text-base shrink-0">
                            4
                        </div>
                        <p class="font-medium text-lg">Sistem fleksibel dan mudah disesuaikan dengan kebutuhan bisnis.
                        </p>
                    </li>
                    <li class="flex items-start gap-3">
                        <div
                            class="w-8 aspect-square bg-slate-900 text-white flex items-center justify-center rounded-md font-bold text-base shrink-0">
                            5
                        </div>
                        <p class="font-medium text-lg">Garansi 1 tahun sparepart, 2 tahun service gratis.</p>
                    </li>
                </ol>
            </div>

        </div>
    </section>
    <!-- HUBUNGI KAMI -->
    <section id="contact" class="w-full">
        <div class="fade-up relative bg-slate-900 text-gray-200 rounded-br-2xl rounded-bl-2xl overflow-hidden"
            style="background-image: url('{{ asset('img/pattern/maps.png') }}'); background-repeat: no-repeat; background-size: cover; background-position: center;">

            <div class="bg-slate-900/30 h-full mx-auto flex items-center">
                <div class="max-w-screen-xl w-full mx-auto px-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 sm:gap-2 my-10">
                        <!-- Kiri: Kontak, Alamat, Email -->
                        <div>
                            <h1 class="text-3xl font-semibold text-slate-50">Contact Information</h1>
                            <div
                                class="max-w-[32rem] p-4 mt-5 rounded-xl bg-white border-white/20 shadow-md text-white">
                                <h2 class="text-lg font-semibold text-slate-900 mb-3">Customer Service</h2>
                                <div class="flex items-center gap-3 mb-4">
                                    <i class="fa-solid fa-envelope text-slate-900 text-xl"></i>

                                    <span
                                        class="text-[15px] sm:text-lg text-slate-900">customer.service@metrodisplayadvpro.com</span>
                                </div>
                                <div class="flex items-center gap-3 mb-4">
                                    <i class="fa-solid fa-phone text-slate-900 text-xl"></i>
                                    @if ($whatsapp)
                                        <span class="text-[15px] sm:text-lg text-slate-900">
                                            {{ formatWhatsapp($whatsapp) }}
                                        </span>
                                    @else
                                        <span class="text-[15px] sm:text-lg text-slate-900">+62 858-1352-2977</span>
                                    @endif
                                </div>
                                <h2 class="text-lg font-semibold text-slate-900">Social Media & Store</h2>
                                <div class="flex gap-4 py-3 w-fit">
                                    <a href="{{ $socialMedia['instagram'] }}" target="_blank"
                                        class="w-18 h-18 tooltip bg-slate-900 rounded-md flex justify-center items-center"
                                        style="width:48px; height:48px;" data-tip="Instagram">
                                        <i class="fa-brands fa-instagram text-white text-2xl"></i>
                                    </a>
                                    <a href="{{ $socialMedia['tiktok'] }}" target="_blank"
                                        class="w-18 h-18 tooltip bg-slate-900 rounded-md flex justify-center items-center"
                                        style="width:48px; height:48px;" data-tip="Tiktok">
                                        <i class="fa-brands fa-tiktok text-white text-2xl"></i>
                                    </a>
                                    <a href="{{ $socialMedia['youtube'] }}" target="_blank"
                                        class="w-18 h-18 tooltip bg-slate-900 rounded-md flex justify-center items-center"
                                        style="width:48px; height:48px;" data-tip="YouTube">
                                        <i class="fa-brands fa-youtube text-white text-2xl"></i>
                                    </a>
                                    <a href="{{ $socialMedia['facebook'] }}" target="_blank"
                                        class="w-18 h-18 tooltip bg-slate-900 rounded-md flex justify-center items-center"
                                        style="width:48px; height:48px;" data-tip="Facebook">
                                        <i class="fa-brands fa-facebook-f text-white text-2xl"></i>
                                    </a>
                                    <a href="{{ $socialMedia['tokopedia'] }}" target="_blank"
                                        class="w-12 h-12 tooltip bg-slate-900 rounded-md flex justify-center items-center"
                                        data-tip="Tokopedia">
                                        <i class="fa-solid fa-store text-white text-2xl"></i>
                                    </a>
                                </div>
                            </div>
                            <div
                                class="max-w-[32rem] p-4 mt-5 rounded-xl bg-white border-white/20 shadow-md flex items-start
                            gap-4 text-white">
                                <!-- Icon SVG -->
                                <div class="w-10 h-10 bg-slate-900 rounded flex justify-center items-center">
                                    <i class="fa-solid fa-location-dot text-white text-xl"></i>
                                </div>
                                <!-- Text Content -->
                                <div class="text-slate-900">
                                    <p class="font-bold text-2xl mt-[3px]">Office</p>
                                    <ul class=""></ul>
                                    <p class="font-semibold text-lg">TM Harco Glodok Lt.6 AOF 56 <br> Jl. Hayam Wuruk
                                        No.2 </p>
                                    <p class="font-semibold text-lg mt-4">Glodok Plaza Lt. GF 41 <br> Jl. Pinangsia
                                        Raya
                                        No. 1</p>
                                </div>
                            </div>
                            <div
                                class="max-w-[32rem] p-4 mt-5 rounded-xl bg-white border-white/20 shadow-md flex items-start gap-4 text-white">
                                <!-- Icon SVG -->
                                <div class="w-10 h-10 bg-slate-900 rounded flex justify-center items-center">
                                    <i class="fa-solid fa-building text-white text-xl"></i>
                                </div>
                                <!-- Text Content -->
                                <div class="text-slate-900">
                                    <p class="font-bold text-2xl mt-[3px]">Showroom</p>
                                    <p class="font-semibold text-lg">TM Harco Glodok Lt. UG AOF 20-21 <br>Jl. Hayam
                                        Wuruk No. 02</p>
                                </div>
                            </div>
                        </div>

                        <!-- Kanan: Newsletter -->
                        <div class="bg-white w-full max-w-xl mt-[50px] p-6 rounded-xl shadow-lg">
                            <!-- Header Judul -->
                            <div class="mb-6">
                                <h2 class="text-2xl font-bold text-slate-900">Ajukan pertanyaan atau pesan</h2>
                                <p class="text-md text-gray-700 mt-1">Kami akan segera menghubungi anda</p>
                            </div>

                            <livewire:contact-form />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- TRUSTED PARTNER -->
    <section class="fade-up max-w-screen md:h-[600px] h-full mx-auto pt-[3rem] p-5 bg-gradient-to-b from-slate-100 to-white">
        <div class="flex flex-col max-w-screen-lg mx-auto md:flex-row gap-[25px]">
            <div class="flex-1 md:mx-auto p-2 mb-4">
                <h2 class="text-[30px] font-bold text-slate-900 text-center">Our Trusted Partner</h2>
            </div>
        </div>
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 justify-center items-center gap-2 mt-8">
                <!-- Gambar 1 -->
                <div class="flex justify-center items-center basis-1/2 md:basis-1/3 lg:basis-1/4">
                    <img src="{{ 'img/partner/Logo_Bareskrim.png' }}"
                        class="w-24 h-24 object-contain transition-transform duration-300 hover:scale-105"
                        alt="Image 1">
                </div>
                <!-- Gambar 2 -->
                <div class="flex justify-center items-center basis-1/2 md:basis-1/3 lg:basis-1/4">
                    <img src="{{ 'img/partner/BNI_logo.svg.png' }}"
                        class="w-24 h-24 object-contain transition-transform duration-300 hover:scale-105"
                        alt="Image 2">
                </div>
                <!-- Gambar 3 -->
                <div class="flex justify-center items-center basis-1/2 md:basis-1/3 lg:basis-1/4">
                    <img src="{{ 'img/partner/Logo_BMKG_(2010).png' }}"
                        class="w-24 h-24 object-contain transition-transform duration-300 hover:scale-105"
                        alt="Image 3">
                </div>
                <!-- Gambar 4 -->
                <div class="flex justify-center items-center basis-1/2 md:basis-1/3 lg:basis-1/4">
                    <img src="{{ 'img/partner/Lotte_Mart_2018.svg.png' }}"
                        class="w-36 h-36 object-contain transition-transform duration-300 hover:scale-105"
                        alt="Image 4">
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 flex-wrap justify-center items-center gap-2 mt-4">
                <!-- Gambar 5 -->
                <div class="flex justify-center items-center basis-1/2 md:basis-1/3 lg:basis-1/4">
                    <img src="{{ 'img/partner/Lambang_Kostrad.png' }}"
                        class="w-24 h-24 object-contain transition-transform duration-300 hover:scale-105"
                        alt="Image 5">
                </div>
                <!-- Gambar 6 -->
                <div class="flex justify-center items-center basis-1/2 md:basis-1/3 lg:basis-1/4">
                    <img src="{{ 'img/partner/jamkrindo_syariah.png' }}"
                        class="w-36 h-36 object-contain transition-transform duration-300 hover:scale-105"
                        alt="Image 6">
                </div>
                <!-- Gambar 7 -->
                <div class="flex justify-center items-center basis-1/2 md:basis-1/3 lg:basis-1/4">
                    <img src="{{ 'img/partner/kementan.png' }}"
                        class="w-24 h-24 object-contain transition-transform duration-300 hover:scale-105"
                        alt="Image 7">
                </div>
                <!-- Gambar 8 -->
                <div class="flex justify-center items-center basis-1/2 md:basis-1/3 lg:basis-1/4">
                    <img src="{{ 'img/partner/intikeramik-removebg-preview.png' }}"
                        class="w-48 h-48 object-contain transition-transform duration-300 hover:scale-105"
                        alt="Image 8">
                </div>
            </div>
        </div>
    </section>
    <!-- PARTNER USAHA -->
    <section class="w-full">
        <div class="fade-up relative bg-slate-900 text-gray-200 "
            style="background-image: url('{{ asset('img/pattern/footer.png') }}'); background-repeat: no-repeat; background-size: cover; background-position: center;">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-slate-900/90"></div>

            <!-- Content -->
            <div class="relative max-w-screen-lg mx-auto px-4 py-10 flex flex-col items-center text-center">

                <!-- Title -->
                <div class="mb-8">
                    <h2 class="text-[30px] font-bold text-white">
                        Partner Usaha Kami
                    </h2>
                    <span class="text-xl mt-4 font-semibold text-white mb-2 block">
                        Untuk kebutuhan sparepart display, dan alat-alat pendukung lainnya. <br> Cek marketplace partner
                        kami di bawah berikut.
                    </span>
                </div>

                <!-- Cards -->
                <div class="flex flex-wrap justify-center gap-10 w-full">
                    <!-- Card 1 -->
                    <a href="https://glodokshopedia.com" target="_blank"
                        class="group bg-white rounded-lg border-2 border-slate-900 shadow-lg overflow-hidden flex flex-col items-center text-center p-4 transition duration-300 max-w-[22rem] w-full h-80">
                        <img src="{{ asset('img/glodok_shopedia.png') }}" alt="Glodok Shopedia"
                            class="w-full h-40 object-cover rounded-md mb-4">
                        <h3 class="text-xl font-bold text-slate-900">Glodok Shopedia</h3>
                        <p class="text-sm font-medium text-black mt-2">
                            ini adalah contoh kalimat ajakan mengunjungi website
                        </p>
                    </a>

                    <!-- Card 2 -->
                    <a href="https://glodokharco.com" target="_blank"
                        class="group bg-white rounded-lg border-2 border-slate-900 shadow-lg overflow-hidden flex flex-col items-center text-center p-4 transition duration-300 max-w-[22rem] w-full h-80">
                        <img src="{{ asset('img/logo-slate.png') }}" alt="Glodok Harco"
                            class="max-w-xs h-40 object-cover rounded-md mb-4">
                        <h3 class="text-xl font-bold text-slate-900">Glodok Harco</h3>
                        <p class="text-sm font-medium text-black mt-2">
                            ini adalah contoh kalimat ajakan mengunjungi website
                        </p>
                    </a>
                </div>


            </div>
        </div>
    </section>
    <!-- FAQ -->
    <section id=" faq" class="w-full h-full mx-auto px-4 pb-10 pt-8 mt-[5rem] mb-[5rem] bg-white">
        <div class="fade-up grid grid-cols-1 lg:grid-cols-2 max-w-6xl mx-auto gap-[45px]">
            <!-- Kiri: Judul / Deskripsi -->
            <div>
                <h2 class="text-4xl md:text-6xl font-bold text-slate-900 mb-4 italic subpixel-antialiased">
                    Frequently Asked Questions
                </h2>
                <p class="text-slate-600 text-md md:text-lg text-justify leading-relaxed">
                    Berikut adalah pertanyaan umum terkait layanan kami. Jika Anda tidak menemukan jawaban yang Anda
                    cari, <span class="text-slate-900 font-semibold text-justify leading-relaxed">silahkan hubungi
                        kami</span>.
                </p>

                <!-- Link dengan jarak agak jauh ke bawah -->
                <div class="mt-5">
                    <a href="/home/faq" class="text-slate-900 font-semibold">
                        Pertanyaan Lebih Lengkap
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" stroke-width="1.5"
                            fill="currentColor" class="size-6 inline-block ml-2">
                            <path
                                d="M598.6 342.6C611.1 330.1 611.1 309.8 598.6 297.3L470.6 169.3C458.1 156.8 437.8 156.8 425.3 169.3C412.8 181.8 412.8 202.1 425.3 214.6L498.7 288L64 288C46.3 288 32 302.3 32 320C32 337.7 46.3 352 64 352L498.7 352L425.3 425.4C412.8 437.9 412.8 458.2 425.3 470.7C437.8 483.2 458.1 483.2 470.6 470.7L598.6 342.7z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Kanan: Accordion FAQ -->
            <div id="accordion-container" class="space-y-4">
                <!-- FAQ Item -->
                @forelse ($faq as $key => $faqs)
                    <div class="rounded-2xl border border-gray-300 transition hover:bg-slate-100">
                        <button type="button"
                            class="accordion-btn flex w-full items-center justify-between p-4 text-left focus:outline-none">
                            <h4 class="text-lg font-semibold">{{ $faqs->question }}</h4>
                            <svg class="h-6 w-6 transition-transform transform" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div
                            class="accordion-content px-4 overflow-hidden max-h-0 transition-all duration-300 ease-in-out">
                            <article class="text-base font-semibold pt-2 pb-4" id="Content-wrapper">
                                {!! $faqs->answer !!}
                            </article>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>

    @livewireScripts
    @include('partials.footer')
    @include('partials.button-to-top')

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const els = document.querySelectorAll(".fade-up");

            const io = new IntersectionObserver((entries) => {
                entries.forEach((entry, i) => {
                    if (entry.isIntersecting) {
                        // kasih delay berdasarkan index
                        setTimeout(() => {
                            entry.target.classList.add("show");
                        }, i * 150); // 150ms antar elemen
                    }
                });
            }, {
                threshold: 0.12
            });

            els.forEach(el => {
                el.classList.remove("show"); // reset animasi
                io.observe(el);
            });
        });
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/carousel-benefit.js') }}"></script>
    <script src="{{ asset('js/carousel-hero.js') }}"></script>
</body>

</html>
