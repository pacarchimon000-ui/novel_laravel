<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WriterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user || (!$user->isWriter() && !$user->isAdmin())) {
            abort(403, 'Akses ditolak. Akun anda belum disetujui sebagai penulis.');
        }

        return $next($request);
    }
}
