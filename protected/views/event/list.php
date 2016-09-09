<?php
/* @var $this EventController */
$this->pageTitle = "Események";

$this->breadcrumbs=array(
	'Tantárgyak' => array('subject/index'),
	$model->name => array('subject/details', 'id' => $model->subject_id),
	'Események',
);

$CreateUrl = Yii::app()->createUrl("event/create", array("id" => $model->subject_id));

?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2><?php print $model->name; ?></h2>
		</div>
	</div>
	
	<?php if (Yii::app()->user->getId()) { ?>
		<div class="row">
			<div class="col-xs-12">
				<p>
					<button class="btn btn-md btn-success" onclick="CreateEvent('<?php print $CreateUrl; ?>')">
						<i class="fa fa-plus-circle"></i>
						Új esemény
					</button>
				</p>
			</div>
		</div>
	<?php } ?>
	
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-striped table-content-vertical-middle">
				<thead>
					<tr>
						<th>Időpont</th>
						<th class="text-align-center">Típus</th>
						<th>Megjegyzések</th>
						<th class="text-align-center">Műveletek</th>
					</tr>
				</thead>
				
				<tbody class="list">
					<?php
					
					foreach ($events as $event) {
						$this->renderPartial('_eventRow', array(
							'event' => $event,
						));
					}
					
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>