<?php
/* @var $this SiteController */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/news.js', CClientScript::POS_HEAD);

$this->pageTitle=Yii::app()->name . ' - Hírek';

FbUtils::AddMetaTags(
	"DE-PTI - A Debreceni Egyetem Programtervező informatikus hallgatóinak közössége",
	Yii::app()->params["domain"] . 'de-pti',
	"Szerezd be a legújabb tananyagokat, értesülj a legfrissebb hírekről, és kövesd nyomon a tantárgyaidat!"
);
?>

<h1>Hírek</h1>

<?php

if (Yii::app()->user->getId() && (Yii::app()->user->level >= 1)) {
	$URL = Yii::app()->createUrl("site/addnews");
	print '<div style="margin-bottom: 10px;"><button onclick="ShowAddNews(\''.$URL.'\')">Hír közzététele</button></div>';
	?>
	
<script language="javascript">
	var Subjects = [
		<?php
			foreach (Subject::model()->findAll(array('order' => 'name')) as $CurrentSubject) {
				print "{ id: ".$CurrentSubject->subject_id.", name: '".$CurrentSubject->name."' },\n";
			}
		?>
	];
</script>
	
	<?php
}

?>

<!--
<div style="margin-bottom: 10px;">
	<b>Hírforrás:</b>
	DE-PTI |
	<?php //echo CHtml::link('inf.unideb.hu', array('site/index', 'source'=>'deik')); ?>
</div>
-->

<?php

foreach ($model as $Current) {
	$this->renderPartial('_news', array(
		'data' => $Current,
	));
}

$this->widget('CLinkPager', array(
    'pages' => $pager,
));

?>