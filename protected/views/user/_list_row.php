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
	<td style="text-align: center;">
		<?php
			print '<a href="#" onclick="ShowSetLevelDialog(\''.Yii::app()->createUrl('user/setlevel', array('id' => $data->user_id)).'\')">'.$Level.'</a>';
		?>
	</td>
	<td style="text-align: center;"><?php print date('Y. m. d. H:i:s', strtotime($data->date_created)); ?></td>
	<td>
		<?php
			print CHtml::link('[Telj. tárgyak]', Yii::app()->createUrl('user/completedsubjects', array('id' => $data->user_id)));
		?>
	</td>
</tr>