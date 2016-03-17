<?php
namespace App\Utilities;

use App\TwitterAPIExchange;
/**
*  Utility class to tnteract with Twitter API
*
* @author Arjun Sunar <arjunkoid@gmail.com>
* @package Utility
* @license http://laravel.com
*  
*/
class Twitter
{
	/**
	 * $latitude 
	 * @var mixed
	 */
	public $latitude;
	/**
	 * $longitude 
	 * @var mixed
	 */
	public $longitude;
	/**
	 * Fetch tweets by city with respect to lat, lat and 50km arround
     * 
	 * @throws \Exception
	 * @return array $data
	 */
	public function getTweetsByCity()
	{
		try {
			$latitude = $this->latitude;
			$longitude = $this->longitude;

			$km = env('TWITTER_SEARCH_AROUND_DIST');
			// $url = 'https://api.twitter.com/1.1/search/tweets.json';
			$uri = 'search/tweets.json';
			$url = $this->buildTwitterAPIUrl($uri);
			$getfield = "?q=''&geocode=".$latitude .",".$longitude ."," .$km.'"';
			$requestMethod = 'GET';
			
			$twitterData = $this->processInTwitterAPI($url,$requestMethod, $getfield);
		
			$data = array();

			foreach ($twitterData->statuses as $key => $value) {
				$data[$key][] = null;
				$data[$key][] = (!empty($value->coordinates)) ? $value->coordinates->coordinates[1]: null;
				$data[$key][] = (!empty($value->coordinates)) ? $value->coordinates->coordinates[0]: null;
				$data[$key][] = $key+1;
				$data[$key][] = $value->user->profile_image_url;
				$data[$key][] = '<div>' .$value->text. '  When <span>'. date('Y-m-d H:s', strtotime($value->created_at)).'</span></div>';

			}
			return $data;
		} catch (Exception $e) {
			throw new Exception("Error Processing Request while fetching tweets from twitter API", 1);
			
		}
	}
	/**
	 * Allow to process the twitter api to
     * Fetch the tweets
     * 
	 * @param  string $url
	 * @param  string $requestMethod 
	 * @param  string $getfield 
	 * @return array $twitterData
	 */
	public function processInTwitterAPI($url, $requestMethod, $getfield)
	{
		$settings = $this->getSettings();
		$twitter = new TwitterAPIExchange($settings);
		$response = $twitter->setGetfield($getfield)
		    ->buildOauth($url, $requestMethod)
		    ->performRequest();

		$twitterData = json_decode($response);

		return $twitterData;
	}
	/**
	 * Build the url of twitter API
     * The base url(https://api.twitter.com/1.1/)
     * is configured in .env file and read
     * $uri must be added to get full url
     * For example /search/twitter.json, 
     * /friends/list.json and so on.
     *  
	 * @param  string $uri
	 * @return string   $fullUrl
	 */
	public function buildTwitterAPIUrl($uri)
	{
		$fullUrl = env('TWITTER_API_URL') .''.$uri;
		return $fullUrl;
	}
	/**
	 * Set Twitter API credentials 
     * It should be read from .env file
     * To access the twitter api.API key 
     * Must needed
	 * 
	 * @return array settings
	 */
	private function getSettings()
	{
		$settings = array(
		    'oauth_access_token' => env('TWITTER_ACCESS_TOKEN'),
		    'oauth_access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
		    'consumer_key' => env('TWITTER_CONSUMER_KEY'),
		    'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
			);

		return $settings;
	}
}