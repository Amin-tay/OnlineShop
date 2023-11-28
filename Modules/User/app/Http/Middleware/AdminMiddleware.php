<?php

namespace Modules\User\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }
        if (!auth()->user()->hasAnyRole('superAdmin', 'normalAdmin')) {
            abort(403);
        }
        return $next($request);
    }
}
