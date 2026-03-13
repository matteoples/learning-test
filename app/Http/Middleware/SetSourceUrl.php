<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSourceUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('dashboard') || $request->is('calendar')) {
            session(['sourceURL' => $request->fullUrl()]);
        }

        return $next($request);
    }
}
