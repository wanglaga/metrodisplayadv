<x-filament::page>
    <form wire:submit.prevent="submit" class="space-y-4">
        {{ $this->form }}
        <x-filament::button type="submit" color="info" icon="heroicon-o-arrow-up-tray">
            Import
        </x-filament::button>
    </form>
</x-filament::page>
