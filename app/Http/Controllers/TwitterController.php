<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TwitterAPIExchange;

class TwitterController extends Controller
{
    
    public function getsearch()
    {
    	
    	// $data = $this->getResponseFromT();
    	// dd($data);
    	return view('searchform');
    }

    public function gettweet(Request $request)
    {
    	$data = array();
    	$latitude = 27;
    	$longitude = 85;
	    	$city = $request->get('search');
	    	if ($city){
		    	$response = \GoogleMaps::load('geocoding')
		        ->setParam (['address' => $city])
		        ->get();

		        $stdClassObj = json_decode($response);
		        $km = "50km";
		        $latitude = $stdClassObj->results[0]->geometry->location->lat;
		        $longitude = $stdClassObj->results[0]->geometry->location->lng;

		        $settings = array(
				    'oauth_access_token' => "546974375-3Blkj072NWAnyZCV1HZpv870KChdiHc4eaaLwV9g",
				    'oauth_access_token_secret' => "DEjXEuNj8HtsTn4DH283FbV3YzthzZNqVTI02OlnxreEf",
				    'consumer_key' => "Gki3J8QKp0AZ3AjSAmf2myUO0",
				    'consumer_secret' => "7WNIuas3VzConhgcCXuXRE3IIEOLHxIU3rIGBMGmQ7z44DDkfu"
					);
					$url = 'https://api.twitter.com/1.1/search/tweets.json';
					$getfield = "?q=''&geocode=".$latitude .",".$longitude ."," .$km.'"';
					$requestMethod = 'GET';

					$twitter = new TwitterAPIExchange($settings);
					$response = $twitter->setGetfield($getfield)
					    ->buildOauth($url, $requestMethod)
					    ->performRequest();

					$twitterData = json_decode($response);
					
					$data = array();
					foreach ($twitterData->statuses as $key => $value) {
						$data[$key][] = null;
						$data[$key][] = (!empty($value->coordinates)) ? $value->coordinates->coordinates[1]: null;
						$data[$key][] = (!empty($value->coordinates)) ? $value->coordinates->coordinates[0]: null;
						$data[$key][] = $key;
						$data[$key][] = $value->user->profile_image_url;
						$data[$key][] = '<div>' .$value->text. ' <span>'. date('Y-m-d H:s', strtotime($value->created_at)).'</span></div>';

					}
				}
    	return view('twitter',['twitterData'=> $data, 'lat'=>$latitude, 'long'=> $longitude]);
    }

    
}
