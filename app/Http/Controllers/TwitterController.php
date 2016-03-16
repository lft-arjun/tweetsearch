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

    public function posttweet(Request $request)
    {
    	$city = $request->get('search');
    	$response = \GoogleMaps::load('geocoding')
        ->setParam (['address' => $city])
        ->get();

        $stdClassObj = json_decode($response);
        $km = "1km";
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
			// dd($twitterData->statuses);
			$data = array();
			foreach ($twitterData->statuses as $key => $value) {
				// dd($value->coordinates->coordinates);
				// 
				$data[$key][] = null;
				$data[$key][] = (!empty($value->coordinates)) ? $value->coordinates->coordinates[1]: null;
				$data[$key][] = (!empty($value->coordinates)) ? $value->coordinates->coordinates[0]: null;
				$data[$key][] = $key;
				$data[$key][] = $value->user->profile_image_url;
				$data[$key][] = '<div>' .$value->text. '</div>';

				// $data[$key]['tweet'] = $value->text;
			}
			// dd($data);
    	return view('twitter',['twitterData'=> $data, 'lat'=>$latitude, 'long'=> $longitude]);
    }

    private function buildBaseString($baseURI, $method, $params)  
	{
	    $r = array(); 
	    ksort($params);
	    foreach($params as $key=>$value){
	        $r[] = "$key=" . rawurlencode($value); 
	    }
    	return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r)); 
	}

	private function buildAuthorizationHeader($oauth)  
	{
	    $r = 'Authorization: OAuth '; 
	    $values = array(); 
	    foreach($oauth as $key=>$value)
	        $values[] = "$key='" . rawurlencode($value) . "'"; 
	    $r .= implode(', ', $values); 
	    return $r; 
	}

	private function getResponseFromT()
	{
		$url = "https://api.twitter.com/1.1/search/tweets.json?q=''&geocode=27.7172453,85.3239605,1km";

		$oauth_access_token = "546974375-3Blkj072NWAnyZCV1HZpv870KChdiHc4eaaLwV9g";
		$oauth_access_token_secret = "DEjXEuNj8HtsTn4DH283FbV3YzthzZNqVTI02OlnxreEf";
		$consumer_key = "Gki3J8QKp0AZ3AjSAmf2myUO0";
		$consumer_secret = "7WNIuas3VzConhgcCXuXRE3IIEOLHxIU3rIGBMGmQ7z44DDkfu";

		$oauth = array( 'oauth_consumer_key' => $consumer_key,
		                'oauth_nonce' => time(),
		                'oauth_signature_method' => 'HMAC-SHA1',
		                'oauth_token' => $oauth_access_token,
		                'oauth_timestamp' => time(),
		                'oauth_version' => '1.0');

		$base_info = $this->buildBaseString($url, 'GET', $oauth);
		$composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
		$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
		$oauth['oauth_signature'] = $oauth_signature;
		$header = array($this->buildAuthorizationHeader($oauth), 'Expect:');
		$options = array( CURLOPT_HTTPHEADER => $header,
		                  CURLOPT_HEADER => false,
		                  CURLOPT_URL => $url,
		                  CURLOPT_RETURNTRANSFER => true,
		                  CURLOPT_SSL_VERIFYPEER => false);

		$feed = curl_init();
		curl_setopt_array($feed, $options);  
		$json = curl_exec($feed);
		curl_close($feed);

		$twitter_data = $json;//json_decode($json);

		return $twitter_data;
	}
}
