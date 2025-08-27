<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;

class VisitController extends Controller
{
    public function home()
    {
        $this->incrementVisit();
        return view('welcome');
    }

    public function userLanding($slug)
    {
        $user = $this->incrementVisit($slug);
        if (!$user) {
            abort(404);
        }
        return view('landing', compact('user'));
    }

    private function incrementVisit($slug = null)
    {
        $sessionKey = 'visited_' . ($slug ?? 'universal');

        if (session()->has($sessionKey)) {
            return $slug ? User::where('slug', $slug)->first() : null;
        }

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

        DB::table('visits')->where('id', 1)->increment('count');

        DB::table('visit_logs')->insert([
            'slug' => $slug ?? 'universal',
            'user_id' => $user?->id, // NULL jika universal
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $user;
    }
}
