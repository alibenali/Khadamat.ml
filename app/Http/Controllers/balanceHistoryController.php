<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BalanceHistory;
use Auth;

class balanceHistoryController extends Controller
{
    public function index(){
    	$BalanceHistory = BalanceHistory::where('user_id', Auth::id())->get();

    	return view('balances.history', ['BalanceHistory' => $BalanceHistory]);
    }
}
