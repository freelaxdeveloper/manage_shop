<?php

namespace App\Http\Controllers;

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
        $catbon = now();

        $toDayNumber = $catbon->day;
        $daysInMonth = $catbon->daysInMonth;
        $daysLeft = $daysInMonth - $toDayNumber + 1;

        $choice = Lang::choice('день|дня|дней', $daysLeft);

        $subtitle = "До конца месяца осталось: {$daysLeft} {$choice}";

        return view('home', compact('subtitle'));
    }
}
