<?php

$this->pageTitle = "Az eseményről bővebben";

$this->breadcrumbs=array(
	'Tantárgyak' => array('subject/index'),
	$SubjectModel->name => array('subject/details', 'id' => $SubjectModel->subject_id),
	'Események' => array('list', 'id' => $SubjectModel->subject_id),
	"[$EventModel->formattedType] - " . $EventModel->tinyNotes
);

?>

<div class="container">
	<?php
		if (Yii::app()->user->getId()) {
			print '
				<div class="row">
					<div class="col-xs-12">
						<p>
							<div class="btn-group">
			';
			
			print CHtml::link(
				'<i class="fa fa-edit"></i> Módosítás',
				array(
					"event/edit",
					"id" => $EventModel->event_id
				),
				array(
					'class' => 'btn btn-sm btn-success'
				)
			);
			
			if (!Yii::app()->user->isGuest) {
				print CHtml::link(
					'<i class="fa fa-trash"></i> Törlés',
					array(
						"event/delete",
						"id" => $EventModel->event_id
					),
					array(
						'class' => 'btn btn-sm btn-danger'
					)
				);
			}
			
			print '
							</div>
						</p>
					</div>
				</div>
			';
		}
	?>

	<div class="row">
		<div class="col-xs-12">
			<table class="table">
				<tbody>
					<tr>
						<td>Időpont:</td>
						<td><?php print $EventModel->formattedTime; ?></td>
					</tr>
					<tr>
						<td>Tantárgy:</td>
						<td><?php print $EventModel->subject->name; ?></td>
					</tr>
					<tr>
						<td>Típus:</td>
						<td><?php print $EventModel->formattedType; ?></td>
					</tr>
					<tr>
						<td>Leírás:</td>
						<td><?php print htmlspecialchars($EventModel->notes); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>