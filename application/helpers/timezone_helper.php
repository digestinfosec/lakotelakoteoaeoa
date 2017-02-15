<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('convert_to_timezone')) {

    function convert_to_timezone($ip, $date)
    {
        // can only be run in the development environment
        if (ENVIRONMENT == 'development') {
            $ip = "125.165.77.64";
        }
        $date = new DateTime($date);
        $record = geoip_record_by_name($ip);
        $location = $record["country_code"];
        $region = $record['region'];
        $timezone = new DateTimeZone(geoip_time_zone_by_country_and_region($location, $region));
        return $date->setTimeZone($timezone)->format("j F Y H:i:s");
    }
}
