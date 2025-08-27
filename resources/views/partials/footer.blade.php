    <section class="w-full">
        <footer class="relative bg-slate-900 text-gray-200"
            style="background-image: url('{{ asset('img/pattern/footer.png') }}'); background-repeat: no-repeat; background-size: cover; background-position: center;">
            <div class="bg-slate-900/90">
                <div class="container mx-auto py-14 px-6">
                    <div class="grid md:grid-cols-12 grid-cols-1 gap-7">
                        <div class="lg:col-span-4 col-span-12">
                            <a href="">
                                <div class="flex flex-wrap gap-2">
                                    <img src="{{ asset('img/logo-putih.png') }}" alt="" class="h-12">
                                    <span class="mt-2 font-bold text-white text-lg">Metro Display
                                        ADV</span>
                                </div>
                                <p class="mt-6 text-gray-200">Metro Display ADV bergerak dalam bidang penjualan
                                    teknologi
                                    layar Informasi dan komunikasi, Seperti LED Videotron, Digital Signage, Video Wall,
                                    Interactive Digital.</p>
                            </a>
                            <p class="text-white text-xl font-bold mt-4">Follow us</p>
                            <div class="flex py-3 w-fit">
                                <!-- Instagram -->
                                <a href="{{ $socialMedia['instagram'] }}" target="_blank"
                                    class="w-18 h-18 tooltip rounded-md flex justify-center items-center"
                                    style="width:48px; height:48px;" data-tip="Instagram">
                                    <i class="fa-brands fa-instagram text-white text-2xl"></i>
                                </a>

                                <!-- TikTok -->
                                <a href="{{ $socialMedia['tiktok'] }}" target="_blank"
                                    class="w-18 h-18 tooltip rounded-md flex justify-center items-center"
                                    style="width:48px; height:48px;" data-tip="Tiktok">
                                    <i class="fa-brands fa-tiktok text-white text-2xl"></i>
                                </a>

                                <!-- YouTube -->
                                <a href="{{ $socialMedia['youtube'] }}" target="_blank"
                                    class="w-18 h-18 tooltip rounded-md flex justify-center items-center"
                                    style="width:48px; height:48px;" data-tip="YouTube">
                                    <i class="fa-brands fa-youtube text-white text-2xl"></i>
                                </a>

                                <!-- Facebook -->
                                <a href="{{ $socialMedia['facebook'] }}" target="_blank"
                                    class="w-18 h-18 tooltip rounded-md flex justify-center items-center"
                                    style="width:48px; height:48px;" data-tip="Facebook">
                                    <i class="fa-brands fa-facebook-f text-white text-2xl"></i>
                                </a>

                                <!-- Tokopedia -->
                                <a href="{{ $socialMedia['tokopedia'] }}" target="_blank"
                                    class="w-12 h-12 tooltip rounded-md flex justify-center items-center"
                                    data-tip="Tokopedia">
                                    <i class="fa-solid fa-store text-white text-2xl"></i>
                                </a>
                            </div>


                        </div>
                        <div class="lg:col-span-2 md:col-span-4 col-span-12">
                            <h5 class="tracking-wide text-gray-100 font-semibold">Information</h5>
                            <ul class="list-none mt-6 space-y-2">
                                <li><a href="/index.html"
                                        class="text-gray-300 hover:text-gray-400 transition-all duration-500 ease-in-out">Home</a>
                                </li>
                                <li><a href="#"
                                        class="text-gray-300 hover:text-gray-400 transition-all duration-500 ease-in-out">Company</a>
                                </li>
                                <li><a href="#"
                                        class="text-gray-300 hover:text-gray-400 transition-all duration-500 ease-in-out">Product</a>
                                </li>
                                <li><a href="#"
                                        class="text-gray-300 hover:text-gray-400 transition-all duration-500 ease-in-out">Store</a>
                                </li>
                                <li><a href="#"
                                        class="text-gray-300 hover:text-gray-400 transition-all duration-500 ease-in-out">Contact
                                        Us</a>
                                </li>
                            </ul>
                        </div>
                        <div class="lg:col-span-2 md:col-span-4 col-span-12">
                            <h5 class="tracking-wide text-gray-100 font-semibold">Produk Unggulan Kami</h5>
                            <ul class="list-none mt-6 space-y-2">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ url('/products?q=&category=' . $category->id) }}"
                                            class="text-gray-300 hover:text-gray-400 transition-all duration-500 ease-in-out
               {{ request('category') == $category->id ? 'font-semibold text-gray-100' : '' }}">
                                            {{ $category->nama_kategori }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="border-t border-slate-700">
                    <div class="md:text-left text-center font-medium container mx-auto py-7 px-6">
                        <p class="mb-0">
                            &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            Metro Display ADV. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </section>
