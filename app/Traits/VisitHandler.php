<?php

namespace App\Traits;

use App\Models\User;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\DB;

trait VisitHandler
{
    // Method untuk hitung kunjungan
    protected function incrementVisit($slug = null)
    {
        $sessionKey = 'visited_' . ($slug ?? 'universal');

        // Kalau sudah pernah dikunjungi di session ini
        if (session()->has($sessionKey)) {
            return $slug ? User::where('slug', $slug)->first() : null;
        }

        // Tandai sudah dikunjungi
        session([$sessionKey => true]);

        $user = null;
        if ($slug) {
            $user = User::where('slug', $slug)->first();
            if ($user) {
                $user->increment('visit_count');
            } else {
                return null;
            }
        }

        // Tambah visit global
        DB::table('visits')->where('id', 1)->increment('count');

        // Catat log kunjungan
        DB::table('visit_logs')->insert([
            'slug' => $slug ?? 'universal',
            'user_id' => $user?->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $user;
    }

    // Method untuk ambil data social media
    protected function getSocialMediaData($slug, $user)
    {
        if (!$slug && session()->has('active_user_slug')) {
            $slug = session('active_user_slug');
            $user = \App\Models\User::where('slug', $slug)->first();
        }

        if ($slug) {
            session(['active_user_slug' => $slug]);

            if ($user) {
                $user->load('detail');

                if (
                    $user->detail && (
                        $user->detail->tokopedia ||
                        $user->detail->instagram ||
                        $user->detail->facebook ||
                        $user->detail->tiktok
                    )
                ) {
                    return $user->detail; // ini object, aman untuk halaman slug
                }

                // kalau tidak ada detail → kembalikan default collection
                return \App\Models\SocialMedia::all();
            }

            // slug tapi user tidak ketemu → kembalikan collection kosong
            return collect([]);
        } else {
            session()->forget('active_user_slug');
            return \App\Models\SocialMedia::all(); // default
        }
    }
}
