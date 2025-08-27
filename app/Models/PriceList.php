<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PriceList extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pricelist', 'file_pdf', 'is_featured'];


    // Hapus file saat model dihapus
    protected static function booted()
    {
        // Hapus file saat record dihapus
        static::deleting(function ($priceList) {
            if ($priceList->file_pdf && Storage::disk('public')->exists($priceList->file_pdf)) {
                Storage::disk('public')->delete($priceList->file_pdf);
            }
        });

        // Pastikan hanya 1 featured
        static::saving(function ($priceList) {
            if ($priceList->is_featured) {
                // Set semua record lain is_featured = false
                static::where('id', '!=', $priceList->id)->update(['is_featured' => false]);
            }
        });
    }
}
