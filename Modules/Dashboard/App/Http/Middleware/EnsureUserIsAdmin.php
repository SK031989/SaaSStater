<?php

namespace Modules\Dashboard\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('admin.login')->with('error', 'Unauthorized. Please login to access the admin area.');
        }

        return $next($request);
    }
}
