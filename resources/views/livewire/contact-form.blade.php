<form wire:submit.prevent="submit" class="max-w-md mx-auto space-y-5">
    <!-- Nama -->
    <div>
        <label for="name" class="block text-sm font-medium text-slate-900 mb-1">Nama</label>
        <input wire:model.defer="name" type="text" id="name" placeholder="Masukkan nama lengkap Anda" required
            class="w-full px-4 py-3 rounded-lg border border-gray-300 text-slate-900 
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-slate-900 mb-1">Email</label>
        <input wire:model.defer="email" type="email" id="email" placeholder="contoh@email.com" required
            class="w-full px-4 py-3 rounded-lg border border-gray-300 text-slate-900 
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
    </div>

    <!-- No. Telepon -->
    <div>
        <label for="phone_number" class="block text-sm font-medium text-slate-900 mb-1">No. Telepon</label>
        <input wire:model.defer="phone_number" type="tel" id="phone_number" placeholder="08xxxxxxxxxx" required
            class="w-full px-4 py-3 rounded-lg border border-gray-300 text-slate-900 
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
    </div>

    <!-- Pesan -->
    <div>
        <label for="content" class="block text-sm font-medium text-slate-900 mb-1">Pesan</label>
        <textarea wire:model.defer="content" id="content" rows="4" placeholder="Tulis pesan Anda di sini..." required
            class="w-full px-4 py-3 rounded-lg border border-gray-300 text-slate-900 
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"></textarea>
    </div>

    <!-- Tombol Submit -->
    <div class="text-right">
        <button type="submit"
            class="bg-slate-900 text-white font-semibold py-3 px-6 rounded-lg hover:bg-slate-800 transition disabled:opacity-50"
            @disabled($loading)>
            <span wire:loading wire:target="submit" class="loading loading-spinner loading-sm mr-2"></span>
            {{ $buttonText }}
        </button>
    </div>
</form>

<script>
    window.addEventListener('resetButton', event => {
        console.log('resetButton event diterima');
        setTimeout(() => {
            @this.set('buttonText', 'Kirim Pesan');
            console.log('buttonText direset ke Kirim Pesan');
        }, 1000);
    });
</script>
