<?php

class EventController extends Controller
{
	public function actionIndex() {
		$model = Events::model()->with('subject')->findAll(
			array(
				'condition' => 'time >= NOW()',
				'order' => 'time',
			)
		);
		
		$this->render('index', array(
			'model' => $model,
		));
	}
	
	public function actionList($id)
	{
		$model = Subject::model()->findByPk($id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
	
		$this->render('list', array(
			'model' => $model,
			'events' => $model->events,
		));
	}
	
	public function actionDelete($id) {
		if (Yii::app()->user->getId() == null) {
			throw new CHttpException(403, "Ezt a funkciót csak regisztrált felhasználók használhatják");
		}
		
		$subject_id = Events::model()->findByPk($id)->subject_id;
		Events::model()->deleteByPk($id);
		
		$this->redirect(Yii::app()->createUrl("event/list", array("id" => $subject_id)));
	}
	
	public function actionCreate($id) {
		if (Yii::app()->user->getId() == null) {
			throw new CHttpException(403, "Ezt a funkciót csak regisztrált felhasználók használhatják");
		}
		
		$model = new Events('insert');
		
		$model->time = $_POST["time"];
		$model->type = $_POST["type"];
		$model->notes = $_POST["notes"];
		$model->subject_id = $id;
		
		$model->save();
		
		$this->redirect(Yii::app()->createUrl("event/list", array("id" => $id)));
	}
	
	public function actionEdit($id) {
		if (Yii::app()->user->getId() == null) {
			throw new CHttpException(403, "Ezt a funkciót csak regisztrált felhasználók használhatják");
		}
		
		$EventModel = Events::model()->findByPk($id);
		if ($EventModel == null)
			throw new CHttpException(404, "A kért elem nem található");
		
		if (isset($_POST["saved"])) {
			$EventModel->scenario = 'update';
			
			$EventModel->time = $_POST["time"];
			$EventModel->type = $_POST["type"];
			$EventModel->notes = $_POST["notes"];
			
			$EventModel->save();
			
			$this->redirect(Yii::app()->createUrl("event/list", array("id" => $EventModel->subject_id)));
		}
		
		$SubjectModel = Subject::model()->findByPk($EventModel->subject_id);
		if ($SubjectModel == null)
			throw new CHttpException(404, "A kért elem nem található");
		
		$this->render('edit', array(
			'EventModel' => $EventModel,
			'SubjectModel' => $SubjectModel,
		));
	}
	
	public function actionDetails($id) {
		$EventModel = Events::model()->findByPk($id);
		$SubjectModel = Subject::model()->findByPk($EventModel->subject_id);
		if ($EventModel == null || $SubjectModel == null)
			throw new CHttpException(404, "A kért elem nem található");
		
		$this->render('details', array(
			'EventModel' => $EventModel,
			'SubjectModel' => $SubjectModel,
		));
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