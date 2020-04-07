<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Site;

class AuthController extends BaseAuthController
{
    protected $loginView = 'admin.login';

    /**
     * Show the login page.
     *
     * @return Factory|Redirect|View
     */
    public function getLogin()
    {
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
        }

        $sites = Site::get();

        return view($this->loginView, compact('sites'));
    }

    public function postLogin(Request $request)
    {
        parent::postLogin($request);

        site()->set($request->input('site_id'));

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }
}
