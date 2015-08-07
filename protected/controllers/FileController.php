<?php

class FileController extends Controller
{
	public function actionList($id)
	{
		$id = (int)$id;
	
		$model = Subject::model()->findByPk($id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
		
		$this->render('list', array(
			'data' => $model,
		));
	}
	
	public function actionDetails($id) {
		$id = (int)$id;
		$model = File::model()->findByPk($id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
		
		$this->render('details', array(
			'data' => $model,
		));
	}
	
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