<?php

/**
 * Ez a controller felelős a hírek és a statikus oldalak kezeléséért.
 */
class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	/**
	 * Megjeleníti a megadott hírt.
	 * @param int $id A hír azonosítója
	 */
	public function actionShowNews($id) {
		$model = News::model()->findByPk((int)$id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
		
		$this->render('show', array(
			'model' => $model,
		));
	}

	/**
	 * Kilistázza a híreket.
	 */
	public function actionIndex()
	{	
		$this->layout = "full-header";
	
		$pager = new CPagination(News::model()->count('1'));
		$pager->pageSize = 5;
		
		$criteria = new CDbCriteria();
		$pager->applyLimit($criteria);
		$criteria->order = 'date_updated DESC';
		
		$model = News::model()->findAll($criteria);

		$this->render('index', array(
			'model' => $model,
			'pager' => $pager
		));
	}
	
	/**
	 * Elmenti az új hírt.
	 */
	public function actionAddNews() {
		if (!Yii::app()->user->getId() || Yii::app()->user->level < 1) {
			throw new CHttpException(
				403, 
				'A funkció használatához be kell jelentkeznie és legalább 1-es szintű hozzáférésre van szüksége'
			);
		}
		
		$model = new News();
		
		$model->user_id = Yii::app()->user->getId();
		$model->subject_id = $_POST["subject_id"];
		$model->title = $_POST["title"];
		$model->contents = $_POST["contents"];
		
		$model->date_created = new CDbExpression("NOW()");
		$model->date_updated = new CDbExpression("NOW()");
		
		$model->save();
		
		$this->redirect(Yii::app()->createUrl("site/index"));
	}
	
	/**
	 * Szerkeszti a megadott azonosítójú hírt.
	 * @param int $id A hír azonosítója.
	 */
	public function actionEditNews($id) {
		$id = (int)$id;
		if (!Yii::app()->user->getId() || Yii::app()->user->level < 1) {
			throw new CHttpException(
				403, 
				'A funkció használatához be kell jelentkeznie és legalább 1-es szintű hozzáférésre van szüksége'
			);
		}
		
		if (isset($_POST["saved"])) {
			$model = News::model()->findByPk($id);
			
			$model->title = $_POST["title"];
			$model->subject_id = $_POST["subject_id"];
			$model->contents = $_POST["contents"];
			$model->date_updated = new CDbExpression("NOW()");
			
			$model->save();
			
			$this->redirect(Yii::app()->createUrl("site/index"));
		}
	
		$model = News::model()->findByPk($id);
		$subjects = Subject::model()->findAll();
		
		$this->render("edit_news", array(
			'data' => $model,
			'subjects' => $subjects
		));
	}
	
	/**
	 * Törli a megadott hírt. A törléshez legalább 1-es szintű hozzáférés szükséges.
	 * @param int $id A hír azonosítója
	 */
	public function actionDeleteNews($id) {
		if (!Yii::app()->user->getId() || Yii::app()->user->level < 1) {
			throw new CHttpException(
				403, 
				'A funkció használatához be kell jelentkeznie és legalább 1-es szintű hozzáférésre van szüksége'
			);
		}
		
		News::model()->deleteByPk((int)$id);
		$this->redirect(Yii::app()->createUrl("site/index"));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}