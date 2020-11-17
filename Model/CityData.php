<?php

include_once DIR_WS_MODEL_CLASSES.'RDataModel.php';

class CityData extends RDataModel
{		
    protected function PropertyMap() 
    {
 		$PropMap = array();

		$PropMap['city_id'] = array('Field', 'city_id', 'city_id', 'int');
		$PropMap['city_name'] = array('Field', 'city_name', 'city_name', 'string');
		$PropMap['state_id'] = array('Field', 'state_id', 'state_id', 'int');
		$PropMap['country_id'] = array('Field', 'country_id', 'country_id', 'int');
		$PropMap['status'] = array('Field', 'status', 'status', 'string');

		return $PropMap;
	}
}