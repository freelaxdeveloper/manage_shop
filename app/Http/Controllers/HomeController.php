<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use App\Category;
use Illuminate\Support\Facades\Lang;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $daysLeft = now()->daysInMonth - now()->day;
        $choice = Lang::choice('день|дня|дней', $daysLeft);
        $subtitle = "До конца месяца осталось: {$daysLeft} {$choice}";
        $sitename = site()->name;

        return view('home', compact('subtitle', 'sitename'));
    }
}
