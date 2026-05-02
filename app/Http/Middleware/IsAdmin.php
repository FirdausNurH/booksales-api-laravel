<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * Middleware ini mengecek apakah request membawa Header 'X-Admin-Key' 
     * yang sesuai dengan value di file .env
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil key dari header, jika tidak ada defaultnya null
        $apiKey = $request->header('X-Admin-Key');

        // Bandingkan dengan key yang ada di file .env
        if ($apiKey !== env('ADMIN_API_KEY')) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Anda tidak memiliki izin admin.',
                'data'    => null
            ], 403);
        }

        return $next($request);
    }
}