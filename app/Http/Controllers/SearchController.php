<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class SearchController extends Controller
{
    function fetch(Request $request)
    {
    
    $request->validate([
    'searchInputValue' => 'required|max:255|string',
    ]);

     $searchInputValue = $request->get('searchInputValue');

     $data = Service::where('title', 'like', '%' . $searchInputValue . '%')->where('the_status', 'open')->get();

     if($data->count() >= 1){
        //$output = '<a>Services : </a>';
        $output = '';
     }else{
        $output = '';
     }

     foreach($data as $row)
     {
      $url = url('service/search/'.$searchInputValue);
      $output .= '<a href="'.$url.'">'.$row->title.'</a>';
     }
     echo $output;
    }
}
