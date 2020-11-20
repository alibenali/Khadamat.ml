<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;
use App\Http\Requests\serviceRequest;
use Auth;
use App\PaymentMethod;
use App\Currency;
use App\service_category;
use App\service_sub_category;

class ServiceController extends Controller
{






	// Echo the list of the services
    function index(){

    	$services = Service::where('creator_id', Auth::id())->get();


    	return view('server.services.index', ['services' => $services]);
    }

	function edit($service_id){

    	$service = Service::where('id', $service_id)->first();
        $payment_methods = PaymentMethod::all();
        $currencies = Currency::all();

        $categories = service_category::all();
        $sub_categories = service_sub_category::all();

    	return view('server.services.edit', ['service' => $service, 'payment_methods' => $payment_methods, 'currencies' => $currencies, 'categories' => $categories, 'sub_categories' => $sub_categories]);
    }

	// Enter to the Service details (clicked in)
	public function show($service){

    	$service = Service::where('id', $service)->where('the_status', 'open')->first();

    	return view('server.services/details', ['service' => $service]);
    }


    // Form create service
    public function create(){

        $this->authorize('create', Service::class);

        $payment_methods = PaymentMethod::all();
        $currencies = Currency::all();

        $categories = service_category::all();
        $sub_categories = service_sub_category::all();

        return view('server.services.create', ['payment_methods' => $payment_methods, 'currencies' => $currencies, 'categories' => $categories, 'sub_categories' => $sub_categories]);
    }
    

    function fetch(Request $request)
    {
     $select = $request->get('select');
     $value = $request->get('value');
     $dependent = $request->get('dependent');

     $data = service_sub_category::where('cat_slug', '=', $value)->get();

     if($data->count() > 1){
        $output = '<option value="">Select sub category</option>';
     }else{
        $output = '';
     }

     foreach($data as $row)
     {
      $output .= '<option value="'.$row->slug_name.'">'.$row->name.'</option>';
     }
     echo $output;
    }


    function update(serviceRequest $Request, $service_id){

    	

    	$service = Service::find($service_id);

        $service->title = $Request->input('title');
        $service->category = $Request->input('category');
        $service->sub_category = $Request->input('sub_category');
        $service->description = $Request->input('desc');
        $service->price = $Request->input('price');
        $service->p_method = $Request->input('p_method');
        $service->currency = $Request->input('currency');
        $service->duration = $Request->input('duration');
        $service->remaining = $Request->input('remaining');
        $service->the_status = $Request->input('status');

        if($service->the_status == 'open')
        {
        	$service->the_status = 'pending';
        }

		if(isset($Request->image)) {

        $user = Auth::user();
        $picName = 'services/'.date('M').date('Y').'/'.$user->id.'_service_pic'.time().'.'.request()->image->getClientOriginalExtension();

        $Request->image->storeAs('',$picName);

        $service->img_path = $picName;
    	}
        //$service->img_path = str_replace("public", "", $Request->file('image')->store('public/img/services/'.date('Y').'/'.date('M').''));
		

        $service->save();

    	return view('server.services/details', ['service' => $service]);
    }

    // Create service
    function store(serviceRequest $Request){

		$Request->validate([
			'image'           => 'required|image|mimes:jpeg,jpg,png|max:2048',
		]);

        $service = new Service;
        $service->creator_id = Auth::id();
        $service->title = $Request->input('title');
        $service->category = $Request->input('category');
        $service->sub_category = $Request->input('sub_category');
        $service->description = $Request->input('desc');
        $service->price = $Request->input('price');
        $service->p_method = $Request->input('p_method');
        $service->currency = $Request->input('currency');
        $service->duration = $Request->input('duration');
        $service->remaining = $Request->input('remaining');
        $service->the_status = 'pending';

        $user = Auth::user();
        $picName = 'services/'.date('M').date('Y').'/'.$user->id.'_service_pic'.time().'.'.request()->image->getClientOriginalExtension();

        $Request->image->storeAs('',$picName);

        $service->img_path = $picName;

        //$service->img_path = str_replace("public", "", $Request->file('image')->store('public/img/services/'.date('Y').'/'.date('M').''));

        $service->save();

        return back()
            ->with('success','The service has been created.');
    }


    public function destroy(Request $Request, $id){

    	$service = Service::find($id);
    	$service->delete();

    	return redirect('server/service');
    }
}
