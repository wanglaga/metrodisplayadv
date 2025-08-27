<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load helper global
        require_once app_path('Helpers/PhoneHelper.php');

        // View Composer header
        View::composer('partials.header', function ($view) {
            $categories = Category::whereNull('parent_id')
                ->orderBy('nama_kategori', 'asc')
                ->get();

            $view->with('categories', $categories);
        });

        // View Composer footer
        View::composer('partials.footer', function ($view) {
            $categories = Category::whereNull('parent_id')
                ->orderBy('nama_kategori', 'asc')
                ->get();

            $view->with('categories', $categories);
        });
    }

}
