<?php

define("SUBJECT_REQUIRED", 0);
define("SUBJECT_REQUIRED_CHOOSEABLE", 1);
define("SUBJECT_CHOSEABLE", 2);

/**
 * This is the model class for table "pti_subject".
 *
 * The followings are the available columns in table 'pti_subject':
 * @property integer $subject_id
 * @property string $name
 * @property integer $semester
 * @property string $description
 */
class Subject extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Subject the static model class
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
		return 'pti_subject';
	}
	
	public function getShortName() {
		$str = new StringHelper();
		return $str->substr($this->name, 0, 50);
	}
	
	public function getFormattedType() {
		switch ($this->group_id) {
			case SUBJECT_REQUIRED:
				return "Kötelező";
			break;
			
			case SUBJECT_REQUIRED_CHOOSEABLE:
				return "Kötelezően választható";
			break;
			
			case SUBJECT_CHOSEABLE:
				return "Szabadon választható";
			break;
		}
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, group_id', 'required'),
			array('semester', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('description', 'safe'),
			array('credits', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subject_id, name, semester, description, credits, group_id', 'safe', 'on'=>'search'),
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
			'filecount' => array(self::STAT, 'File', 'subject_id', 'select' => 'COUNT(file_id)'),
			'files' => array(self::HAS_MANY, 'File', 'subject_id'),
			'dependencies' => array(self::HAS_MANY, 'SubjectDependencies', 'subject_id'),
			'events' => array(self::HAS_MANY, 'Events', 'subject_id'),
			'eventcount' => array(self::STAT, 'Events', 'subject_id', 'select' => 'COUNT(event_id)'),
			'based_on' => array(self::HAS_MANY, 'SubjectDependencies', 'dependent_subject_id'),
			'group' => array(self::BELONGS_TO, 'SubjectGroup', 'group_id'),
		);
	}
	
	public function GetDependencyTree() {
		$Tree = array();
		
		foreach ($this->dependencies as $CurrentDependency) {
			$Tree[$CurrentDependency->dependent_subject_id] = Subject::model()->findByPk($CurrentDependency->dependent_subject_id)->GetDependencyTree();
		}
		
		return count($Tree) == 0 ? null : $Tree;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subject_id' => 'Tantárgyazonosító',
			'name' => 'Tantárgy',
			'semester' => 'Félév',
			'description' => 'Leírás',
			'credits' => 'Kreditérték',
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

		$criteria->compare('subject_id',$this->subject_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('semester',$this->semester);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('credits',$this->credits);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}