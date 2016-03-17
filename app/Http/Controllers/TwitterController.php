<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Utilities\Twitter;
use App\Utilities\GeoLocation;
use Log;

class TwitterController extends Controller
{
    
    public function getsearch()
    {
    	// $ip = file_get_contents('https://api.ipify.org');
    	// echo "My public IP address is: " . $ip;
    	// $geoCode = unserialize (file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));

    	dd($geoCode);
    	// $ob = new Twitter();
    	// dd($ob->getTweetsByPlace());
    	// // $data = $this->getResponseFromT();
    	// // dd($data);
    	// return view('searchform');
    }
    /**
     * Fetch tweets from twitter search api
     * 
     * @param  Request $request [
     * @return array tweets search result
     */
    public function gettweet(Request $request)
    {
    	try {
	    	$data = array();
	    	$geoObj = new GeoLocation();
	    	$geoInfo = $geoObj->getLocationInfoByPublicId();
	    	$latitude = $geoInfo['geoplugin_latitude'];
	    	$longitude = $geoInfo['geoplugin_longitude'];
		    $city = $request->get('search');
	    	if ($city){
	    		//Get latitude and longitude from city 
		    	$response = \GoogleMaps::load('geocoding')
		        ->setParam (['address' => $city])
		        ->get();

		        $stdClassObj = json_decode($response);
		        
		        $latitude = $stdClassObj->results[0]->geometry->location->lat;
		        $longitude = $stdClassObj->results[0]->geometry->location->lng;

		        $objects = new Twitter();
		        $objects->latitude = $latitude;
		        $objects->longitude = $longitude;
				$data = $objects->getTweetsByCity();

			}

    		return view('twitter',['twitterData'=> $data, 'lat'=>$latitude, 'long'=> $longitude]);
    	} catch(Exception $e) {
    		Log::error('Tweet Result:', ['error' => $e->getMessage()]);
    	}
    }

    
}
