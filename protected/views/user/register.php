<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Regisztráció';
$this->breadcrumbs=array(
	'Regisztráció',
);
?>
<div style="text-align: center; margin: 0 auto;">
<h1>Regisztráció</h1>

<div class="form" style="margin: 0 auto;">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'action'=>Yii::app()->createUrl('user/register'),
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<p class="note">
	A <span class="required">*</span>-gal jelölt mezők kitöltése kötelező.
	A "Regisztráció" gombra való kattintással elfogadja a webhely
	<?php print CHtml::link('nyilatkozatait', array('site/page', 'view' => 'law')); ?>.
</p>

	<div class="row">
		Felhasználónév: <span class="required">*</span><br/>
		<?php echo $form->textField($model,'username'); ?>
		<?php print $form->error($model, 'username'); ?>
	</div>

	<div class="row">
		Jelszó: <span class="required">*</span>
		<div class="hint">
			Legalább 6 karakter.
		</div>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php print $form->error($model, 'password'); ?>
	</div>
	
	<div class="row">
		Jelszó megerősítése: <span class="required">*</span><br/>
		<input type="password" name="User[verifypassword]">
		<?php print $form->error($model, 'verifypassword'); ?>
	</div>
	
	<div class="row">
		E-Mail cím: <span class="required">*</span><br/>
		<?php echo $form->textField($model,'email'); ?>
		<?php print $form->error($model, 'email'); ?>
	</div>
	
	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		Megerősítő kód: <span class="required">*</span>
		<div>
			<?php $this->widget('CCaptcha'); ?><br/>
			<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">
			Nem számít a kis- és nagybetű.
		</div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Regisztráció'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
</div>