<?php

$this->pageTitle=Yii::app()->name . ' - Esemény adatai - [' . $EventModel->formattedType . '] ' . $EventModel->tinyNotes;

$this->breadcrumbs=array(
	'Tantárgyak' => array('subject/index'),
	$SubjectModel->name => array('subject/details', 'id' => $SubjectModel->subject_id),
	'Események' => array('list', 'id' => $SubjectModel->subject_id),
	"[$EventModel->formattedType] - " . $EventModel->tinyNotes
);

?>

<h1>Esemény adatai</h1>

<?php

if (Yii::app()->user->getId()) {
	print '<div style="margin-bottom: 10px;">';
	print CHtml::link("[Módosítás]", Yii::app()->createUrl("event/edit", array('id' => $EventModel->event_id)));
	print '</div>';
}

?>

<table>
	<tbody>
		<tr>
			<td class="name" style="width: 100px;">Időpont:</td>
			<td><?php print $EventModel->formattedTime; ?></td>
		</tr>
		<tr>
			<td class="name">Típus:</td>
			<td><?php print $EventModel->formattedType; ?></td>
		</tr>
		<tr>
			<td class="name">Leírás:</td>
			<td><?php print htmlspecialchars($EventModel->notes); ?></td>
		</tr>
	</tbody>
</table>