<?php

include_once DIR_WS_MODEL_CLASSES.'RDataModel.php';

class NewsData extends RDataModel
{		
    protected function PropertyMap() 
    {
 		$PropMap = array();

		$PropMap['news_id'] = array('Field', 'news_id', 'news_id', 'int');
		$PropMap['news_title'] = array('Field', 'news_title', 'news_title', 'string');
		$PropMap['industry_id'] = array('Field', 'industry_id', 'industry_id', 'int');
		$PropMap['short_desc'] = array('Field', 'short_desc', 'short_desc', 'string');
		$PropMap['long_desc'] = array('Field', 'long_desc', 'long_desc', 'string');
		$PropMap['small_image'] = array('Field', 'small_image', 'small_image', 'string');
		$PropMap['large_image'] = array('Field', 'large_image', 'large_image', 'string');
		$PropMap['city_id'] = array('Field', 'city_id', 'city_id', 'int');
		$PropMap['state_id'] = array('Field', 'state_id', 'state_id', 'int');
		$PropMap['city_id'] = array('Field', 'city_id', 'city_id', 'int');
		$PropMap['country_id'] = array('Field', 'country_id', 'country_id', 'int');
		$PropMap['news_date'] = array('Field', 'news_date', 'news_date', 'string');
		$PropMap['created_date'] = array('Field', 'created_date', 'created_date', 'string');
		$PropMap['updated_date'] = array('Field', 'updated_date', 'updated_date', 'string');
		$PropMap['status'] = array('Field', 'status', 'status', 'string');

		return $PropMap;
	}
}