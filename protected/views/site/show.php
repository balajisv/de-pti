<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - ' . $model->title;

$sh = new StringHelper();

FbUtils::AddMetaTags(
	'DE-PTI - ' . $model->title,
	Yii::app()->params["domain"] . 'de-pti',
	$sh->substr($model->contents, 0, 60)
);

$FacebookUrl = Yii::app()->params['domain'] . Yii::App()->createUrl("site/showNews", array("id" => $data->news_id));

?>

<h1><?php print $model->title; ?></h1>

<div style="text-align: justify; margin-bottom: 20px;">
	<?php print nl2br($model->contents); ?>
</div>

<h3>Várjuk a véleményedet!</h3>
<div class="fb-comments" data-width="690" data-href="<?php print $FacebookUrl; ?>" data-numposts="5" data-colorscheme="light"></div>