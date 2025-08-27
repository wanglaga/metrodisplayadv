<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{

    protected $fillable = ['nama_kategori', 'slug', 'image', 'parent_id'];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    protected static function booted(): void
    {
        // Saat membuat kategori baru → buat slug otomatis
        static::creating(function ($category) {
            $category->slug = Str::slug($category->nama_kategori);
        });

        // Saat update → perbarui slug hanya jika nama_kategori berubah
        static::updating(function ($category) {
            if ($category->isDirty('nama_kategori')) {
                $category->slug = Str::slug($category->nama_kategori);
            }
        });

        // Saat hapus kategori → hapus gambar dari storage
        static::deleting(function ($category) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
        });
    }

}
