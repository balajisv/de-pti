<?php
/* @var $this EventController */

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/css/jquery-timepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-addons/timepicker.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/event.js', CClientScript::POS_HEAD);

$this->pageTitle=Yii::app()->name . ' - Események - ' . $model->name;

$this->breadcrumbs=array(
	'Tantárgyak' => array('subject/index'),
	$model->name => array('subject/details', 'id' => $model->subject_id),
	'Események',
);

$CreateUrl = Yii::app()->createUrl("event/create", array("id" => $model->subject_id));

?>

<h1>Események</h1>

<?php if (Yii::app()->user->getId()) { ?>
	<div style="margin-bottom: 10px;">
		<button onclick="CreateEvent('<?php print $CreateUrl; ?>')">Új esemény kiírása</button>
	</div>
<?php } ?>

<table>
	<thead>
		<tr>
			<th style="width: 150px;">Időpont</th>
			<th style="text-align: center; width: 100px;">Típus</th>
			<th>Megjegyzések</th>
			<th style="text-align: center; width: 200px;">Műveletek</th>
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

<script language="javascript" type="text/javascript">
	ApplyHover();
</script>