<?php
/* @var $this SiteController */

$this->pageTitle = $model->title;

$sh = new StringHelper();

FbUtils::AddMetaTags(
	'DE-PTI - ' . $model->title,
	Yii::app()->params["domain"] . 'de-pti',
	$sh->substr($model->contents, 0, 60)
);

$FacebookUrl = Yii::app()->params['domain'] . Yii::App()->createUrl("site/showNews", array("id" => $data->news_id));

?>

<div class="container">
	<div class="row">
		<div class="col-xs-12 text-align-justify">
			<p><?php print nl2br($model->contents); ?></p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3>Várjuk a véleményedet!</h3>
			<div class="text-align-center">
				<div class="fb-comments" data-width="690" data-href="<?php print $FacebookUrl; ?>" data-numposts="5" data-colorscheme="light"></div>
			</div>
		</div>
	</div>
</div>