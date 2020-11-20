<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Http\Requests\serviceRequest;
use Auth;
use App\PaymentMethod;
use App\Currency;
use App\service_category;
use App\service_sub_category;

class ServicesController extends Controller
{







	// Echo the list of the services
    function index($cat = 'all', $subcat = 'all'){

    	if($cat == 'all'){
    		$list_services = Service::where('the_status', 'open')->paginate(15);
    	}else{

    		$list_services = Service::where('category', $cat);

    		if($subcat != 'all'){
    			$list_services = Service::where('category', $cat)->where('sub_category', $subcat);
    		}

			$list_services = $list_services->where('the_status', 'open')->paginate(15);

    	}


    	return view('services/services', ['services' => $list_services]);
    }


	// Enter to the Service details (clicked in)
	public function show($service){

    	$service = Service::where('id', $service)->where('the_status', 'open')->first();

    	return view('services/service_details', ['service' => $service]);
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


    // Echo the list of the services
    public function search($search = ''){


    $list_services = Service::where('the_status', 'open')->where('title', 'like', '%' . $search . '%')->paginate(15);

        return view('services/services', ['services' => $list_services]);
    }


}
