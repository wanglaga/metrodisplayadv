<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserQrCodeController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Static pages
Route::get('/home/about', [HomeController::class, 'about'])->name('about');
Route::get('/category', [HomeController::class, 'category'])->name('category');
Route::get('/home/faq', [HomeController::class, 'faq'])->name('faq');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'detail'])->name('product.detail');

// Test route
Route::get('/test', [TestController::class, 'index'])->name('test.index');

// QR Code Routes (spesifik, jangan ditaruh setelah catch-all)
Route::get('/users/{user}/qrcode', [UserQrCodeController::class, 'show'])
    ->name('users.qrcode.show');

Route::get('/users/{user}/qrcode/download', [UserQrCodeController::class, 'download'])
    ->name('users.qrcode.download');

// Dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Settings
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Catch-all Home Route (paling bawah agar tidak menimpa route lain)
Route::get('/{slug}', [HomeController::class, 'index'])
    ->where('slug', '^(?!products|users|dashboard|settings|test).*$')
    ->name('home');

require __DIR__ . '/auth.php';
