<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'slug',
        'category_id',
        'is_featured',
        'mini_deskripsi',
        'deskripsi',
        'spesifikasi',
        'main_image',
        'thumbnails',
        'stock',
        'operating_system',
        'size',
        'user_id',
        'youtube_link'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'spesifikasi' => 'array',
        'thumbnails' => 'array',
        'size' => 'array', // tambahkan ini
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        //Auto Slug
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->nama_produk);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('nama_produk')) {
                $product->slug = Str::slug($product->nama_produk);
            }
        });

        //Delete Main IMG & Thumb
        static::deleting(function ($product) {
            // Hapus main image
            if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                Storage::disk('public')->delete($product->main_image);
            }

            // Hapus thumbnails
            $thumbnails = is_array($product->thumbnails)
                ? $product->thumbnails
                : json_decode($product->thumbnails, true);

            foreach ($thumbnails ?? [] as $thumb) {
                if ($thumb && Storage::disk('public')->exists($thumb)) {
                    Storage::disk('public')->delete($thumb);
                }
            }
        });

        //Delete Main IMG & Thumb (Update)
        static::updating(function ($product) {
            $original = $product->getOriginal();

            // Cek apakah main image diubah
            if (
                $original['main_image'] &&
                $original['main_image'] !== $product->main_image &&
                Storage::disk('public')->exists($original['main_image'])
            ) {
                Storage::disk('public')->delete($original['main_image']);
            }

            // Cek apakah thumbnails diubah
            $oldThumbs = is_array($original['thumbnails'])
                ? $original['thumbnails']
                : json_decode($original['thumbnails'], true);

            $newThumbs = is_array($product->thumbnails)
                ? $product->thumbnails
                : json_decode($product->thumbnails, true);

            $deletedThumbs = array_diff($oldThumbs ?? [], $newThumbs ?? []);

            foreach ($deletedThumbs as $thumb) {
                if ($thumb && Storage::disk('public')->exists($thumb)) {
                    Storage::disk('public')->delete($thumb);
                }
            }
        });
    }
}
