<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\VisitHandler;
use App\Models\SocialMedia;
use App\Models\User;

class TestController extends Controller
{
    use VisitHandler;

    public function index(Request $request, $slug = null)
    {
        $user = $this->incrementVisit($slug);

        if ($slug && !$user) {
            abort(404);
        }

        // Ambil semua sosmed terkait user (kalau ada slug)
        $socialMediaData = $this->getSocialMediaData($slug, $user);

        // Tentukan WhatsApp berdasarkan kondisi
        if ($slug && $user) {
            // slug aktif -> ambil dari user_details
            $whatsapp = $user->detail?->whatsapp_number;

            // simpan slug & WA ke session supaya terbawa halaman lain
            session([
                'active_user_slug' => $slug,
                'active_whatsapp' => $whatsapp
            ]);
        } elseif (session()->has('active_user_slug')) {
            // slug kosong tapi ada session → pakai data dari session
            $activeSlug = session('active_user_slug');
            $user = User::where('slug', $activeSlug)->first();
            $whatsapp = optional($user?->detail)->whatsapp_number ?? session('active_whatsapp');
        } else {
            // fallback global ke social_media
            $wa = SocialMedia::where('nama_sosmed', 'WhatsApp')->first();
            $whatsapp = $wa?->phone_number;
        }

        return view('test.index', [
            'socialMedia' => $socialMediaData,
            'whatsapp' => $whatsapp
        ]);
    }


}
