<?php
include_once DIR_WS_MODEL.'IndustryData.php';

include_once DIR_WS_MODEL_CLASSES.'RMasterModel.php';

class IndustryMaster extends RMasterModel {
	public $fieldArr = array(
		'industry.industry_id',
		'industry.industry_name',
		'industry.sort_order',
		'industry.status',
		'industry.created_date',
		'industry.updated_date',
	);

	public function addIndustry($IndustryData) {
		$FinalData = $IndustryData->InternalSync(RDataModel::INSERT, "industry_name","sort_order","status");
		$this->setInsert("industry",$FinalData['query'], $FinalData['params']);
		
		return $this->exec_query();
	}

	public function editIndustry($IndustryData) {
		$UpdateData = $IndustryData->InternalSync(RDataModel::UPDATE, "industry_name","sort_order","status");
		$this->setUpdate("industry",$UpdateData['query'], $UpdateData['params']);
		$this->setWhere("AND industry_id = :industry_id", $IndustryData->industry_id, 'int');
		
		return $this->exec_query();
	}

	public function deleteIndustry($industry_id) {
		if(isset($industry_id) && ($industry_id!=null)) {
   			$this->setDelete("industry");
   			$this->setWhere("industry_id = :industry_id", $industry_id, 'int');

   			return $this->exec_query();
  		}
	}

	public function getIndustry($id = null) {
		if(!empty($id)) {
			$this->setWhere("AND industry_id = :industry_id", $id, 'int');
		}
		$this->setFrom("industry");
		return $this->exec_query();
	}
}