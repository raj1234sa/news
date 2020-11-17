<?php

include_once DIR_WS_MODEL_CLASSES.'RDataModel.php';

class IndustryData extends RDataModel
{		
    protected function PropertyMap() 
    {
 		$PropMap = array();

		$PropMap['industry_id'] = array('Field', 'industry_id', 'industry_id', 'int');
		$PropMap['industry_name'] = array('Field', 'industry_name', 'industry_name', 'string');
		$PropMap['sort_order'] = array('Field', 'sort_order', 'sort_order', 'int');
		$PropMap['status'] = array('Field', 'status', 'status', 'string');
		$PropMap['created_date'] = array('Field', 'created_date', 'created_date', 'string');
		$PropMap['updated_date'] = array('Field', 'updated_date', 'updated_date', 'string');

		return $PropMap;
	}
}