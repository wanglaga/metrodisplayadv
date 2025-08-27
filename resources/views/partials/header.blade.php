        <div
            class="absolute inset-0 z-[-2] bg-white bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(120,119,198,0.3),rgba(255,255,255,0))]">
        </div>
        <!-- HEADER -->
        <header id="navbar"
            class="fixed top-0 left-0 w-full z-50 navbar-transition transition duration-300 ease-in-out bg-transparent text-white">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3 md:py-4">
                <!-- Logo -->
                <a href="/" id="company_name" class="flex text-xl font-bold text-slate-900 gap-2">
                    <img src="{{ asset('img/logo-slate.png') }}" data-white="{{ asset('img/logo-putih.png') }}"
                        data-dark="{{ asset('img/logo-slate.png') }}" alt="Metro Display Logo" id="navbarLogo"
                        class="h-6 md:h-7 lg:h-8 w-auto transition duration-300" />
                    Metro Display ADV
                </a>

                <nav class="hidden lg:flex items-center space-x-6 font-semibold text-md gap-3">
                    <a href="/" class="nav-item flex items-center text-slate-900 hover:opacity-95"
                        id="nav_beranda">Home</a>

                    <div class="nav-item relative group flex items-center">
                        <a href="#"
                            class="nav-item flex items-center gap-1 transition-opacity text-slate-900 hover:opacity-95">
                            Company
                            <svg class="w-6 h-6 mt-[2px]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <div
                            class="absolute left-0 mt-[9rem] w-52 text-md bg-white text-black rounded shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 z-50">
                            <a href="/home/about" class="block px-4 py-2 hover:bg-gray-100">About Us</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Layanan</a>
                        </div>
                    </div>
                    <div class="nav-item relative group flex items-center">
                        <a href="#"
                            class="nav-item flex items-center gap-1 transition-opacity text-slate-900 hover:opacity-95">
                            Product
                            <svg class="w-6 h-6 mt-[2px]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <div
                            class="absolute left-0 top-10 w-56 text-md bg-white text-black rounded shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 z-50">
                            @foreach ($categories as $category)
                                <a href="{{ url('/products?q=&category=' . $category->id) }}"
                                    class="block px-4 py-2 hover:bg-gray-100 hover:rounded
            {{ request('category') == $category->id ? 'bg-gray-100 font-semibold' : '' }}">
                                    {{ $category->nama_kategori }}
                                </a>
                            @endforeach
                        </div>

                    </div>
                    <a href="#" class="nav-item flex items-center text-slate-900 hover:opacity-95"
                        id="nav_contact">Store</a>

                    <!-- Tombol Contact Us -->
                    <a href="{{ url('/#contact') }}"
                        class="nav-kontak bg-white text-slate-900 font-semibold px-5 py-2 rounded-full shadow hover:bg-slate-100 transition duration-300"
                        id="nav_kontak">
                        Contact Us
                    </a>
                </nav>


                <!-- Mobile Menu Button -->
                <button id="menuBtn" class="lg:hidden text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-item h-7 w-7" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Sidebar Mobile -->
        <div id="sidebar"
            class="fixed top-0 left-0 w-64 h-full bg-slate-900 text-white transform -translate-x-full transition-transform duration-300 z-50 lg:hidden"
            x-data="{ layananOpen: false, produkOpen: false }">

            <div class="p-4 text-xl font-semibold">
                <img src="{{ asset('img/logo-putih.png') }}" alt="Metro Display Logo"
                    class="h-6 md:h-7 lg:h-8 w-auto" />
            </div>

            <nav class="flex flex-col gap-4 space-y-3 p-4 text-lg">
                <a href="/index.html" class="flex items-center gap-3 hover:text-gray-300 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" stroke-width="1.5" fill="currentColor"
                        class="size-6">
                        <path
                            d="M341.8 72.6C329.5 61.2 310.5 61.2 298.3 72.6L74.3 280.6C64.7 289.6 61.5 303.5 66.3 315.7C71.1 327.9 82.8 336 96 336L112 336L112 512C112 547.3 140.7 576 176 576L464 576C499.3 576 528 547.3 528 512L528 336L544 336C557.2 336 569 327.9 573.8 315.7C578.6 303.5 575.4 289.5 565.8 280.6L341.8 72.6zM304 384L336 384C362.5 384 384 405.5 384 432L384 528L256 528L256 432C256 405.5 277.5 384 304 384z" />
                    </svg>
                    <span class="text-lg items-center">Home</span>
                </a>

                <!-- Layanan with submenu -->
                <div>
                    <button @click="layananOpen = !layananOpen"
                        class="flex gap-3 items-center w-full hover:text-gray-300 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" stroke-width="1.5"
                            fill="currentColor" class="size-6">
                            <path
                                d="M256.5 37.6C265.8 29.8 279.5 30.1 288.4 38.5C300.7 50.1 311.7 62.9 322.3 75.9C335.8 92.4 352 114.2 367.6 140.1C372.8 133.3 377.6 127.3 381.8 122.2C382.9 120.9 384 119.5 385.1 118.1C393 108.3 402.8 96 415.9 96C429.3 96 438.7 107.9 446.7 118.1C448 119.8 449.3 121.4 450.6 122.9C460.9 135.3 474.6 153.2 488.3 175.3C515.5 219.2 543.9 281.7 543.9 351.9C543.9 475.6 443.6 575.9 319.9 575.9C196.2 575.9 96 475.7 96 352C96 260.9 137.1 182 176.5 127C196.4 99.3 216.2 77.1 231.1 61.9C239.3 53.5 247.6 45.2 256.6 37.7zM321.7 480C347 480 369.4 473 390.5 459C432.6 429.6 443.9 370.8 418.6 324.6C414.1 315.6 402.6 315 396.1 322.6L370.9 351.9C364.3 359.5 352.4 359.3 346.2 351.4C328.9 329.3 297.1 289 280.9 268.4C275.5 261.5 265.7 260.4 259.4 266.5C241.1 284.3 207.9 323.3 207.9 370.8C207.9 439.4 258.5 480 321.6 480z" />
                        </svg>
                        <span>Company</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="{'rotate-90': layananOpen} size-4 ml-auto">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                    <div x-show="layananOpen" x-transition
                        class="ml-[2.4rem] mt-4 flex flex-col space-y-2 gap-2 text-md text-white">
                        <a href="/about_us.html" class="hover:text-slate-100 font-medium">About Us</a>
                        <a href="#" class="hover:text-slate-100 font-medium">Layanan</a>
                    </div>
                </div>
                <div>
                    <button @click="produkOpen = !produkOpen"
                        class="flex gap-3 items-center w-full hover:text-gray-300 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" troke-width="1.5"
                            fill="currentColor" class="size-6">
                            <path
                                d="M96 160L96 400L544 400L544 160L96 160zM32 160C32 124.7 60.7 96 96 96L544 96C579.3 96 608 124.7 608 160L608 400C608 435.3 579.3 464 544 464L96 464C60.7 464 32 435.3 32 400L32 160zM192 512L448 512C465.7 512 480 526.3 480 544C480 561.7 465.7 576 448 576L192 576C174.3 576 160 561.7 160 544C160 526.3 174.3 512 192 512z" />
                        </svg>
                        <span>Product</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="{'rotate-90': produkOpen} size-4 ml-auto">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>


                    </button>
                    <div x-show="produkOpen" x-transition
                        class="ml-[2.4rem] mt-4 flex flex-col space-y-2 gap-2 text-md text-white">

                        @foreach ($categories as $category)
                            <a href="{{ url('/products?q=&category=' . $category->id) }}"
                                class="hover:text-slate-100 font-medium">
                                {{ $category->nama_kategori }}
                            </a>
                        @endforeach

                    </div>
                </div>

                <a href="#" class="flex items-center gap-3 hover:text-gray-300 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" stroke-width="1.5"
                        fill="currentColor" class="size-6">
                        <path
                            d="M224.2 89C216.3 70.1 195.7 60.1 176.1 65.4L170.6 66.9C106 84.5 50.8 147.1 66.9 223.3C104 398.3 241.7 536 416.7 573.1C493 589.3 555.5 534 573.1 469.4L574.6 463.9C580 444.2 569.9 423.6 551.1 415.8L453.8 375.3C437.3 368.4 418.2 373.2 406.8 387.1L368.2 434.3C297.9 399.4 241.3 341 208.8 269.3L253 233.3C266.9 222 271.6 202.9 264.8 186.3L224.2 89z" />
                    </svg>
                    Contact
                </a>
                <a href="#" class="flex items-center gap-3 hover:text-gray-300 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" stroke-width="1.5"
                        fill="currentColor" class="size-6">
                        <path
                            d="M94.7 136.3C101.6 112.4 123.5 96 148.4 96L492.4 96C517.3 96 539.2 112.4 546.2 136.3L569.6 216.5C582.4 260.2 549.5 304 504 304C477.7 304 454.6 289.1 443.2 266.9C431.6 288.8 408.6 304 381.8 304C355.2 304 332.1 289 320.5 267C308.9 289 285.8 304 259.2 304C232.4 304 209.4 288.9 197.8 266.9C186.4 289 163.3 304 137 304C91.4 304 58.6 260.3 71.4 216.5L94.7 136.3zM160.4 416L480.4 416L480.4 349.6C488 351.2 495.9 352 503.9 352C518.2 352 531.9 349.4 544.4 344.8L544.4 496C544.4 522.5 522.9 544 496.4 544L144.4 544C117.9 544 96.4 522.5 96.4 496L96.4 344.8C108.9 349.4 122.5 352 136.9 352C145 352 152.8 351.2 160.4 349.6L160.4 416z" />
                    </svg>
                    Store
                </a>
            </nav>
        </div>
