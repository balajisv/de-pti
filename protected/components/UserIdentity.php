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
			$this->errorMessage = "Hibás felhasználónév vagy jelszó";
		}
		else if ($model->password != $this->getHash($model)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
			$this->errorMessage = "Hibás felhasználónév vagy jelszó";
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
	
	private function getHash($UserModel) {
		$StoreData = explode(',', $UserModel->hash_method);
		$HashAlgorithm = $StoreData[0];
		$UseSalt = $StoreData[1] == 'salted';
		
		$ToHash = $this->password;
		if ($UseSalt)
			$ToHash .= str_rot13($UserModel->username);
		
		switch ($HashAlgorithm) {
			case "sha1+md5":
				return sha1(md5($ToHash));
			break;
			
			case "sha512":
				return hash("sha512", $ToHash);
			break;
			
			default:
				return "";
		}
	}
}

?>