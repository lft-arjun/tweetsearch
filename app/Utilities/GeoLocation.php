<?php
namespace App\Utilities;

/**
* Get Code location from public IP
*/
class GeoLocation
{
	/**
	 * [getLocationInfoByPublicId description]
	 * 
	 * @return array geoInfo
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
}