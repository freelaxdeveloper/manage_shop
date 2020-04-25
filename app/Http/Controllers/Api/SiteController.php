<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Site;
use Illuminate\Http\Request;
use Auth;

class SiteController extends Controller
{
    public function index()
    {
//        $user = Auth::user()->load('sites');

        $sites = Site::get();

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
        $site_id = $request->input('site_id');
        $user = \Auth::user()->loadMissing('sites');

        $is_write = !!$user->sites()->where('id', $site_id)->count();

        site()->set($site_id);

        return response()->json([
            'message' => 'Success',
            'is_write' => $is_write,
        ]);
    }
}
