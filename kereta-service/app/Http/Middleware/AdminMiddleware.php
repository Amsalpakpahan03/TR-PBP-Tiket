<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->role !== 'admin') {
            return response()->json(['error' => 'Akses ditolak. Hanya admin.'], 403);
        }

        return $next($request);
    }
}
