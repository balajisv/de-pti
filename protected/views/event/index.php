<?php

$this->pageTitle=Yii::app()->name . ' - Események';

?>

<h1>Események</h1>

<?php

if (count($model) == 0) {
	print '
		<div class="flash-notice">
			Mostanában nem lesz semmi említésre méltó dolog...
		</div>
	';
}
else {
	print '
		<table>
			<thead>
				<tr>
					<th style="width: 120px;">Időpont</th>
					<th>Leírás</th>
				</tr>
			</thead>
			<tbody class="list">
	';
	
	foreach ($model as $Current) {
		print '
				<tr>
					<td>'.$Current->formattedTime.'</td>
					<td>
						<div style="font-size: 8pt;">
							<b>['.$Current->formattedType.']</b> -
							'.CHtml::Link($Current->subject->shortName, array('subject/details', 'id' => $Current->subject_id)).'
						</div>
						
						'.CHtml::Link('[Részletek]', array('event/details', 'id' => $Current->event_id)).'
						'.$Current->shortNotes.'
					</td>
				</tr>
		';
	}
	
	print '
			</tbody>
		</table>
	';
}

?>

<script type="text/javascript">
	ApplyHover();
</script>