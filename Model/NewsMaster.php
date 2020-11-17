<?php
include_once DIR_WS_MODEL.'NewsData.php';

include_once DIR_WS_MODEL_CLASSES.'RMasterModel.php';

class NewsMaster extends RMasterModel {
	public $fieldArr = array(
		'news_master.news_id',
		'news_master.news_title',
		'news_master.industry_id',
		'news_master.country_id',
		'news_master.status',
	);

	public function addNews($NewsData) {
		$FinalData = $NewsData->InternalSync(RDataModel::INSERT, "news_title","industry_id","short_desc","long_desc","small_image","large_image","city_id","state_id","country_id","news_date","status");
		$this->setInsert("news_master",$FinalData['query'], $FinalData['params']);
		
		return $this->exec_query();
	}

	public function editNews($NewsData) {
		$UpdateData = $NewsData->InternalSync(RDataModel::UPDATE, "news_title","industry_id","short_desc","long_desc","small_image","large_image","city_id","state_id","country_id","news_date","status");
		$this->setUpdate("news_master",$UpdateData['query'], $UpdateData['params']);
		$this->setWhere("AND news_id = :news_id", $NewsData->news_id, 'int');
		
		return $this->exec_query();
	}

	public function deleteNews($news_id) {
		if(isset($news_id) && ($news_id!=null)) {
   			$this->setDelete("news_master");
   			$this->setWhere("news_id = :news_id", $news_id, 'int');

   			return $this->exec_query();
  		}
	}

	public function getNews($id = null) {
		if(!empty($id)) {
			$this->setWhere("AND news_id = :news_id", $id, 'int');
		}
		$this->setFrom("news_master");
		return $this->exec_query();
	}
}