<?php
include_once DIR_WS_MODEL.'AdminData.php';

include_once DIR_WS_MODEL_CLASSES.'RMasterModel.php';

class AdminMaster extends RMasterModel {
	public function addAdmin($AdminData) {
		$FinalData = $AdminData->InternalSync(RDataModel::INSERT, "admin_username","admin_password");
		$this->setInsert("admin",$FinalData['query'], $FinalData['params']);
		
		return $this->exec_query();
	}

	public function editAdmin($AdminData) {
		$UpdateData = $AdminData->InternalSync(RDataModel::UPDATE, "admin_username","admin_password");
		$this->setUpdate("admin",$UpdateData['query'], $UpdateData['params']);
		$this->setWhere("AND admin_id = :admin_id", $AdminData->admin_id, 'int');
		
		return $this->exec_query();
	}

	public function deleteAdmin($admin_id) {
		if(isset($admin_id) && ($admin_id!=null)) {
   			$this->setDelete("admin");
   			$this->setWhere("admin_id = :admin_id", $admin_id, 'int');

   			return $this->exec_query();
  		}
	}

	public function getAdmin() {
		$this->setFrom("admin");
		return $this->exec_query();
	}

	public function getLoginAdmin() {
		$this->setWhere("AND admin_id = :admin_id", $_SESSION['admin_login'], 'int');
		return $this->getAdmin()[0];
	}
}