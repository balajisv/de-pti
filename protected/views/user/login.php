<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = 'Bejelentkezés';
$this->breadcrumbs=array(
	'Bejelentkezés',
);
?>

<div class="container">
	<?php
		if (isset($error)) {
			print '
				<div class="row">
					<div class="col-xs-12">
						<div class="alert alert-danger">
							<i class="fa fa-info-circle"></i>
							'.$error.'
						</div>
					</div>
				</div>
			';
		}
	?>

	<form class="form-signin" method="post" action="<?php print Yii::app()->createUrl('user/login'); ?>">
		<label for="username" class="sr-only">Felhasználónév</label>
		<input type="text" name="User[username]" id="username" class="form-control" placeholder="Felhasználónév" required autofocus>
		
		<label for="password" class="sr-only">Jelszó</label>
		<input type="password" name="User[password]" id="password" class="form-control" placeholder="Jelszó" required>
		
		<button class="btn btn-lg btn-success btn-block" type="submit">Bejelentkezés</button>
		<a class="btn btn-md btn-default btn-block" href="<?php print Yii::app()->createUrl('user/register'); ?>">Én is szeretnék tag lenni!</a>
	</form>
</div>