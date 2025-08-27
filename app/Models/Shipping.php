<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_shipping',
        'img',
        'is_featured',
    ];

    protected static function booted()
    {
        // Hapus file saat record dihapus
        static::deleting(function ($shipping) {
            if ($shipping->img && Storage::disk('public')->exists($shipping->img)) {
                Storage::disk('public')->delete($shipping->img);
            }
        });

        // Hapus file lama saat update
        static::updating(function ($shipping) {
            if ($shipping->isDirty('img')) {
                $oldImg = $shipping->getOriginal('img');
                if ($oldImg && Storage::disk('public')->exists($oldImg)) {
                    Storage::disk('public')->delete($oldImg);
                }
            }
        });
    }
}
