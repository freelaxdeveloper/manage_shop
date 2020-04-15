<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DynamicDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('database')) {
            Config::set('database.connections.mysql.database', (session()->get('database')));

            DB::purge('mysql');
            DB::reconnect('mysql');
        }


        return $next($request);
    }
}
