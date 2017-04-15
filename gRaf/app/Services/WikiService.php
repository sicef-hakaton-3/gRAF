<?php
namespace App\Services;

use App\Services\AbstractService;

/**
* 
*/
class WikiService extends AbstractService
{
	public function getDescriptionByCityName($city){


		$data = (array)json_decode($this->getRemoteData("http://api.geonames.org/wikipediaSearchJSON?q=".str_replace(" ", "%20",$city)."&maxRows=10&username=graf3"));
		$data = (array)$data['geonames'];

		foreach ($data as $value) {
			if (strtolower($value->title) == strtolower($city)) {
				return $value;
			}
			
		}
	}
}