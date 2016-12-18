<?php

/**
 * This is the model class for table "pti_user".
 *
 * The followings are the available columns in table 'pti_user':
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $disabled
 * @property string $date_created
 * @property string $date_updated
 */
class User extends CActiveRecord
{

	public $verifypassword;
	public $verifyCode;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'pti_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, hash_method, email, disabled, date_created, date_updated', 'required'),
			
			//Password validation
			array('password, verifypassword, hash_method', 'required', 'on'=>'insert'),
			array('password, verifypassword', 'length', 'min'=>6, 'max'=>40, 'on'=>'insert'),
			array('hash_method', 'length', 'max'=>20),
			array('password', 'compare', 'compareAttribute'=>'verifypassword', 'on'=>'insert'),
			
			array('disabled, level', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>50),
			
			//Unique validators
			array('username', 'unique','className'=>'User','attributeName'=>'username','message'=>"Már regisztráltak ezzel a névvel"),
			array('email', 'unique','className'=>'User','attributeName'=>'email','message'=>"Már regisztráltak ezzel az e-mail címmel"),
			
			//E-mail validator
			array('email', 'email'),
			array('email', 'length', 'max'=>250),
			
			//Captcha
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'on'=>'insert'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, username, password, hash_method, email, disabled, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'CompletedSubjects' => array(self::MANY_MANY, 'Subject', 'pti_user_subjects(user_id, subject_id)'),
			'CompletedCredits' => array(
				self::STAT,
				'Subject', 
				'pti_user_subjects(user_id, subject_id)',
				'select' => 'SUM(credits)',
				'defaultValue' => 0
			),
			'CompletedSubjectCount' => array(
				self::STAT,
				'Subject', 
				'pti_user_subjects(user_id, subject_id)',
				'select' => 'COUNT(*)',
				'defaultValue' => 0
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'Azonosító',
			'username' => 'Felhasználónév',
			'password' => 'Jelszó',
			'verifypassword' => 'Jelszó megerősítése',
			'email' => 'E-mail cím',
			'disabled' => 'Letiltva',
			'level' => 'Hozzáférés szintje',
			'date_created' => 'Létrehozva',
			'date_updated' => 'Frissítve',
			'verifyCode' => 'Megerősítő kód',
			'hash_method' => 'Jelszó-titkosítási mód'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('disabled',$this->disabled);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
		if (!empty($this->password) && !empty($this->verifypassword)) {
			$this->password = hash('sha512', $this->password . str_rot13($this->username));
			
			$this->hash_method = 'sha512,salted';
		}
		
		$this->date_updated = new CDbExpression("NOW()");
		
		return true;
	}
}