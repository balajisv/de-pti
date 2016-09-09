<tr>
	<td><?php print $event->formattedTime; ?></td>
	<td class="text-align-center"><?php print $event->formattedType; ?></td>
	<td><?php print $event->shortNotes; ?></td>
	<td class="text-align-center">
		<div class="btn-group">
			<?php
			
				print CHtml::link(
					'<i class="fa fa-info-circle"></i> Bővebben',
					array(
						"event/details", 
						"id" => $event->event_id
					),
					array(
						'class' => 'btn btn-primary btn-sm'
					)
				);
				
				if (Yii::app()->user->getId()) {
					print CHtml::link(
						'<i class="fa fa-edit"></i> Módosítás',
						array(
							"event/edit",
							"id" => $event->event_id
						),
						array(
							'class' => 'btn btn-sm btn-default'
						)
					);
					
					print CHtml::link(
						'<i class="fa fa-trash"></i> Törlés',
						array(
							"event/delete",
							"id" => $event->event_id
						),
						array(
							'class' => 'btn btn-sm btn-danger'
						)
					);
				}
			?>
		</div>
	</td>
</tr>