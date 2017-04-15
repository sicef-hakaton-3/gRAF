<?php
namespace App\Services;

use App\Services\AbstractService;

/**
* 
*/
class WeatherService extends AbstractService
{
    private $key = "f8e889fdc169449da68144519160511";
    private $url = "http://api.apixu.com/v1/current.json";
    private $forcast = "http://api.apixu.com/v1/forecast.json";

    public function getForcastByCityName($city, $days) {
        $json = $this->getRemoteData(
            $json = $this->forcast .
                "?key=" . $this->key .
                "&q=" . $city .
                "&days=" . $days
        );

        return json_decode($json);
    }

    public function getWeatherByCityName($city) {

        $json = $this->getRemoteData(
            $json = $this->url . "?key=" . $this->key . "&q=" . $city
        );

        return json_decode($json);
    }

}