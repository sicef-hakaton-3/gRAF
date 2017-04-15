<?php
namespace App\Services;

/**
*
*/

use App\Util\simple_html_dom;

use App\Services\AbstractService;
class HotelService extends AbstractService
{

	public function getHotels($CityName){
		$data = $this->getRemoteData(
            "http://www.booking.com/searchresults.en-gb.html?ss=".str_replace(" ","%20",$CityName)
        );
		$hotels = [];
        $i = strpos($data,'id="hotellist_inner"',0);
        while ($i){
        		$link = strpos($data,'class="sr_item_photo', $i+10);
        		$link = strpos($data,'href="', $link);
        		$linkEnd = strpos($data,'"', $link+10);
        		$hotelLink = substr($data,$link+6,$linkEnd-$link);
        		$imgpos = strpos($data,'src="', $linkEnd+6);
        		$imgend = strpos($data,'"', $imgpos+6);
        		$imageLink = substr($data,$imgpos+5,$imgend-$imgpos-5);
        		$props = strpos($data,'class="sr_property_block_main_row',$imgend);
        		$props = strpos($data,'class="sr-hotel__name',$props);
        		$props = strpos($data, '>', $props);
        		$nameEnd = strpos($data, '<', $props);
        		$name = substr($data, $props+2, $nameEnd-$props-3);
        		$props = strpos($data, 'class="address', $nameEnd);
        		$props = strpos($data, '-coords="',$props);
        		$coordsEnd = strpos($data, '"', $props+20);
        		$coords = substr($data, $props+9, $coordsEnd-$props-9);
        		$props = strpos($data, '>', $props+10);
        		$addressEnd = strpos($data, '<', $props+1);
        		$address = substr($data, $props+2, $addressEnd-$props-2);
        		$props = strpos($data, 'class="hotel_desc', $props+1);
        		$props = strpos($data, '>', $props+3);
        		$descEnd = strpos($data, '<', $props+10);
        		$desc = substr($data, $props+2, $descEnd-$props-4);
        		$hotels[] = [
        			'name' => $name,
        			'link' => $hotelLink,
        			'image' => $imageLink,
        			'cords' => $coords,
        			'address' => $address,
        			'description' => $desc
        		];
        		//var_dump($desc);
       		if ($i){
        			$i = strpos($data,'class="sr_item ',$descEnd+10);
        		}

        }


		return  $hotels;
	}
}
