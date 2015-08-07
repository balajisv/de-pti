<?php

Yii::import("application.components.StringHelper");


?>

<tr>
	<td><?php print Flaticon::GetByFilename($data->filename_real); ?></td>
	<td>
		<?php echo CHtml::link($data->filename_real, array('file/download', 'id'=>$data->file_id)); ?><br/>
		<?php echo $data->shortDescription; ?>
	</td>
	<td style="text-align: center;"><?php echo $data->downloads; ?></td>
	<td style="text-align: center;">
		<?php echo CHtml::link('[Adatok]', array('file/details', 'id'=>$data->file_id)); ?>
		<?php
			if (Yii::app()->user->getId() && (Yii::app()->user->level >= 1 || Yii::app()->user->getId() == $data->user_id)) {
				echo CHtml::link('[Törlés]', array('file/delete', 'id'=>$data->file_id));
			}
		?>
	</td>
</tr>