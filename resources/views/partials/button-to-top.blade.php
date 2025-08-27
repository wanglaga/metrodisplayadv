    <!-- Customer Care & Back to Top Btn -->
    <div x-data="{ open: false, showTop: false }" x-init="window.addEventListener('scroll', () => { showTop = window.scrollY > 300 })" x-cloak>

        <!-- Tombol WhatsApp -->
        <button @click="open = !open"
            class="fixed right-5 transition-all duration-300 ease-out
           bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg
           w-14 h-14 flex items-center justify-center z-40"
            :class="showTop ? 'bottom-20' : 'bottom-5'">

            <!-- Ikon WhatsApp -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                class="absolute inset-0 m-auto w-9 h-9 fill-current">
                <path
                    d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z" />
            </svg>
        </button>


        <!-- Popup WhatsApp -->
        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="fixed right-5 w-80 bg-white rounded-lg shadow-lg overflow-hidden"
            :class="showTop ? 'bottom-40' : 'bottom-24'" x-cloak>

            <!-- Header -->
            <div class="bg-green-500 p-4 text-white font-semibold flex justify-between items-center">
                <span>Chat dengan Admin</span>
                <button @click="open = false" class="text-white text-xl leading-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-5 h-5 text-white-500 mt-1"
                        fill="currentColor">
                        <path
                            d="M183.1 137.4C170.6 124.9 150.3 124.9 137.8 137.4C125.3 149.9 125.3 170.2 137.8 182.7L275.2 320L137.9 457.4C125.4 469.9 125.4 490.2 137.9 502.7C150.4 515.2 170.7 515.2 183.2 502.7L320.5 365.3L457.9 502.6C470.4 515.1 490.7 515.1 503.2 502.6C515.7 490.1 515.7 469.8 503.2 457.3L365.8 320L503.1 182.6C515.6 170.1 515.6 149.8 503.1 137.3C490.6 124.8 470.3 124.8 457.8 137.3L320.5 274.7L183.1 137.4z" />
                    </svg>
                </button>
            </div>

            <div class="px-4 pt-4 text-sm text-gray-600">
                Hai! Silahkan pilih tim CS untuk memulai chat via WhatsApp
            </div>

            <div class="divide-y divide-gray-200 p-3">

                @if ($whatsapp)
                    <!-- Customer Care 1 -->
                    <a href="https://wa.me/{{ $whatsapp }}" target="_blank"
                        class="flex items-start p-4 rounded-lg border border-transparent hover:border-green-500 hover:bg-gray-50 transition-all duration-300 ease-in-out">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                            class="w-8 h-8 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor">
                            <path
                                d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z" />
                        </svg>
                        <div>
                            <div class="font-semibold text-gray-700">Metro Display ADV Sales Care</div>
                            <div class="text-gray-600 text-xs">
                                Klik untuk memulai chat
                            </div>
                        </div>
                    </a>
                @else
                    <div
                        class="flex items-start p-4 rounded-lg border border-transparent hover:border-slate-700 hover:bg-gray-50 transition-all duration-300 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                            class="w-8 h-8 text-slate-900 mt-1 mr-2 flex-shrink-0" fill="currentColor">
                            <path
                                d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM320 200C333.3 200 344 210.7 344 224L344 336C344 349.3 333.3 360 320 360C306.7 360 296 349.3 296 336L296 224C296 210.7 306.7 200 320 200zM293.3 416C292.7 406.1 297.6 396.7 306.1 391.5C314.6 386.4 325.3 386.4 333.8 391.5C342.3 396.7 347.2 406.1 346.6 416C347.2 425.9 342.3 435.3 333.8 440.5C325.3 445.6 314.6 445.6 306.1 440.5C297.6 435.3 292.7 425.9 293.3 416z" />
                        </svg>
                        <div>
                            <div class="font-semibold text-gray-700">Costumer Care Tidak Tersedia</div>
                            <div class="text-gray-600 text-xs">
                                Silahkan untuk mengirimkan email
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Customer Care 2 -->
                <a href="https://wa.me/{{ $wa_lead->phone_number }}" target="_blank"
                    class="flex items-start p-4 rounded-lg border border-transparent hover:border-green-600 hover:bg-gray-50 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"
                        class="w-8 h-8 text-green-500 mt-1 mr-2 flex-shrink-0" fill="currentColor">
                        <path
                            d="M476.9 161.1C435 119.1 379.2 96 319.9 96C197.5 96 97.9 195.6 97.9 318C97.9 357.1 108.1 395.3 127.5 429L96 544L213.7 513.1C246.1 530.8 282.6 540.1 319.8 540.1L319.9 540.1C442.2 540.1 544 440.5 544 318.1C544 258.8 518.8 203.1 476.9 161.1zM319.9 502.7C286.7 502.7 254.2 493.8 225.9 477L219.2 473L149.4 491.3L168 423.2L163.6 416.2C145.1 386.8 135.4 352.9 135.4 318C135.4 216.3 218.2 133.5 320 133.5C369.3 133.5 415.6 152.7 450.4 187.6C485.2 222.5 506.6 268.8 506.5 318.1C506.5 419.9 421.6 502.7 319.9 502.7zM421.1 364.5C415.6 361.7 388.3 348.3 383.2 346.5C378.1 344.6 374.4 343.7 370.7 349.3C367 354.9 356.4 367.3 353.1 371.1C349.9 374.8 346.6 375.3 341.1 372.5C308.5 356.2 287.1 343.4 265.6 306.5C259.9 296.7 271.3 297.4 281.9 276.2C283.7 272.5 282.8 269.3 281.4 266.5C280 263.7 268.9 236.4 264.3 225.3C259.8 214.5 255.2 216 251.8 215.8C248.6 215.6 244.9 215.6 241.2 215.6C237.5 215.6 231.5 217 226.4 222.5C221.3 228.1 207 241.5 207 268.8C207 296.1 226.9 322.5 229.6 326.2C232.4 329.9 268.7 385.9 324.4 410C359.6 425.2 373.4 426.5 391 423.9C401.7 422.3 423.8 410.5 428.4 397.5C433 384.5 433 373.4 431.6 371.1C430.3 368.6 426.6 367.2 421.1 364.5z" />
                    </svg>
                    <div>
                        <div class="font-semibold text-gray-700">Metro Display ADV Customer Service</div>
                        <div class="text-gray-600 text-xs">
                            Silahkan lampirkan nota pembelian/bukti pembayaran dan silahkan jelaskan kronologinya agar
                            dapat cepat diproses, terimakasih
                        </div>
                    </div>
                </a>
            </div>
        </div>


        <!-- Tombol Back to Top -->
        <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed right-5 bottom-5 transition-all duration-300 ease-out
           bg-slate-800 hover:bg-slate-700 text-white rounded-full shadow-lg
           w-14 h-14 flex items-center justify-center z-40"
            x-show="showTop" x-transition>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
            </svg>
        </button>
    </div>
    <!-- Customer Care & Back to Top Btn -->
