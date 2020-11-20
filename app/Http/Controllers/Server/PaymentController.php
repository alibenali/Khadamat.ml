<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;
use App\Http\Requests\serviceRequest;
use Auth;
use App\Payment;
use App\Payments_offer;
use App\PaymentMethod;
use App\Currency;
use App\service_category;
use App\service_sub_category;
use App\BalanceHistory;

class PaymentController extends Controller
{





	// Echo the list of the payments
    function index(){

    	$payments = Payment::where('creator_id', Auth::id())->get();


    	return view('server.payments.index', ['payments' => $payments]);
    }


    // Echo the list of the payments completed
    function indexEarning(){

        $BalanceHistory = BalanceHistory::where('user_id', Auth::id())->where('purpose', 'like', '%paid%')->get();

        return view('balances.history', ['BalanceHistory' => $BalanceHistory]);
    }

    public function destroy(Request $Request, $id){

    	$service = Service::find($id);
    	$service->delete();

    	return redirect('server/service');
    }
}
