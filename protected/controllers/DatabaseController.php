<?php

class DatabaseController extends Controller {
	private $tables = array(
		"pti_events",
		"pti_file",
		"pti_news",
		"pti_subject",
		"pti_subject_dependencies",
		"pti_subject_groups",
		"pti_user",
		"pti_user_absenteeism",
		"pti_user_subjects"
	);
	
	public function actionExport() {
		if (!Yii::app()->user->getId() || Yii::app()->user->level != 2) {
			throw new CHttpException(
				403, 
				'A funkció használatához be kell jelentkeznie és legalább tulajdonos szintű hozzáférésre van szüksége'
			);
		}
		
		Yii::app()->request->sendFile(
			"de-pti-backup-".date("Y-m-d-H-i-s").".json",
			json_encode($this->backup())
		);
	}
	
	private function backup() {
		$result = array(
			"exportDate" => date("Y. m. d. H:i:s")
		);
		foreach ($this->tables as $table) {
			$createQuery = Yii::app()->db->createCommand("SHOW CREATE TABLE `$table`")->query()->read();
			
			$result["tableExport"][] = array(
				"tableName"   => $table,
				"createQuery" => $createQuery["Create Table"],
				"records"     => Yii::app()->db->createCommand("SELECT * FROM `$table`")->query()->readAll()
			);
		}
		
		return $result;
	}
}