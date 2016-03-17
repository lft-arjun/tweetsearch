<?php
namespace App\Utilities;

/**
* Get Code location from public IP
* 
* @author Arjun Sunar <arjunkoid@gmail.com>
* @package Utility
*/
class GeoLocation
{
	/**
	 * getLocationInfoByPublicId
	 * 
	 * @return array $geoInfo
	 */
	public function getLocationInfoByPublicId()
	{
		try {
			$ip = file_get_contents('https://api.ipify.org');
			$geoInfo = unserialize (file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));

			return $geoInfo;
		} catch (Exception $e) {
			throw new Exception("Error Processing Request while fetch geo code from public IP", 1);
		}
	}
	/**
	 * Fetch Geo Code by city using google maps API
	 * 
	 * @param  string $city 
	 * @return object $stdClassObj
	 */
	public function getGeoCodeByAddress($city)
	{
		$response = \GoogleMaps::load('geocoding')
			->setParam (['address' => $city])
			->get();

		$stdClassObj = json_decode($response);

		return $stdClassObj;
	}
}