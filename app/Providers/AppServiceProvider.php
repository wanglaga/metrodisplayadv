<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Foundation\Vite;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Vite::class, function ($app) {
            // urutannya: manifestPath, hotFile, buildDirectory
            return new Vite(
                base_path('public/build/manifest.json'), // manifest
                base_path('public/hot'),                 // hot file
                'build'                                  // folder build
            );
        });
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
