<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TwitterController extends Controller
{
    
    public function getsearch()
    {
    	return view('searchform');
    }

    public function posttweet(Request $request)
    {
    	$city = $request->get('search');
    	$response = \GoogleMaps::load('geocoding')
        ->setParam (['address' => $city])
        ->get();

        $stdClassObj = json_decode($response);
        $latitude = $stdClassObj->results[0]->geometry->location->lat;
        $longitude = $stdClassObj->results[0]->geometry->location->lng;
        dd('lat'. $latitude, 'lng'.$longitude);
    	return $response;
    }
}
