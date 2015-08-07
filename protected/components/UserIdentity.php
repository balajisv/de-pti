<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

	private $UserID;
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$model = User::model()->with('CompletedCredits')->findByAttributes(array('username' => $this->username));
		
		if ($model == null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
			$this->errorMessage = "Hibás felhasználónév";
		}
		else if ($model->password != sha1(md5($this->password))) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
			$this->errorMessage = "Hibás jelszó";
		}
		else {
			$this->UserID = $model->user_id;
			$this->setState('email', $model->email);
			$this->setState('username', $model->username);
			$this->setState('level', $model->level);
			$this->setState('CompletedCredits', $model->CompletedCredits);
			$this->errorCode = self::ERROR_NONE;
			$this->errorMessage = "Minden rendben";
		}
		
		return !$this->errorCode;
	}
	
	public function getId() {
		return $this->UserID;
	}
}

?>