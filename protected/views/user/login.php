<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Bejelentkezés';
$this->breadcrumbs=array(
	'Bejelentkezés',
);
?>
<div style="text-align: center; margin: 0 auto;">
<h1>Bejelentkezés</h1>

<div class="form" style="margin: 0 auto;">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'action'=>Yii::app()->createUrl('user/login'),
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">A <span class="required">*</span>-gal jelölt mezők kitöltése kötelező.</p>
	
	<span style="color: #FF0000;">
		<?php if (isset($error)) echo $error; ?>
	</span>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Bejelentkezés'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
</div>
