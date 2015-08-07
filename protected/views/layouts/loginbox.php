<?php
	$LoggedIn = Yii::app()->user->getId();
	
	$Content = null;
	$Title = "Bejelentkezés";
	
	if ($LoggedIn) {
		$Title = Yii::app()->user->username;
		$Content = '
			'.Yii::app()->user->CompletedCredits . ' kredit<br/>
			'.CHtml::link('[Kijelentkezés]', array('user/logout')).'
		';
		
		if (Yii::app()->user->level == 2) {
			$Content .= '<br/>'.CHtml::link('[Felhasználók]', array('user/list'));
		}
	}
	else {
		$Content = '
			<form method="post" action="'.Yii::app()->createUrl("user/login").'">
				<input type="text" name="User[username]" placeholder="Felhasználónév" style="margin-bottom: 3px;"/><br/>
				<input type="password" name="User[password]" placeholder="Jelszó" style="margin-bottom: 3px;"/><br/>
				<input type="submit" value="Bejelentkezés" style="margin-bottom: 3px;"/><br/>
				
				'.CHtml::link('[Regisztráció]', array('user/register')).'
			</form>
		';
	}
	
	$this->renderPartial("//layouts/leftbox", array(
		"Title" => $Title,
		"Content" => $Content
	));
?>