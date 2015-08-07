<tr>
	<td><?php print $event->formattedTime; ?></td>
	<td style="text-align: center;"><?php print $event->formattedType; ?></td>
	<td><?php print $event->shortNotes; ?></td>
	<td style="text-align: center;">
		<?php
		
			print CHtml::link("[Adatok]", array("event/details", "id" => $event->event_id));
			
			if (Yii::app()->user->getId()) {
				print ' ' . CHtml::link("[Módosítás]", array("event/edit", "id" => $event->event_id)) . " ";
				print CHtml::link("[Törlés]", array("event/delete", "id" => $event->event_id));
			}
		
		?>
	</td>
</tr>