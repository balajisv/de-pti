<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Hiba';
$this->breadcrumbs=array(
	'Hiba',
);
?>

<h2>Hiba: <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>