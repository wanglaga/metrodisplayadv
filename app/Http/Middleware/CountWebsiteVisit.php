<?php

namespace App\Http\Middleware;

use Closure;

class CountWebsiteVisit
{
    public function handle($request, Closure $next)
    {
        $path = trim($request->path(), '/');

        // Middleware hanya melanjutkan hitung jika path adalah root (`/`) atau slug user
        // Path kosong artinya halaman home
        if ($path === '' || !str_contains($path, '/')) {
            return $next($request);
        }

        // Jika path mengandung lebih dari 1 segmen (misal home/about), lewati saja
        return $next($request);
    }
}
