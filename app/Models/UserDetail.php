<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'whatsapp_number', 'tokopedia', 'instagram', 'facebook', 'tiktok'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getWhatsappFormattedAttribute(): ?string
    {
        $number = $this->whatsapp_number ?? '';
        if (empty($number))
            return null;

        // Hilangkan semua karakter selain angka
        $digits = preg_replace('/\D/', '', $number);

        // Jika nomor mulai dengan '0', ubah ke '62'
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }

        // Jika nomor mulai dengan '62' sudah benar
        elseif (str_starts_with($digits, '62') === false) {
            // tambahkan default country code 62
            $digits = '62' . $digits;
        }

        // Format (+62) 858-0645-6134
        if (strlen($digits) >= 12) {
            return sprintf(
                "(+%s) %s-%s-%s",
                substr($digits, 0, 2),
                substr($digits, 2, 3),
                substr($digits, 5, 4),
                substr($digits, 9)
            );
        }

        // fallback: return apa adanya
        return $number;
    }

}
