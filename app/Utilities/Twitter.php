<?php
namespace App\Utilities;

use App\TwitterAPIExchange;
/**
* 
*/
class Twitter
{
	public $latitude;
	public $longitude;

	public function getTweetsByCity()
	{
		try {
			$latitude = $this->latitude;
			$longitude = $this->longitude;

			$km = env('TWITTER_SEARCH_AROUND_DIST');
			$settings = array(
			    'oauth_access_token' => env('TWITTER_ACCESS_TOKEN'),//"546974375-3Blkj072NWAnyZCV1HZpv870KChdiHc4eaaLwV9g",
			    'oauth_access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),//"DEjXEuNj8HtsTn4DH283FbV3YzthzZNqVTI02OlnxreEf",
			    'consumer_key' => env('TWITTER_CONSUMER_KEY'),//"Gki3J8QKp0AZ3AjSAmf2myUO0",
			    'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),//"7WNIuas3VzConhgcCXuXRE3IIEOLHxIU3rIGBMGmQ7z44DDkfu"
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
				$data[$key][] = '<div>' .$value->text. '  When <span>'. date('Y-m-d H:s', strtotime($value->created_at)).'</span></div>';

			}
			return $data;
		} catch (Exception $e) {
			throw new Exception("Error Processing Request while fetching tweets from twitter API", 1);
			
		}
	}
}