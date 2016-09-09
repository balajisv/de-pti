<?php /* @var $this Controller */ ?>

<?php
	$this->beginContent('//layouts/main'); 
	Yii::app()->params["bodyClass"] = ' class="no-padding"';
?>

<header>
	<div class="jumbotron">
		<div class="container">
			<div class="row full-height">
				<div class="full-height vertical-centered text-align-center">
					<div class="col-xs-12">
						<h1>DE-PTI</h1>
						<h4>2011 óta a debreceni programtervező informatikus BSc. hallgatók szolgálatában</h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>


<?php 
	echo $content;
	$this->endContent();
?>