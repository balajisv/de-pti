<?php

/**
 * This is the model class for table "pti_subject_dependencies".
 *
 * The followings are the available columns in table 'pti_subject_dependencies':
 * @property integer $dependency_id
 * @property integer $subject_id
 * @property integer $dependent_subject_id
 */
class SubjectDependencies extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PtiSubjectDependencies the static model class
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
		return 'pti_subject_dependencies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject_id, dependent_subject_id', 'required'),
			array('subject_id, dependent_subject_id, dependency_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dependency_id, subject_id, dependent_subject_id', 'safe', 'on'=>'search'),
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
			//'subject' => array(self::HAS_ONE, 'Subject', 'dependent_subject_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dependency_id' => 'Dependency',
			'subject_id' => 'Subject',
			'dependent_subject_id' => 'Dependent Subject',
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

		$criteria->compare('dependency_id',$this->dependency_id);
		$criteria->compare('subject_id',$this->subject_id);
		$criteria->compare('dependent_subject_id',$this->dependent_subject_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}