<?php

namespace App\Http\Middleware;

use Closure;

class BeforeAutoTrimmer {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->merge(array_map('trim', $request->all()));

        return $next($request);
    }
}