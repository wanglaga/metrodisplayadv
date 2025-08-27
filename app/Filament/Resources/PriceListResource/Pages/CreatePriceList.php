<?php

namespace App\Filament\Resources\PriceListResource\Pages;

use App\Filament\Resources\PriceListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePriceList extends CreateRecord
{
    protected static string $resource = PriceListResource::class;

    protected function getFormSchema(): array
    {
        return array_map(function ($component) {
            // Set FileUpload menjadi required hanya di CreatePage
            if ($component instanceof \Filament\Forms\Components\FileUpload && $component->getName() === 'file_pdf') {
                $component->required();
            }
            return $component;
        }, parent::getFormSchema());
    }
}
