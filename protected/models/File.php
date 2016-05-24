<?php

/**
 * This is the model class for table "pti_file".
 *
 * The followings are the available columns in table 'pti_file':
 * @property integer $file_id
 * @property integer $subject_id
 * @property integer $user_id
 * @property string $filename_local
 * @property string $filename_real
 * @property integer $downloads
 * @property string $description
 * @property string $date_created
 * @property string $date_updated
 * @property integer $vote_useful
 * @property integer $vote_useless
 */
class File extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return File the static model class
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
		return 'pti_file';
	}
	
	public function getFormattedBytes() {
		$formatter = new CFormatter();
		return $formatter->formatSize(filesize("upload/".$this->filename_local));
	}
	
	public function getFormattedUploadTime() {
		return date("Y. m. d. H:i:s", strtotime($this->date_created));
	}
	
	public function getFormattedModifyTime() {
		return date("Y. m. d. H:i:s", strtotime($this->date_updated));
	}
	
	public function getShortDescription() {
		$Str = new StringHelper();
		return $Str->substr($this->description, 0, 65);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject_id, user_id, filename_local, filename_real, date_created, date_updated', 'required'),
			array('subject_id, user_id, downloads, vote_useful, vote_useless', 'numerical', 'integerOnly'=>true),
			array('filename_local', 'length', 'max'=>250),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('file_id, subject_id, user_id, filename_local, filename_real, downloads, description, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'subject' => array(self::BELONGS_TO, 'Subject', 'subject_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'file_id' => 'Fájlazonosító',
			'subject_id' => 'Tantárgyazonosító',
			'user_id' => 'Felhasználóazonosító',
			'filename_local' => 'Helyi fájlnév',
			'filename_real' => 'Valódi fájlnév',
			'downloads' => 'Letöltve',
			'description' => 'Leírás',
			'date_created' => 'Létrehozva',
			'date_updated' => 'Módosítva',
			'vote_useful' => 'Hasznos értékelések száma',
			'vote_useless' => 'Nem hasznos értékelések száma'
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

		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('subject_id',$this->subject_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('filename_local',$this->filename_local,true);
		$criteria->compare('filename_real',$this->filename_real,true);
		$criteria->compare('downloads',$this->downloads);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}