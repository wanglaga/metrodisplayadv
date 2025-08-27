<?php

namespace App\Traits;

use App\Models\User;
use App\Models\SocialMedia;

trait HandleActiveUser
{
    /**
     * Ambil data user aktif, social media, WA, dan WA Lead
     */
    public function getActiveUserData(?string $slug = null): array
    {
        // Ambil default sosmed global
        $defaultSocial = SocialMedia::all()->keyBy('nama_sosmed');

        $user = null;

        // Jika ada slug di URL, pakai itu dan simpan ke session
        if ($slug) {
            $user = User::where('slug', $slug)->first();

            if (!$user) {
                abort(404);
            }

            session([
                'active_user_slug' => $slug,
            ]);
        } elseif (session()->has('active_user_slug')) {
            // Kalau slug tidak ada di URL, coba pakai yang ada di session
            $slug = session('active_user_slug');
            $user = User::where('slug', $slug)->first();
        }

        // Ambil sosmed (jika ada user → ambil user, kalau tidak → fallback default)
        $socialMediaData = collect([
            'whatsapp' => $user?->detail?->whatsapp_number ?? ($defaultSocial['WhatsApp']->phone_number ?? '#'),
            'tokopedia' => $user?->detail?->tokopedia ?? ($defaultSocial['Tokopedia']->link ?? '#'),
            'instagram' => $user?->detail?->instagram ?? ($defaultSocial['Instagram']->link ?? '#'),
            'tiktok' => $user?->detail?->tiktok ?? ($defaultSocial['Tiktok']->link ?? '#'),
            'facebook' => $user?->detail?->facebook ?? ($defaultSocial['Facebook']->link ?? '#'),
            'youtube' => $user?->detail?->youtube ?? ($defaultSocial['Youtube']->link ?? '#'),
        ]);

        // Simpan nomor WA user ke session supaya lebih cepat diakses halaman lain
        session(['active_whatsapp' => $socialMediaData['whatsapp']]);

        return [
            'user' => $user,
            'socialMedia' => $socialMediaData,
            'whatsapp' => $socialMediaData['whatsapp'],
            'wa_lead' => $defaultSocial['wa-lead'] ?? null,
        ];
    }

}
