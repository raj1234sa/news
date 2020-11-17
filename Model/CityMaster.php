<?php
include_once DIR_WS_MODEL.'CityData.php';

include_once DIR_WS_MODEL_CLASSES.'RMasterModel.php';

class CityMaster extends RMasterModel {
	public $fieldArr = array(
		'city.city_id',
		'city.city_name',
		'city.state_id',
		'city.country_id',
		'city.status',
	);

	public function addCity($CityData) {
		$FinalData = $CityData->InternalSync(RDataModel::INSERT, "city_name","state_id","country_id","status");
		$this->setInsert("city",$FinalData['query'], $FinalData['params']);
		
		return $this->exec_query();
	}

	public function editCity($CityData) {
		$UpdateData = $CityData->InternalSync(RDataModel::UPDATE, "city_name","state_id","country_id","status");
		$this->setUpdate("city",$UpdateData['query'], $UpdateData['params']);
		$this->setWhere("AND city_id = :city_id", $CityData->city_id, 'int');
		
		return $this->exec_query();
	}

	public function deleteCity($city_id) {
		if(isset($city_id) && ($city_id!=null)) {
   			$this->setDelete("city");
   			$this->setWhere("city_id = :city_id", $city_id, 'int');

   			return $this->exec_query();
  		}
	}

	public function getCity($id = null) {
		if(!empty($id)) {
			$this->setWhere("AND city_id = :city_id", $id, 'int');
		}
		$this->setFrom("city");
		return $this->exec_query();
	}
}