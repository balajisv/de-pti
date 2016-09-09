<?php /* @var $this Controller */ ?>

<?php 
	$this->beginContent('//layouts/main');
	Yii::app()->params["bodyClass"] = "";
?>

<header>
	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h1><?php print $this->pageTitle; ?></h1>
				</div>
			</div>
		</div>
	</div>
</header>

<?php 
	echo $content;
	$this->endContent();
?>