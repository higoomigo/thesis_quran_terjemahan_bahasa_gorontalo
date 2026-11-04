<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role;

        // role kosong / null = publik
        if (empty($userRole) || ! in_array($userRole, $roles, true)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki hak untuk membuka halaman ini.');
        }

        return $next($request);
    }
}