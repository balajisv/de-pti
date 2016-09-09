<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle='Regisztráció';
$this->breadcrumbs=array(
	'Regisztráció',
);
?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<div class="alert alert-success">
				Sikeresen regisztrált a <?php print Yii::app()->name; ?> webhelyen. A bejelentkezéshez
				<?php print CHtml::link("[kattintson ide]", Yii::app()->createUrl("user/login")); ?>
			</div>
		</div>
	</div>
</div>