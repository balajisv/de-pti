<?php

define("EVENT_EXAM", 1);
define("EVENT_ZH", 2);
define("EVENT_CONSULTATION", 3);
define("EVENT_OTHER", 9);

/**
 * This is the model class for table "pti_events".
 *
 * The followings are the available columns in table 'pti_events':
 * @property integer $event_id
 * @property integer $subject_id
 * @property string $time
 * @property integer $type
 * @property string $notes
 */
class Events extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Events the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getFormattedTime() {
		return date("Y. m. d. H:i", strtotime($this->time));
	}
	
	public function getFormattedType() {
		switch ($this->type) {
			case EVENT_EXAM:
				return "Vizsga";
			break;
			
			case EVENT_ZH:
				return "Zárthelyi";
			break;
			
			case EVENT_CONSULTATION:
				return "Konzultáció";
			break;
			
			case EVENT_OTHER:
				return "Egyéb";
			break;
		}
	}
	
	public function getShortNotes() {
		$str = new StringHelper();
		
		return htmlspecialchars($str->substr($this->notes, 0, 60));
	}
	
	public function getTinyNotes() {
		$str = new StringHelper();
		
		return htmlspecialchars($str->substr($this->notes, 0, 15));
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pti_events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject_id, time, type', 'required'),
			array('subject_id, type', 'numerical', 'integerOnly'=>true),
			array('notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('event_id, subject_id, time, type, notes', 'safe', 'on'=>'search'),
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
			'subject' => array(self::BELONGS_TO, 'Subject', 'subject_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'event_id' => 'Eseményazonosító',
			'subject_id' => 'Tantárgyazonosító',
			'time' => 'Időpont',
			'type' => 'Típus',
			'notes' => 'Megjegyzés',
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

		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('subject_id',$this->subject_id);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}