<?php
namespace App\Utilities;

use App\TwitterAPIExchange;
/**
*  Interact with Twitter API
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
	 * [processInTwitterAPI description]
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
	 * [buildTwitterAPIUrl description]
	 * @param  string $uri
	 * @return string   full url
	 */
	public function buildTwitterAPIUrl($uri)
	{
		$fullUrl = env('TWITTER_API_URL') .''.$uri;
		return $fullUrl;
	}
	/**
	 * API key from Twitter
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