<?php

/**
 * A tantárgyak kezeléséért felelős controller.
 */
class SubjectController extends Controller
{
	/**
	 * Visszaadja az összes tantárgycsoportot és tantárgyat az előfeltételeivel együtt egy
	 * JSON dokumentumban.
	 */
	public function actionGetSubjectsJson() {
		header("Content-Type: application/json;charset=UTF-8");
		
		$data = array(
			"groups" => array(),
			"subjects" => array()
		);
		
		$Groups = SubjectGroup::model()->with('subjects')->findAll(array('order' => 't.group_id'));
		if ($Groups != null) {
			foreach ($Groups as $Group) {
				$data["groups"][] = array(
					"group_id" => (int)$Group->group_id,
					"name" => $Group->group_name
				);
				
				foreach ($Group->subjects as $Subject) {
					$dependencies = array();
					foreach ($Subject->dependencies as $Dependency) {
						$dependencies[] = (int)$Dependency->dependent_subject_id;
					}
					
					$data["subjects"][] = array(
						"subject_id" => (int)$Subject->subject_id,
						"group_id" => (int)$Group->group_id,
						"semester" => $Subject->semester == null ? null : (int)$Subject->semester,
						"name" => $Subject->name,
						"dependencies" => $dependencies
					);
				}
			}
		}
		
		print json_encode($data);
	}
	
	/**
	 * Kilistázza tárgycsoportoknént az összes tantárgyat. Bejelentkezett
	 * felhasználó esetén figyelembe veszi azt is, hogy mely tantárgyak
	 * vannak teljesítve, mit vehet és mit nem vehet fel.
	 * 
	 * @param int $group_id A tárgycsoport azonosítója. Deprecated, az értéke maradjon null.
	 */
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
	
	/**
	 * Létrehozza vagy szerkeszti a megadott tantárgy adatait.
	 * @param int $id A tantárgy azonosítója. Null esetén új tárgyat ír ki, egyébként meglévő tárgyat szerkeszt
	 */
	public function actionEditSubject($id = null) {
		if (!Yii::app()->user->getId() || Yii::app()->user->level < 1) {
			throw new CHttpException(
				403, 
				'A funkció használatához be kell jelentkeznie és legalább 1-es szintű hozzáférésre van szüksége'
			);
		}
		
		$Subject = ($id == null) ? new Subject : Subject::model()->findByPk((int)$id);
		
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
	
	/**
	 * Megjeleníti a tantárgy adatlapját. Bejelentkezett hallgató esetén a hiányzásokat is lekérdezi.
	 * @param int $id A tantárgy azonosítója
	 */
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
	
	/**
	 * Megjeleníti a tantárgy előfeltételeit tartalmazó tárgyfát.
	 * @param int $id A tantárgy azonosítója
	 */
	public function actionDependencyTree($id) {
		$model = Subject::model()->findByPk((int)$id);
		
		if ($model == null) {
			throw new CHttpException(404, "Nem létező tantárgy");
		}
		
		$Data = $model->GetDependencyTree();
		
		$this->render("dependencytree", array(
			"model" => $model,
			"dependencytree" => ($Data == null) ? array() : $Data
		));
	}
	
	/**
	 * Eltávolítja a megadott előkövetelményt.
	 * @param int $id Az előkövetelmény azonosítója
	 */
	public function actionRemoveDependency($id) {
		if (!Yii::app()->user->getId() || Yii::app()->user->level < 1) {
			throw new CHttpException(
				403, 
				'A funkció használatához be kell jelentkeznie és legalább 1-es szintű hozzáférésre van szüksége'
			);
		}
	
		$model = SubjectDependencies::model()->findByPk((int)$id);
		if ($model == null)
			throw new CHttpException(404, "A kért elem nem található");
		$SubjectID = $model->subject_id;
	
		SubjectDependencies::model()->deleteByPk($id);
		
		$this->redirect(Yii::App()->createUrl("subject/details", array("id" => $SubjectID)));
	}
	
	/**
	 * Módosítja a megadott tantárgy leírását.
	 * @param int $id A tantárgy azonosítója
	 */
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
	
	/**
	 * Új előfeltételt vesz fel a megadott tantárgyhoz.
	 * @param int $id A tantárgy azonosítója
	 */
	public function actionAddDependency($id) {
		$model = new SubjectDependencies();
		
		//TODO: Ellenőrizni kellene, hogy egyáltalán léteznek-e ezek a tantárgyak
		$model->subject_id = (int)$id;
		$model->dependent_subject_id = $_POST["dependency_id"];
		
		$model->save();
		
		$this->redirect(Yii::App()->createUrl("subject/details", array("id" => $id)));
	}
	
	/**
	 * Megadja, hogy a hallgató felveheti-e az adott tárgyat.
	 * @param CActiveRecord $SubjectModel A felvenni kívánt tantárgy adatait tároló model objektum
	 * @param array(int) $UserCompletedSubjects A felhasználó által teljesített tantárgyak azonosítói
	 * @return boolean true, ha felvehető a tantárgy, false ha nem
	 */
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