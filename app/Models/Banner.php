<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['nama', 'jenis_banner', 'image'];

    protected static function booted(): void
    {
        static::deleting(function ($banner) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
        });
    }
}

