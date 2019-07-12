<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Balance;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $balances = Auth::user()->balances->first();

        return view('home', ['balance' => $balances]);
    }
}
