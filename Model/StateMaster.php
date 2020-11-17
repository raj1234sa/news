<?php
include_once DIR_WS_MODEL.'StateData.php';

include_once DIR_WS_MODEL_CLASSES.'RMasterModel.php';

class StateMaster extends RMasterModel {
	public $fieldArr = array(
		'state.state_id',
		'state.state_name',
		'state.country_id',
		'state.status',
	);

	public function addState($StateData) {
		$FinalData = $StateData->InternalSync(RDataModel::INSERT, "state_name","country_id","status");
		$this->setInsert("state",$FinalData['query'], $FinalData['params']);
		
		return $this->exec_query();
	}

	public function editState($StateData) {
		$UpdateData = $StateData->InternalSync(RDataModel::UPDATE, "state_name","country_id","status");
		$this->setUpdate("state",$UpdateData['query'], $UpdateData['params']);
		$this->setWhere("AND state_id = :state_id", $StateData->state_id, 'int');
		
		return $this->exec_query();
	}

	public function deleteState($state_id) {
		if(isset($state_id) && ($state_id!=null)) {
   			$this->setDelete("state");
   			$this->setWhere("state_id = :state_id", $state_id, 'int');

   			return $this->exec_query();
  		}
	}

	public function getState($id = null) {
		if(!empty($id)) {
			$this->setWhere("AND state_id = :state_id", $id, 'int');
		}
		$this->setFrom("state");
		return $this->exec_query();
	}
}