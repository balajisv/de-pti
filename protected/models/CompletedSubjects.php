<?php

/**
 * This is the model class for table "pti_user_subjects".
 *
 * The followings are the available columns in table 'pti_user_subjects':
 * @property integer $user_id
 * @property integer $subject_id
 */
class CompletedSubjects extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompletedSubjects the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pti_user_subjects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, subject_id', 'required'),
			array('user_id, subject_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, subject_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'subject_id' => 'Subject',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('subject_id',$this->subject_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function AddSubjectRecursive($id, $user_id) {
		//Ha ez a tárgy már teljesítve van, nem csinálunk semmit
		$Check = self::model()->findByAttributes(
			array(
				'user_id' => $user_id,
				'subject_id' => $id
			)
		);
		
		if ($Check != null)
			return true;
		
		//Elmentjük ezt a tantárgyat teljesítettként
		$Subject = Subject::model()->findByPk($id);
		$CompletedSubject = new CompletedSubjects();
		$CompletedSubject->user_id = $user_id;
		$CompletedSubject->subject_id = $Subject->subject_id;
		$CompletedSubject->save();
		
		//Majd a tantárgy összes előfeltételét
		foreach ($Subject->dependencies as $CurrentDependency) {
			if (!self::AddSubjectRecursive($CurrentDependency->dependent_subject_id, $user_id))
				return false;
		}
		
		return true;
	}
	
	public static function RemoveSubjectRecursive($id, $user_id) {
		//Ha ez a tárgy nincs teljesítve, nem csinálunk semmit
		$Check = self::model()->findByAttributes(
			array(
				'user_id' => $user_id,
				'subject_id' => $id
			)
		);
		
		if ($Check == null)
			return true;
			
		//Eltávolítjuk a tantárgyat a teljesítettek közül
		$Check->delete();		
		
		//Lekérdezzük a tantárgyra épülő összes tárgyat és töröljük a felvettek közül
		$Subject = Subject::model()->findByPk($id);
		foreach ($Subject->based_on as $Current) {
			if (!self::RemoveSubjectRecursive($Current->subject_id, $user_id))
				return false;
		}
		
		return true;
	}
}