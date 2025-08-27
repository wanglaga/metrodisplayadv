<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\DB;

class SetSocialMediaData
{
    public function handle(Request $request, Closure $next)
    {
        $slug = $request->route('slug'); 
        $user = $this->incrementVisit($slug);

        if ($slug && !$user) {
            abort(404);
        }
        
        $socialMedia = null;

        if ($slug) {
            session(['active_user_slug' => $slug]);
            if ($user) {
                $user->load('detail');
                $socialMedia = $user->detail;
            }
        } else {
            session()->forget('active_user_slug');
            $socialMedia = SocialMedia::all();
        }

        view()->share('socialMedia', $socialMedia);

        return $next($request);
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
            'user_id' => $user?->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $user;
    }
    
}