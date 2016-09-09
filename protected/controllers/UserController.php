<?php

/**
 * A felhasználók kezeléséért felelős controller.
 */
class UserController extends Controller {

	/**
	 * Bejelentkezteti a felhasználót.
	 */
	public function actionLogin() {
	
		if (!isset($_POST['User'])) {
			$this->render('login', array(
				'model' => User::model(),
			));
		}
		else {
			$user = new UserIdentity($_POST["User"]["username"], $_POST["User"]["password"]);
			
			if ($user->authenticate()) {
				Yii::app()->user->login($user);
				$this->redirect(Yii::app()->createUrl("site/index"));
			}
			else {
				$this->render('login', array(
					'model' => User::model(),
					'error' => $user->errorMessage,
				));
			}
		}
	}
	
	/**
	 * Regisztrál egy új felhasználót.
	 */
	public function actionRegister() {
		$model = new User('insert');
		
		if (!isset($_POST['User'])) {
			$this->render('register', array (
				'model' => $model,
			));
		}
		else {
			$model->attributes = $_POST['User'];
			$model->disabled = 0;
			$model->date_created = new CDbExpression('NOW()');
			$model->date_updated = new CDbExpression('NOW()');
			
			if (!$model->save()) {
				$this->render('register', array (
					'model' => $model,
				));
			}
			else {
				$this->render('reg_success', array());
			}
		}
	}
	
	/**
	 * Kijelentkezteti a felhasználót.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->createUrl("site/index"));
	}
	
	/**
	 * Kilistázza az összes regisztrált felhasználót. Ez a funkció 2-es hozzáférési szinttel vehető igénybe.
	 */
	public function actionList() {
		if (!Yii::app()->user->getId() || Yii::app()->user->level != 2) {
			throw new CHttpException(403, 'Ehhez a funkcióhoz csak a webhely tulajdonosa férhet hozzá');
		}
		
		$pager = new CPagination(User::model()->count('1'));
		$pager->pageSize = 50;
		
		$criteria = new CDbCriteria();
		$pager->applyLimit($criteria);
		$criteria->order = 'date_created DESC';
		
		$model = User::model()->findAll($criteria);
		
		$this->render("list", array(
			'data' => $model,
			'pager' => $pager
		));
	}
	
	/**
	 * Beállítja a megadott felhasználó hozzáférési szintjét. Ez a funkció 2-es hozzáférési szinttel vehető igénybe.
	 * @param int $id A felhasználó azonosítója
	 */
	public function actionSetLevel($id) {
		if (!Yii::app()->user->getId() || Yii::app()->user->level != 2) {
			throw new CHttpException(403, 'Ehhez a funkcióhoz csak a webhely tulajdonosa férhet hozzá');
		}
		
		$model = User::model()->findByPk((int)$id);
		$model->scenario = 'update';
		
		//TODO: Vizsgálni kellene, hogy a szint 0, 1 vagy 2 értékű. Minden mást elutasítani.
		$model->level = $_POST["level"];
		$model->save();
		
		$this->redirect(Yii::app()->createUrl("user/list"));
	}
	
	/**
	 * Kilistázza a megadott felhasználó teljesített tantárgyait. Ez a funkció 2-es hozzáférési szinttel vehető igénybe.
	 * @param int $id A felhasználó azonosítója
	 */
	public function actionCompletedSubjects($id) {
		$id = (int)$id;
	
		if (!Yii::app()->user->getId() || Yii::app()->user->level != 2) {
			throw new CHttpException(403, 'Ehhez a funkcióhoz csak a webhely tulajdonosa férhet hozzá');
		}
		
		$model = User::model()->with('CompletedSubjects', 'CompletedCredits')->findByPk($id);
		
		if ($model == null) {
			throw new CHttpException(404, 'Úgy tűnik, hogy ez a felhasználói fiók nem létezik.');
		}
		
		$this->render('completedsubjects', array(
			"subjects" => $model->CompletedSubjects,
			"creditsCompleted" => $model->CompletedCredits,
			"user" => $model
		));
	}
	
