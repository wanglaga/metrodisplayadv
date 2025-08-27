<?php

if (!function_exists('formatWhatsapp')) {
    /**
     * Format nomor WA menjadi (+62) XXX-XXXX-XXXX
     * Bisa menangani:
     * - 085806456134
     * - +6285806456134
     * - 6285806456134
     * - 85806456134
     *
     * @param string|null $number
     * @return string|null
     */
    function formatWhatsapp(?string $number): ?string
    {
        if (empty($number))
            return null;

        // Hapus semua karakter selain angka
        $digits = preg_replace('/\D/', '', $number);

        // Tangani kode negara default Indonesia
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (!str_starts_with($digits, '62')) {
            $digits = '62' . $digits;
        }

        $length = strlen($digits);

        // Format sederhana: (+62) XXX-XXXX-XXXX
        if ($length >= 12) {
            return sprintf(
                "(+%s) %s-%s-%s",
                substr($digits, 0, 2),        // kode negara
                substr($digits, 2, 3),        // 3 digit pertama
                substr($digits, 5, 4),        // 4 digit berikutnya
                substr($digits, 9)            // sisanya
            );
        }

        // fallback: return apa adanya
        return $number;
    }
}
