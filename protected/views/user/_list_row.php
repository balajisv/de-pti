<?php

	$Level = null;
	switch ($data->level) {
		case 0:
			$Level = "Átlagfelhasználó";
		break;
		
		case 1:
			$Level = "Szerkesztő";
		break;
		
		case 2:
			$Level = "Tulajdonos";
		break;
	}
	
?>

<tr>
	<td><?php print $data->username; ?></td>
	<td><?php print $data->email; ?></td>
	<td class="text-align-center">
		<?php
			print '<a class="btn btn-primary btn-sm" onclick="ShowSetLevelDialog(\''.Yii::app()->createUrl('user/setlevel', array('id' => $data->user_id)).'\')">'.$Level.'</a>';
		?>
	</td>
	<td class="text-align-center"><?php print date('Y. m. d. H:i:s', strtotime($data->date_created)); ?></td>
	<td class="text-align-center">
		<div class="btn-group">
			<?php
				print CHtml::link(
					'Telj. tárgyak',
					Yii::app()->createUrl(
						'user/completedsubjects',
						array(
							'id' => $data->user_id
						)
					),
					array(
						'class' => 'btn btn-primary btn-sm'
					)
				);
			?>
		</div>
	</td>
</tr>