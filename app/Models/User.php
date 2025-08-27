<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    // Disarankan: jangan mass-assign slug
    protected $fillable = [
        'name',
        'email',
        'password',
        // 'slug'  // biarkan dikontrol otomatis
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi tunggal yang konsisten
    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    // Biar route model binding pakai slug: /users/{user} -> {user}=slug
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted()
    {
        // Saat membuat record pertama kali
        static::creating(function (self $user) {
            if (empty($user->slug)) {
                $user->slug = static::makeUniqueSlug($user->name);
            }
        });

        // Saat menyimpan (create/update): perbarui slug jika name berubah
        static::saving(function (self $user) {
            if ($user->isDirty('name')) {
                $user->slug = static::makeUniqueSlug($user->name, $user->id);
            }
        });

        // Pastikan selalu ada row user_details
        static::created(function (self $user) {
            if (!$user->detail()->exists()) {
                $user->detail()->create();
            }
        });
    }

    // Generator slug unik
    protected static function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'user';
        $slug = $base;
        $n = 2;

        while (
            static::query()
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base . '-' . $n;
            $n++;
        }

        return $slug;
    }

    // Optional helper kamu, tetap dipertahankan
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