	public function actionProfile($id) {
		$id = (int)$id;
		
		if (Yii::app()->user->getId() != $id) {
			throw new CHttpException(403, 'Ennek megtekintéséhez nincs jogosultságod!');
		}
		
		$model = User::model()->with('CompletedSubjectCount', 'CompletedCredits')->findByPk($id);
		
		if ($model == null) {
			throw new CHttpException(404, 'Úgy tűnik, hogy ez a felhasználói fiók nem létezik.');
		}
		
		$this->render('profile', array(
			"model" => $model
		));
	}
	
	/**
	 * Az éppen bejelentkezett felhasználó számára tárolja, hogy teljesítette a megadott tantárgyat.
	 * @param int $id A tantárgy azonosítója
	 */
	public function actionAddSubject($id) {
		if (!Yii::app()->user->getId()) {
			throw new CHttpException(403, "Ennek a funkciónak a használatához be kell jelentkeznie");
		}
		
		//TODO: Ellenőrizni kellene, hogy az adott tantárgy egyáltalán létezik-e.
		if (CompletedSubjects::AddSubjectRecursive($id, Yii::app()->user->getId())) {
			$model = User::model()->with('CompletedCredits')->findByPk(Yii::app()->user->getId());
			Yii::app()->user->setState('CompletedCredits', $model->CompletedCredits);
			
			print "ok";
		}
		else {
			print "fail";
		}
	}
	
	/**
	 * Az éppen bejelentkezett felhasználó teljesített tárgyai közül törli a megadott tantárgyat.
	 * @param int $id A tantárgy azonosítója
	 */
	public function actionRemoveSubject($id) {
		if (!Yii::app()->user->getId()) {
			throw new CHttpException(403, "Ennek a funkciónak a használatához be kell jelentkeznie");
		}
	
		if (CompletedSubjects::RemoveSubjectRecursive($id, Yii::app()->user->getId())) {
			$model = User::model()->with('CompletedCredits')->findByPk(Yii::app()->user->getId());
			Yii::app()->user->setState('CompletedCredits', $model->CompletedCredits);
			
			print "ok";
		}
		else {
			print "fail";
		}
	}
	
	/**
	 * ??? Ez a neve alapján valami hibakezelő lehet... Mit keres ez itt?
	 */
	public function actionError() {
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	/**
	 * Az éppen bejelentkezett felhasználó számára tárolja, hogy egy alkalmat hiányzott a megadott tantárgyból.
	 * @param int $subject_id A tantárgy azonosítója
	 */
	public function actionIncrementAbsenteeism($subject_id) {
		//Be van jelentkezve a felhasználó?
		if (!Yii::app()->user->getId()) {
			throw new CHttpException(403, "Ennek a funkciónak a használatához be kell jelentkeznie");
		}
	
		//Csak ellenőrzésként, hogy ez a tárgy tényleg létezik-e
		$model = Subject::model()->findByPk((int)$subject_id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
			
		$Absenteeism = UserAbsenteeism::model()->findByAttributes(array(
			'user_id' => Yii::app()->user->getId(),
			'subject_id' => $subject_id
		));
		
		if ($Absenteeism == null) {
			$Absenteeism = new UserAbsenteeism();
			$Absenteeism->user_id = Yii::app()->user->getId();
			$Absenteeism->subject_id = $subject_id;
			$Absenteeism->count = 0;
		}
		
		$Absenteeism->count++;
		
		if ($Absenteeism->save())
			print $Absenteeism->count;
		else
			print 'fail';
	}
	
	/**
	 * Az éppen bejelentkezett felhasználó számára a megadott tantárgyakból a hiányzásokat lenullázza.
	 * @param int $subject_id A tantárgy azonosítója
	 */
	public function actionResetAbsenteeism($subject_id) {
		//Be van jelentkezve a felhasználó?
		if (!Yii::app()->user->getId()) {
			throw new CHttpException(403, "Ennek a funkciónak a használatához be kell jelentkeznie");
		}
	
		//Csak ellenőrzésként, hogy ez a tárgy tényleg létezik-e
		$model = Subject::model()->findByPk((int)$subject_id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
			
		$Absenteeism = UserAbsenteeism::model()->findByAttributes(array(
			'user_id' => Yii::app()->user->getId(),
			'subject_id' => $subject_id
		));
		
		if ($Absenteeism != null)
			if (!$Absenteeism->delete())
				print 'fail';
		
		print 'ok';
	}
	
	/**
	 * Néhány egyéb action. Például captcha a regisztrációhoz.
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xF7F7F7,
			),
		);
	}
}
?>