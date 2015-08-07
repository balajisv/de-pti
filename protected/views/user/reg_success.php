<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Regisztráció';
$this->breadcrumbs=array(
	'Regisztráció',
);
?>

<h1>Regisztráció</h1>

Sikeresen regisztrált a <?php print Yii::app()->name; ?> webhelyen. A bejelentkezéshez
<?php print CHtml::link("[kattintson ide]", Yii::app()->createUrl("user/login")); ?>