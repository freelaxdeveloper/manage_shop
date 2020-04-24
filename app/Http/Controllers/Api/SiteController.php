<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class SiteController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('sites');

        $sites = $user->sites;

        return response()->json(compact('sites'));
    }

    public function currentSite()
    {
        return response()->json([
            'site' => site()->getSite(),
        ]);
    }

    public function changeSite(Request $request)
    {
        site()->set($request->input('site_id'));

        return response()->json([
            'message' => 'Success',
        ]);
    }
}
