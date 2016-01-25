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
	 * @param string $source A hírforrás. "deik" érték esetén a http://inf.unideb.hu oldalról tölti le a híreket. Deprecated, az értéke mindig null legyen.
	 */
	public function actionIndex($source = null)
	{	
		switch ($source) {
			case "deik":
				$this->render('index_deik');
			break;
			
			default:
				//$model = News::model()->findAll(array('limit' => '5', 'order' => 'date_updated DESC',));
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
			break;
		}
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
	 * Letölti a híreket a http://www.inf.unideb.hu címről
	 * @deprecated A http://www.inf.unideb.hu webhely már nem frissül, így nem használjuk
	 */
	public function actionQuerydeik() {
		Yii::import('ext.EHttpRequest.*');
		
		$client = new EHttpClient('https://www.inf.unideb.hu/',
			array(
				'maxredirects' => 0,
				'timeout'      => 30
			)
		);
		 
		$response = $client->request();
		 
		if($response->isSuccessful())
			echo '<pre>' . htmlentities($response->getBody()) .'</pre>';
		else
			echo $response->getRawBody();
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

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Köszönjük üzenetét. Igyekszünk mihamarabb megválaszolni.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}