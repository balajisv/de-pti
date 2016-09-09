<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle='Valami nagyon félresikerült...';
$this->breadcrumbs=array(
	'Hiba',
);
?>

<section>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="alert alert-danger" role="alert">
					#<?php echo $code; ?>: <?php echo CHtml::encode($message); ?>
				</div>
			</div>
		</div>
	</div>
</section>