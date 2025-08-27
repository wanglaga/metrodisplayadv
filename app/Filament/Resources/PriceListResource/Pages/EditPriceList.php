<?php

namespace App\Filament\Resources\PriceListResource\Pages;

use App\Filament\Resources\PriceListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditPriceList extends EditRecord
{
    protected static string $resource = PriceListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Hapus file lama jika ada file baru
        if (request()->hasFile('file_pdf')) {
            if ($this->record->file_pdf && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->record->file_pdf)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($this->record->file_pdf);
            }
        } else {
            // Hapus dari data supaya tidak meng-update file_pdf menjadi null
            unset($data['file_pdf']);
        }

        return $data;
    }
}
