<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class ItemCounter extends BaseWidget
{

    protected function getStats(): array
    {
        // Ambil total kunjungan dari tabel visits (id = 1)
        $totalVisits = DB::table('visits')->where('id', 1)->value('count') ?? 0;

        return [
            Card::make('Total User', User::count())
                ->description('Jumlah user terdaftar')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info')
                ->chart([2, 3, 4, 7, 9, 12, 16])
                ->url(route('filament.admin.resources.users.index')) // 👈 ini penting
                ->extraAttributes(['class' => 'cursor-pointer']),

            Card::make('Total Kategori', Category::count())
                ->description('Kategori tersedia')
                ->descriptionIcon('heroicon-o-tag')
                ->color('gray')
                ->chart([14, 12, 9, 8, 7, 9, 12])
                ->url(route('filament.admin.resources.categories.index')) // 👈 ini penting
                ->extraAttributes(['class' => 'cursor-pointer']),

            Card::make('Total Produk', Product::count())
                ->description('Produk yang tersedia')
                ->descriptionIcon('heroicon-o-computer-desktop')
                ->color('warning')
                ->chart([17, 12, 14, 7])
                ->url(route('filament.admin.resources.products.index')) // 👈 ini penting
                ->extraAttributes(['class' => 'cursor-pointer']),

            Card::make('Kunjungan Website', $this->formatNumber($totalVisits))
                ->description('Total Kunjungan Website')
                ->descriptionIcon('heroicon-o-eye')
                ->color('success')
                ->chart([6, 12, 9, 15, 11, 14, 10])
                ->url(route('filament.admin.resources.visit-logs.index'))

        ];
    }

    //Number Fixer
    private function formatNumber($number)
    {
        if ($number >= 1000 && $number < 10000) {
            return number_format($number, 0, ',', '.');
        } elseif ($number >= 10000) {
            return number_format($number / 1000, 1, ',', '.') . 'k';
        }
        return $number;
    }
}
