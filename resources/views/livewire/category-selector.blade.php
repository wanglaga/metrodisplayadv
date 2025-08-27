<div>
    <div id="spinner" class="hidden">
        <span class="loading loading-spinner loading-md text-primary"></span>
        <span class="ml-2">Loading...</span>
    </div>

    {{-- Konten step --}}
    @if ($step === 1)
        <h2 class="text-lg font-semibold mb-2">Pilih Kategori 1:</h2>
        <div class="flex space-x-4">
            @foreach ($categoriesStep1 as $cat)
                <button wire:click="selectCategory1('{{ $cat }}')" class="btn btn-primary"
                    @if ($loading) disabled @endif>
                    {{ $cat }}
                </button>
            @endforeach
        </div>
    @elseif($step === 2)
        <h2 class="text-lg font-semibold mb-2">Pilih Kategori 2:</h2>
        <div class="flex space-x-4">
            @foreach ($categoriesStep2 as $cat)
                <button wire:click="selectCategory2('{{ $cat }}')" class="btn btn-secondary"
                    @if ($loading) disabled @endif>
                    {{ $cat }}
                </button>
            @endforeach
        </div>
    @elseif($step === 3)
        <h2 class="text-lg font-semibold mb-2">Hasil Pencarian:</h2>
        <p>{{ $result }}</p>
    @endif
</div>

<script>
    document.addEventListener('livewire:load', function() {
        window.Livewire.hook('message.processed', (message, component) => {
            message.response.effects.dispatches.forEach((dispatch) => {
                if (dispatch.event === 'loading-start') {
                    document.getElementById('spinner').classList.remove('hidden');
                }
                if (dispatch.event === 'loading-end') {
                    document.getElementById('spinner').classList.add('hidden');
                }
            });
        });
    });
</script>
