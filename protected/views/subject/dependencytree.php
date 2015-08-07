<?php

$this->pageTitle=Yii::app()->name . ' - Tárgyfa - ' . $model->name;

$this->breadcrumbs=array(
	'Tantárgyak' => array('index'),
	$model->name => array('details', 'id' => $model->subject_id),
	'Tárgyfa'
);

function GetDepTree($ID, $Dependencies) {
	$CurrentModel = Subject::model()->findByPk($ID);
	print "<li>\n";
	print CHtml::link($CurrentModel->name, array('subject/details', 'id' => $CurrentModel->subject_id));
	
	if ($Dependencies != null) {
		print "<ul>\n";
		foreach ($Dependencies as $Key => $Val) {
			GetDepTree($Key, $Val);
		}
		print "</ul>\n";
	}
	
	print "</li>\n";
}

?>

<h1>Tárgyfa</h1>

<b>Tantárgy:</b> <?php print $model->name; ?><br/><br/>

<ul>
<?php

foreach ($dependencytree as $ID => $Dependencies) {
	GetDepTree($ID, $Dependencies);
}

?>
</ul>