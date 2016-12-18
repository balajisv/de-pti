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
			<div class="alert alert-info">
				<p>
					<i class="fa fa-info-circle"></i>
					Kérjük, töltse ki az űrlap minden mezőjét!
					
					A "Regisztráció" gombra való kattintással elfogadja a webhely
					<?php print CHtml::link('nyilatkozatait', array('site/page', 'view' => 'law')); ?>.
				</p>
			</div>
		</div>
	</div>
	
	<?php
		if ($model->hasErrors()) {
			print '
				<div class="row">
					<div class="col-xs-12">
						<div class="alert alert-danger">
							<p>
								Úgy tűnik, hogy van egy-két dolog, ami félrement...
								'.CHtml::errorSummary($model).'
							</p>
						</div>
					</div>
				</div>
			';
		}
	?>

	<div class="row">
		<div class="col-xs-12">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'login-form',
				'action'=>Yii::app()->createUrl('user/register'),
				'enableClientValidation'=>false,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
				'htmlOptions' => array(
					'class' => 'form-signin'
				)
			)); ?>

			<?php 
				print $form->textField($model,'username', array(
					'class' => 'form-control',
					'required',
					'placeholder' => 'Felhasználónév'
				));
			?>

			<?php
				print $form->passwordField($model,'password', array(
					'class' => 'form-control',
					'required',
					'placeholder' => 'Jelszó (legalább 6 karakter)'
				));
			?>
		
			<input type="password" name="User[verifypassword]" class="form-control" required placeholder="Jelszó újra">
		
			<?php 
				print $form->textField($model,'email', array(
					'class' => 'form-control',
					'required',
					'placeholder' => 'E-Mail cím'
				));
			?>
			
			<?php if(CCaptcha::checkRequirements()): ?>
				Megerősítő kód: <span class="required">*</span>
				<div>
					<?php $this->widget('CCaptcha'); ?><br/>
					<?php print $form->textField($model,'verifyCode'); ?>
				</div>
				<div class="hint">
					Nem számít a kis- és nagybetű.
				</div>
			<?php endif; ?>

			<?php
				print CHtml::submitButton('Regisztráció', array(
					'class' => 'btn btn-lg btn-primary form-control'
				));
			?>

			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>