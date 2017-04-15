<?php

namespace App\Services;

use App\Services\AbstractService;

/**
* 
*/
class PhotoService extends AbstractService
{
	
	public function getPhotos($name){

		$data = $this->getRemoteData("https://maps.googleapis.com/maps/api/place/photo?photoreference=CnRtAAAATLZNl354RwP_9UKbQ_5Psy40texXePv4oAlgP4qNEkdIrkyse7rPXYGd9D_Uj1rVsQdWT4oRz4QrYAJNpFX7rzqqMlZw2h2E2y5IKMUZ7ouD_SlcHxYq1yL4KbKUv3qtWgTK0A6QbGh87GB3sscrHRIQiG2RrmU_jF4tENr9wGS_YxoUSSDrYjWmrNfeEHSGSc3FyhNLlBU&key=AIzaSyBJKnjIc--mIWFGHgXT8MDTe3GrLKgu4eU");

		echo $data;
		
	}
}