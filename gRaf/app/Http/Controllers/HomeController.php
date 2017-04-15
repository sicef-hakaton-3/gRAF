<?php

namespace App\Http\Controllers;

use App\Services\PoiService;
use Illuminate\Http\Request;
use Illuminate\Html\HtmlServiceProvider;
use App\Services\WeatherService;

class HomeController extends Controller
{
    public function index()
    {
        return view("index");
    }

    public function city(Request $request)
    {
        $city = $request->city;

        $from = $request->from;
        $to = $request->to;

        $startTime = strtotime($from);
        $endTime = strtotime($to);
        $days = [];

        for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
            $days[] = date( 'Y-m-d', $i ); // 2010-05-01, 2010-05-02, etc
        }

        $data = $this->getCityData($city, count($days));


        $poi = new PoiService();
        $places = $poi->getPois($data["lat"], $data["lng"]);

        $hotelService = new \App\Services\HotelService;
        $hotels = $hotelService->getHotels($city);

        usort($places, function($a, $b) {
            if (!isset($a->rating)) return 1;
            if (!isset($b->rating)) return -1;
            return($a->rating < $b->rating);
        });

        $tmp = [];
        foreach($places as $place) {
            $x = [
                "placeID" => $place->place_id,
                "lat" => $place->geometry->location->lat,
                "lng" => $place->geometry->location->lng,
                "name" => $place->name,
                "rating" => 0,
                "photo" => ""
            ];

            if (isset($place->rating)) {
                $x["rating"] = ceil($place->rating);
            }

            if (isset($place->photos) && count($place->photos) > 0) {
                $x["photo"] = $poi->getPhoto($place->photos[0]->photo_reference);
            }

            $tmp[] = $x;
        }

        $wiki = new \App\Services\WikiService;
        $w = $wiki->getDescriptionByCityName($city);

        //print_r($w);

        return view("city", [
            "city" =>  ucfirst($city),
            "from" => $from,
            "to" => $to,
            "country" => $data["country"],
            "lat" => $data["lat"],
            "lng" => $data["lng"],
            "days" => $data["weather"],
            "places" => $tmp,
            "hotels" => $hotels,
            "wiki" => $w
        ]);
    }


    private function getCityData($city, $days) {
        $data = [
            "city" => "",
            "country" => "",
            "lat" => "",
            "lng" => "",
            "date" => "",
            "time" => "",
            "days" => []
        ];

        $weather = new WeatherService();
        $weatherData = $weather->getForcastByCityName(str_replace(" ", "_",$city), $days);


        $data["city"] = $weatherData->location->name;
        $data["country"] = $weatherData->location->country;
        $data["lat"] = $weatherData->location->lat;
        $data["lng"] = $weatherData->location->lon;

        for ($i = 0; $i < $days; $i++) {
            $data["weather"][$weatherData->forecast->forecastday[$i]->date] = [
                "minTempC" => $weatherData->forecast->forecastday[$i]->day->mintemp_c,
                "maxTempC" => $weatherData->forecast->forecastday[$i]->day->maxtemp_c
            ];
        }

        return $data;

    }

    public function days(Request $request)
    {
        $city = $request->city;
        $likes = explode('-graf-', $request->places);
        $hours = explode('-', $request->times);

        $from = $request->from;
        $to = $request->to;

        $startTime = strtotime($from);
        $endTime = strtotime($to);
        $days = [];
        $k = 0;
        for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
            $k++;
        }

        if (count($hours) == 0) {
            for ($i = 0; $i < $k; $i++)
                $hours[] = 4;
        }

        $data = $this->getCityData($city, $k);

        $poi = new PoiService();
        $places = $poi->getPois($data["lat"], $data["lng"]);

        $tmp = [];
        foreach($places as $place) {

            $x = [
                "lat" => $place->geometry->location->lat,
                "lng" => $place->geometry->location->lng,
                "name" => $place->name,
                "place_id" => $place->place_id,
                "rating" => 0,
                "photo" => ""
            ];

            if (isset($place->rating)) {
//                return $likes;
                if(in_array($place->place_id, $likes)) {

                    $x["rating"] = $place->rating + 5;
                } else {
                    $x["rating"] = $place->rating;
                }
            }
//            echo $x["rating"] ."<br>";
            if (isset($place->photos) && count($place->photos) > 0) {
                $x["photo"] = $poi->getPhoto($place->photos[0]->photo_reference);
            }

            $tmp[] = $x;
        }

        usort($tmp, function($a, $b) {
            return($a['rating'] < $b['rating']);
        });

        $startTime = strtotime($from);
        $endTime = strtotime($to);
        $days = [];
        $k = 0;

        for ($t = 0, $i = $startTime; $i <= $endTime; $i = $i + 86400, $t++ ) {
            // 2010-05-01, 2010-05-02, etc

            $d = date( 'Y-m-d', $i );
            $days[$d] = [];
            $days[$d][] = $tmp[$k];
            $k++;
            $j = 1;
            $count = 0;

            while ($k < count($tmp) && $t < count($hours) && $count < $hours[$t] * 80 ) {
                $days[$d][] = $tmp[$k];
                $tempDis = $poi->getDistance($days[$d][$j - 1]['place_id'],
                                             $days[$d][$j]['place_id']);


                $count += 400;


                $j++;
                $k++;
            }


        }

        return view("days", [
            "city" =>  ucfirst($city),
            "from" => $from,
            "country" => $data["country"],
            "lat" => $data["lat"],
            "lng" => $data["lng"],
            "to" => $to,
            "days" => $days,
            "weather" => $data["weather"]
        ]);
    }



}
