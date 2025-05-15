<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Menangani permintaan yang masuk.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @param mixed ...$roles
     * @return Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Ambil level_kode dari user yang sedang login
        $userRole = $request->user()?->getRole();

        // Periksa apakah role user ada di dalam daftar role yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request); // Lanjutkan request jika diizinkan
        }

        // Jika tidak punya role yang diizinkan, tampilkan error 403
        abort(403, 'Forbidden. Kamu tidak punya akses ke halaman ini');
    }
}
