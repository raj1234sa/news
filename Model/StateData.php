<?php

include_once DIR_WS_MODEL_CLASSES.'RDataModel.php';

class StateData extends RDataModel
{		
    protected function PropertyMap() 
    {
 		$PropMap = array();

		$PropMap['state_id'] = array('Field', 'state_id', 'state_id', 'int');
		$PropMap['state_name'] = array('Field', 'state_name', 'state_name', 'string');
		$PropMap['country_id'] = array('Field', 'country_id', 'country_id', 'int');
		$PropMap['status'] = array('Field', 'status', 'status', 'string');

		return $PropMap;
	}
}