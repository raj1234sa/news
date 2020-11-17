<?php
include_once DIR_WS_MODEL.'CountryData.php';

include_once DIR_WS_MODEL_CLASSES.'RMasterModel.php';

class CountryMaster extends RMasterModel {
	public $fieldArr = array(
		'country.country_id',
		'country.country_name',
		'country.status',
	);

	public function addCountry($CountryData) {
		$FinalData = $CountryData->InternalSync(RDataModel::INSERT, "country_name","status");
		$this->setInsert("country",$FinalData['query'], $FinalData['params']);
		
		return $this->exec_query();
	}

	public function editCountry($CountryData) {
		$UpdateData = $CountryData->InternalSync(RDataModel::UPDATE, "country_name","status");
		$this->setUpdate("country",$UpdateData['query'], $UpdateData['params']);
		$this->setWhere("AND country_id = :country_id", $CountryData->country_id, 'int');
		
		return $this->exec_query();
	}

	public function deleteCountry($country_id) {
		if(isset($country_id) && ($country_id!=null)) {
   			$this->setDelete("country");
   			$this->setWhere("country_id = :country_id", $country_id, 'int');

   			return $this->exec_query();
  		}
	}

	public function getCountry($id = null) {
		if(!empty($id)) {
			$this->setWhere("AND country_id = :country_id", $id, 'int');
		}
		$this->setFrom("country");
		return $this->exec_query();
	}
}