<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @if (app()->environment('local'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Production: pakai hasil build Vite -->
        <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
        <script type="module" src="{{ asset('build/assets/app.js') }}"></script>
    @endif
</head>

<body>
    @include('partials.header')

    <section class="max-w-screen-lg mx-auto p-2 mt-[5rem] sm:mt-[8rem] text-center">
        <h1 class="text-5xl sm:text-7xl font-bold mb-2">
            Frequently Asked
        </h1>
        <span class="bg-clip-text text-5xl sm:text-7xl font-bold text-transparent bg-cover bg-center"
            style="background-image: url('{{ asset('img/pattern/bg-text.jpg') }}');">
            Questions
        </span>

        <p class="mt-4 text-gray-800 text-[18px] max-w-xl mx-auto">
            Butuh bantuan atau memiliki pertanyaan seputar layanan kami?
        </p>
    </section>
    <section class="max-w-screen-lg mx-auto p-2 mt-8 sm:mt-10">
        <div id="accordion-container" class="space-y-4">
            @forelse($faqs as $key => $faq)
                <div class="rounded-2xl border border-gray-300 transition hover:bg-gray-100 duration-300 ease-in-out">
                    <button type="button"
                        class="accordion-btn flex w-full items-center justify-between p-4 text-left focus:outline-none">
                        <h4 class="text-lg font-semibold">{{ $faq->question }}</h4>
                        <svg class="h-6 w-6 transition-transform transform" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content px-4 overflow-hidden max-h-0 transition-all duration-300 ease-in-out">
                        <article class="text-base font-semibold pt-2 pb-4" id="Content-wrapper">
                            {!! $faq->answer !!}
                        </article>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </section>
    <section class="max-w-screen-lg mx-auto p-2 mt-8 mb-15 sm:mt-10 text-center">
        <h2 class="text-3xl font-bold mb-2">Ada pertanyaan lain?</h2>
        <p class="text-gray-600 mb-6">
            Jangan ragu untuk mengirimkan email kepada kami melalui alamat di bawah ini:
        </p>

        <div class="flex flex-wrap items-center justify-center gap-2">
            <span id="email"
                class="px-4 py-2 bg-gray-200 text-gray-900 rounded-md font-medium break-all sm:break-normal sm:truncate max-w-xs sm:max-w-md">
                customer.service@metrodisplayadvpro.com
            </span>

            <div class="tooltip" data-tip="Salin email" id="tooltipCopy">
                <button id="copyBtn"
                    class="px-4 py-2 bg-gray-800 text-white rounded-md flex items-center gap-1 hover:bg-gray-700">
                    copy
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16h8m-4-4h4m-6 8h6a2 2 0 002-2V8l-6-6H8a2 2 0 00-2 2v4" />
                    </svg>
                </button>
            </div>
        </div>
    </section>


    @include('partials.footer')

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-[2px] bg-opacity-40 hidden z-1 lg:hidden">
    </div>

    @include('partials.button-to-top')


    <script>
        const copyBtn = document.getElementById("copyBtn");
        const emailEl = document.getElementById("email");
        const tooltip = document.getElementById("tooltipCopy");

        copyBtn.addEventListener("click", () => {
            navigator.clipboard.writeText(emailEl.textContent).then(() => {
                tooltip.setAttribute("data-tip", "Email berhasil disalin!");
                setTimeout(() => tooltip.setAttribute("data-tip", "Salin email"), 2000);
            });
        });
    </script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
