<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Utilities\Twitter;
use App\Utilities\GeoLocation;
use Log;
/**
 * Twitter Controller Class
 * Handle all the twitter api
 * Related operations
 */
class TwitterController extends Controller
{
    /**
     * Fetch tweets from twitter search api
     * 
     * @param  Request $request [
     * @return array tweets search result
     */
    public function gettweet(Request $request)
    {
    	try {
    		/**
    		 *  get current geo location by default
    		 *  (while land the page) and display map with tweets
    		 * @var GeoLocation
    		 */
	    	$geoObj = new GeoLocation();
	    	$geoInfo = $geoObj->getLocationInfoByPublicId();
	    	$latitude = $geoInfo['geoplugin_latitude'];
	    	$longitude = $geoInfo['geoplugin_longitude'];

	    	$data = $this->processTweets($latitude, $longitude);

		    $city = $request->get('search');
		    if (empty($city)) {
		    	$city = $geoInfo['geoplugin_city'];

		    } else {
	    		//Get latitude and longitude from city 
		    	$response = \GoogleMaps::load('geocoding')
		        ->setParam (['address' => $city])
		        ->get();

		        $stdClassObj = json_decode($response);
		        
		        $latitude = $stdClassObj->results[0]->geometry->location->lat;
		        $longitude = $stdClassObj->results[0]->geometry->location->lng;
		        $data = $this->processTweets($latitude, $longitude);
			}

    		return view('twitter',['twitterData'=> $data, 'lat'=>$latitude, 'long'=> $longitude, 'city' => $city]);
    	} catch(Exception $e) {
    		Log::error('Tweet Result:', ['error' => $e->getMessage()]);
    	}
    }
    /**
     * Proccess to get tweets data 
     * By latitude and longitude
     * 
     * @param   decimal $latitude  
     * @param   decimal $longitude
     * @return  array $data
     */
    private function processTweets($latitude, $longitude)
    {
    	$objects = new Twitter();
        $objects->latitude = $latitude;
        $objects->longitude = $longitude;
		$data = $objects->getTweetsByCity();

		return $data;
    }

    
}
