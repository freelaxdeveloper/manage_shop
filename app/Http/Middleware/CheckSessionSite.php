<?php

namespace App\Http\Middleware;

use App\Site;
use Closure;
use Illuminate\Http\Request;

class CheckSessionSite
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!site()->getId()) {
            if ($site = Site::select(['id'])->first()) {
                site()->set($site->id);
            }
        }

        return $next($request);
    }
}
