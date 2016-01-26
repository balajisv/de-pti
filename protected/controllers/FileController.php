<?php

/**
 * Az egyes tantárgyakhoz tartozó fájlok kezeléséért felelős controller.
 */
class FileController extends Controller
{
	/**
	 * Visszaadja a megadott tantárgyhoz tartozó fájlok listáját és azok adatait
	 * JSON formátumban.
	 * @param int $id A tantárgy azonosítója
	 */
	public function actionGetFilesJson($id) {
		$model = Subject::model()->with("files")->findByPk((int)$id);
		if ($model == null) {
			header("Content-Type: text/plain;charset=UTF-8");
			print "ERROR SUBJECT_NOT_FOUND";
			return;
		}
		
		header("Content-Type: application/json;charset=UTF-8");
		
		$data = array();
		foreach ($model->files as $File) {
			$data[] = array(
				"file_id" => (int)$File->file_id,
				"uploader" => $File->user->username,
				"filename" => $File->filename_real,
				"downloads" => (int)$File->downloads,
				"size" => filesize("upload/".$File->filename_local),
				"description" => $File->description,
			);
		}
		
		print json_encode($data);
	}
	
	/**
	 * Kilstázza az adott tantárgyhoz tartozó fájlokat.
	 * @param int $id A tantárgy azonosítója
	 */
	public function actionList($id)
	{
		$model = Subject::model()->findByPk((int)$id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
		
		$this->render('list', array(
			'data' => $model,
		));
	}
	
	/**
	 * Megjeleníti az adott fájl részletes adatait.
	 * @param int $id A fájl azonosítója
	 */
	public function actionDetails($id) {
		$model = File::model()->findByPk((int)$id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
		
		$this->render('details', array(
			'data' => $model,
		));
	}
	
	/**
	 * Feltölt egy fájlt a megadott tantárgyhoz.
	 * @param int $id A tantárgy azonosítója
	 */
	public function actionUpload($id) {
		if (!Yii::app()->user->getId()) {
			throw new CHttpException(403, 'A funkció használatához be kell jelentkeznie');
		}
		$id = (int)$id;
	
		$file = CUploadedFile::getInstanceByName("to_upload");
		
		if ($file == null) {
			throw new CHttpException(404, 'Nem lett fájl kiválasztva a feltöltéshez');
		}
		
		$filename = $file->getName();
		$localFileName = sha1($filename . microtime()) . "." . CFileHelper::getExtension($filename);
		
		if (in_array(strtolower(CFileHelper::getExtension($filename)), Yii::app()->params["deniedexts"])) {
			throw new CHttpException(
				403,
				ucfirst(CFileHelper::getExtension($filename)).' kiterjesztésű fájl nem tölthető fel a szerverre'
			);
		}
		
		$model = new File();
		$model->subject_id = $id;
		$model->filename_real = $filename;
		$model->filename_local = $localFileName;
		$model->description = htmlspecialchars($_POST["description"]);
		$model->user_id = Yii::app()->user->getId();
		$model->date_created = new CDbExpression('NOW()');
		$model->date_updated = new CDbExpression('NOW()');
		$model->downloads = 0;
		$model->save();
		
		if ($file->saveAs("upload/" . $localFileName)) {
			$this->redirect(Yii::App()->createUrl("file/list", array("id" => $id)));
		}
	}
	
	/**
	 * Letöltésre kényszeríti a megadott fájlt.
	 * @param int $id A fájl azonosítója
	 */
	public function actionDownload($id) {
		$id = (int)$id;
		$model = File::model()->findByPk($id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
		
		$model->downloads++;
		$model->save();
		
		$Req = new CHttpRequest();
		$Req->sendFile($model->filename_real, file_get_contents("upload/" . $model->filename_local));
	}
	
	/**
	 * Törli a megadott fájlt. A fájlt csak a fájl feltöltője vagy legalább 1-es szintű felhasználó
	 * törölhet.
	 * @param int $id A fájl azonosítója
	 */
	public function actionDelete($id) {
		$id = (int)$id;
		$model = File::model()->findByPk($id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
	
		if (!Yii::app()->user->getId() || (Yii::app()->user->level < 1 && Yii::app()->user->getId() != $model->user_id)) {
			throw new CHttpException(
				403, 
				'A funkció használatához be kell jelentkeznie és legalább 1-es szintű hozzáférésre van szüksége, vagy
				a fájl tulajdonosának Önnek kell lennie'
			);
		}
		
		$SubjectId = $model->subject_id;
		
		unlink("upload/" . $model->filename_local);
		
		File::model()->deleteByPk($id);
		
		$this->redirect(Yii::App()->createUrl("file/list", array("id" => $SubjectId)));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}