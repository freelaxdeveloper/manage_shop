<?php

namespace App\Http\Middleware;

use App\Site;
use Closure;
use Auth;
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
        $user = optional(Auth::user())->loadMissing('sites');

        if (!$user) {
            return $next($request);
        }

        $site_id = site()->getId();
        if (!$site_id || !$user->sites()->where(Site::ID, $site_id)->count()) {
            if ($site = $user->sites()->first()) {
                site()->set($site->id);
            } else {
                Auth::logout();
                abort(403, 'Ваш список магазинов пуст!');
            }
        }

        return $next($request);
    }
}
