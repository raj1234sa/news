<?php

include_once DIR_WS_MODEL_CLASSES.'RDataModel.php';

class CountryData extends RDataModel
{		
    protected function PropertyMap() 
    {
 		$PropMap = array();

		$PropMap['country_id'] = array('Field', 'country_id', 'country_id', 'int');
		$PropMap['country_name'] = array('Field', 'country_name', 'country_name', 'string');
		$PropMap['status'] = array('Field', 'status', 'status', 'string');

		return $PropMap;
	}
}