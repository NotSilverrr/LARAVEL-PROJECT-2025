<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRouteAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'route' => $request->route() ? $request->route()->getName() : null,
                    'uri' => $request->getRequestUri(),
                    'method' => $request->method(),
                ])
                ->log('Route accessed');
        }
        return $next($request);
    }
}
