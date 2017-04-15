<?php

namespace App\Services;

/**
*
*/
class PoiService extends AbstractService
{

    private $url = "https://maps.googleapis.com/maps/api/place/photo?";
    private $key = "AIzaSyAaxHJVBs36Wz58w-M8TtHseE9GGE26Y5k";
//https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=CnRtAAAATLZNl354RwP_9UKbQ_5Psy40texXePv4oAlgP4qNEkdIrkyse7rPXYGd9D_Uj1rVsQdWT4oRz4QrYAJNpFX7rzqqMlZw2h2E2y5IKMUZ7ouD_SlcHxYq1yL4KbKUv3qtWgTK0A6QbGh87GB3sscrHRIQiG2RrmU_jF4tENr9wGS_YxoUSSDrYjWmrNfeEHSGSc3FyhNLlBU&key=YOUR_API_KEY
	public function getPois($lat, $long){
		$data = json_decode($this->getRemoteData(
            "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$lat.",".$long."&radius=5000&type=museum|amusement_park|park|point_of_interestk&key=".$this->key
        ));

		return  $data->results;

	}

	public function getPhoto($id) {
        return $this->url .
                "maxwidth=150" .
                "&photoreference=" . $id .
                "&key=" . $this->key;

        return $data;
    }

    public function getDistance($a, $b) {
        return json_decode($this->getRemoteData(
            "https://maps.googleapis.com/maps/api/distancematrix/json?origins=place_id:".$a.
                "&destinations=place_id:".$b.
                "&mode=walking&units=metric&key=".$this->key));


    }




}
