<?php

namespace App\Http\Controllers;

use App\Services\PoiService;
use App\Services\WeatherService;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class CitiesController extends Controller
{

    public function getCityData(Request $request)
    {
        $lat = 51.52;
        $lng = -0.11;

        $photo = "CoQBdwAAAJmRDOXrj2ZLqyovohQRICjerBYd14eVNXCgNLPGuLhD7b0vd9KzYQm6v2hTKpOzrx8Rw-uxzGJgcRDSF6QA9-YZ2JyxlEkOXJwf3HheRUFoXRYEWcuoggAY7C9UcJhOfpWFtpR1KptnORjGafkEyfIeSLGOKTKpINWSJeMNRNBtEhBgMypQ0gAJ0U_zFr0KzUTeGhTfLQSfaRtm393hqRUrkLILsFobBA";

        $poi = new PoiService();
        $data = $poi->getPois($lat, $lng);

        $a = "ChIJ66NuMS8bdkgRb0YHGckT794";
        $b = "ChIJB9OTMDIbdkgRp0JWbQGZsS8";
        $data = $poi->getDistance($a, $b);
//

        echo "<pre>";
        print_r($data);
        echo "</pre>";

        return $data->rows[0]->elements[0]->duration->value;

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

        $data = $this->getCityData2($city, $k);

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
                // $count += $tempDis->rows[0]->elements[0]->duration->value;

                  $count += 400;
                $j++;
                $k++;
            }


        }

        return json_encode([
            "days" => $days
        ]);
    }

    private function getCityData2($city, $days) {
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
        $weatherData = $weather->getForcastByCityName($city, $days);


        $data["city"] = $weatherData->location->name;
        $data["country"] = $weatherData->location->country;
        $data["lat"] = $weatherData->location->lat;
        $data["lng"] = $weatherData->location->lon;

        for ($i = 0; $i < $days; $i++) {
            $data["days"][$weatherData->forecast->forecastday[$i]->date] = [
                "minTempC" => $weatherData->forecast->forecastday[$i]->day->mintemp_c,
                "maxTempC" => $weatherData->forecast->forecastday[$i]->day->maxtemp_c
            ];
        }

        return $data;

    }
}
