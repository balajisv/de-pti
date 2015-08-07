<?php

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/css/jquery-timepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-addons/timepicker.js', CClientScript::POS_HEAD);

$this->pageTitle=Yii::app()->name . ' - Esemény szerkesztése - [' . $EventModel->formattedType . '] ' . $EventModel->tinyNotes;

$this->breadcrumbs=array(
	'Tantárgyak' => array('subject/index'),
	$SubjectModel->name => array('subject/details', 'id' => $SubjectModel->subject_id),
	'Események' => array('list', 'id' => $SubjectModel->subject_id),
	"[$EventModel->formattedType] - " . $EventModel->tinyNotes => array('details', 'id' => $EventModel->event_id),
	'Szerkesztés'
);

$formAction = Yii::app()->createUrl("event/edit", array('id' => $EventModel->event_id));

?>

<h1>Esemény szerkesztése</h1>

<form method="post" action="<?php print $formAction; ?>">
	<table>
		<tbody>
			<tr>
				<td class="name" style="width: 100px;">Időpont:</td>
				<td><input type="text" name="time" value="<?php print $EventModel->time; ?>"/></td>
			</tr>
			<tr>
				<td class="name">Típus:</td>
				<td>
					<select name="type">
						<?php
							$Types = array(
								1 => "Vizsga",
								2 => "Zárthelyi",
								3 => "Konzultáció",
								9 => "Egyéb"
							);
							
							foreach ($Types as $Val => $Friendly) {
								$Selected = ($Val == $EventModel->type) ? " selected" : "";
								print '<option value="'.$Val.'"' . $Selected . ">$Friendly</option>\n";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="name">Leírás:</td>
				<td>
					<textarea name="notes" style="width: 600px; height: 250px;"><?php print $EventModel->notes; ?></textarea>
				</td>
			</tr>
		</tbody>
	</table>
	
	<input type="submit" name="saved" value="Mentés"/>
</form>

<script language="javascript" type="text/javascript">
	$('[name="time"]').datetimepicker({
		firstDay: 1,
		dateFormat: "yy-mm-dd",
	});
</script>