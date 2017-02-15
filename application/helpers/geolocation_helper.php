<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Get Geo Location by Given/Current IP address
 *
 * @access    public
 * @param    string
 * @return    array
 */
if (!function_exists('get_geolocation')) {

    function get_geolocation($ip)
    {
        $d = file_get_contents("http://api.ipinfodb.com/v3/ip-country/?key=5070aa9ea544b38910b30b1afa7f102a6ba903f8f42aad3a2cbe363de0e4958b&ip=$ip&format=json");

        if (!$d) {
            return false;
        } else {
            $result = json_decode($d);
        }

        return array(
            'countryName' => $result->countryName,
            'countryCode' => $result->countryCode
        );
    }
}
/* End of file geo_location_pi.php */
/* Location: ./system/plugins/geo_location_pi.php */
