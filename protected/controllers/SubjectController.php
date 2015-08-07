<?php

class SubjectController extends Controller
{
	public function actionIndex($group_id = null)
	{
		$Groups = SubjectGroup::model()->with('subjects')->findAll(array('order' => 't.group_id'));
		
		$userCompleted = array();
		$completableSubjects = array();
		
		if ($UID = Yii::app()->user->getId()) {
			$user = User::model()->with('CompletedSubjects')->findByPk($UID);
			
			foreach ($user->CompletedSubjects as $Current) {
				$userCompleted[] = $Current->subject_id;
			}
			
			//$completableSubjects = $user->completableSubjects();
			
			$AllSubjects = Subject::model()->with('dependencies')->findAll();
			foreach ($AllSubjects as $Current) {
				if ($this->IsSubjectCompletable($Current, $userCompleted))
					$completableSubjects[] = $Current->subject_id;
			}
		}
		
		$this->render('index', array(
			'groups' => $Groups,
			'completedSubjects' => $userCompleted,
			'completableSubjects' => $completableSubjects,
		));
	}
	
	public function actionEditSubject($id = null) {
		if (!Yii::app()->user->getId() || Yii::app()->user->level < 1) {
			throw new CHttpException(
				403, 
				'A funkció használatához be kell jelentkeznie és legalább 1-es szintű hozzáférésre van szüksége'
			);
		}
		
		$Subject = ($id == null) ? new Subject : Subject::model()->findByPk($id);
		
		$Subject->name = $_POST["name"];
		$Subject->semester = $_POST["semester"];
		$Subject->group_id = $_POST["type"];
		$Subject->credits = $_POST["credits"];
		
		if ($Subject->save()) {
			$this->redirect(Yii::app()->createUrl('subject/details', array('id' => $Subject->subject_id)));
		}
		else {
			print "Nem sikerült a tantárgyat elmenteni";
			print_r($Subject->getErrors());
		}
	}
	
	public function actionDetails($id) {
		$model = Subject::model()->findByPk((int)$id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
		
		//Előfeltételek lekérdezése
		$dependencies = array();
		foreach ($model->dependencies as $dependency) {
			$Subj = Subject::Model()->findByPk($dependency->dependent_subject_id);
			
			$dependencies[] = array(
				"id" => $Subj->subject_id,
				"name" => $Subj->name,
				"dependency_id" => $dependency->dependency_id,
				"shortName" => $Subj->shortName,
				"semester" => $Subj->semester,
				"group" => $Subj->group->group_name
			);
		}
		
		//Rá épülő tárgyak
		$Based_on = array();
		foreach ($model->based_on as $current) {
			$Subj = Subject::Model()->findByPk($current->subject_id);
			
			$Based_on[] = array(
				"id" => $Subj->subject_id,
				"shortName" => $Subj->shortName,
				"semester" => $Subj->semester,
				"group" => $Subj->group->group_name
			);
		}
		
		//Hiányzások
		$Misses = 0;
		if (Yii::app()->user->getId()) {
			$Absenteeism = UserAbsenteeism::model()->findByAttributes(array(
				'user_id' => Yii::app()->user->getId(),
				'subject_id' => $id
			));
			
			if ($Absenteeism != null)
				$Misses = $Absenteeism->count;
		}
		
		$this->render('details', array(
			'based_on' => $Based_on,
			'data' => $model,
			'dependencies' => $dependencies,
			'Misses' => $Misses,
		));
	}
	
	public function actionDependencyTree($id) {
		$model = Subject::model()->findByPk($id);
		
		if ($model == null) {
			throw new CHttpException(404, "Nem létező tantárgy");
		}
		
		$Data = $model->GetDependencyTree();
		
		$this->render("dependencytree", array(
			"model" => $model,
			"dependencytree" => ($Data == null) ? array() : $Data
		));
	}
	
	public function actionRemoveDependency($id) {
		if (!Yii::app()->user->getId() || Yii::app()->user->level < 1) {
			throw new CHttpException(
				403, 
				'A funkció használatához be kell jelentkeznie és legalább 1-es szintű hozzáférésre van szüksége'
			);
		}
	
		$model = SubjectDependencies::model()->findByPk($id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
		$SubjectID = $model->subject_id;
	
		SubjectDependencies::model()->deleteByPk($id);
		
		$this->redirect(Yii::App()->createUrl("subject/details", array("id" => $SubjectID)));
	}
	
	public function actionEditDescription($id) {
		if (!Yii::app()->user->getId() || Yii::app()->user->level < 1) {
			throw new CHttpException(
				403, 
				'A funkció használatához be kell jelentkeznie és legalább 1-es szintű hozzáférésre van szüksége'
			);
		}
		
		$model = Subject::model()->findByPk($id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
		
		$model->description = htmlspecialchars($_POST["description"]);
		
		if ($model->save()) {
			$this->redirect(Yii::App()->createUrl("subject/details", array("id" => $id)));
		}
		else {
			print "Nem sikerült elmenteni az adatokat";
			print_r($model->getErrors());
		}
	}
	
	public function actionAddDependency($id) {
		$model = new SubjectDependencies();
		
		$model->subject_id = $id;
		$model->dependent_subject_id = $_POST["dependency_id"];
		
		$model->save();
		
		$this->redirect(Yii::App()->createUrl("subject/details", array("id" => $id)));
	}
	
	public function IsSubjectCompletable($SubjectModel, $UserCompletedSubjects) {
		/*
			Egy tantárgy felvehető, ha:
				- A tárgyat a felhasználó még nem teljesítette
				- A tantárgynak nincs előfeltétele
				- A tantárgy összes előkövetelményét teljesítette a felhasználó
		*/
		
		//A tárgyat a felhasználó még nem teljesítette:
		if (in_array($SubjectModel->subject_id, $UserCompletedSubjects))
			return false;
		
		//A tárgynak nincs előfeltétele:
		if (count($SubjectModel->dependencies) == 0)
			return true;
			
		//A tantárgy összes előkövetelményét teljesítette a felhasználó
		foreach ($SubjectModel->dependencies as $CurrentDependency) {
			if (!in_array($CurrentDependency->dependent_subject_id, $UserCompletedSubjects)) {
				return false;
			}
		}
			
		return true;
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