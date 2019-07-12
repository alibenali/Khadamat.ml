<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Http\Requests\serviceRequest;
use Auth;

class ServicesController extends Controller
{



    // Logined if not go login 
    public function __construct(){
        $this->middleware('auth');
    }



	// Echo the list of the services
    function index($cat = 'all', $subcat = 'all'){

    	if($cat == 'all'){
    		$list_services = Service::all();
    	}else{

    		$list_services = Service::where('category', $cat)->get();

    		if($subcat != 'all'){
    			$list_services = Service::where('category', $cat)->where('sub_category', $subcat)->get();
    		}
    	}


    	return view('services/services', ['services' => $list_services]);
    }


	// Enter to the Service details (clicked in)
	function show($service){
    	$service = Service::find($service);

    	return view('services/service_details', ['service' => $service]);
    }



    // Form create service
    function create(){

        $this->authorize('create', Service::class);

        return view('services/create');
    }

    

    // Create service
    function store(serviceRequest $Request){

        $service = new Service;
        $service->title = $Request->input('title');
        $service->description = $Request->input('desc');
        $service->price = $Request->input('price');
        $service->p_method = $Request->input('p_method');
        $service->currency = $Request->input('currency');
        $service->duration = $Request->input('duration');
        $service->remaining = $Request->input('remaining');
        $service->img_path = str_replace("public", "", $Request->file('image')->store('public/img/services/'.date('Y').'/'.date('M').''));

        $service->save();

        session()->flash('success', 'The service has been created.');

        return view('services/create');
    }

}
