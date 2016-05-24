<?php

Yii::import("application.components.StringHelper");

$AllVotes = $data->vote_useful + $data->vote_useless;

$UsefulVoteLink = CHtml::link(
	'<i class="fa fa-thumbs-up"></i>',
	array('file/vote', 'id'=>$data->file_id, 'useful' => 1),
	array(
		'title' => 'Hasznos'
	)
);

$UselessVoteLink = CHtml::link(
	'<i class="fa fa-thumbs-down"></i>',
	array('file/vote', 'id'=>$data->file_id, 'useful' => 0),
	array(
		'title' => 'Nem hasznos'
	)
);
?>

<tr>
	<td><?php print Flaticon::GetByFilename($data->filename_real); ?></td>
	<td>
		<?php echo CHtml::link($data->filename_real, array('file/download', 'id'=>$data->file_id)); ?><br/>
		<?php echo $data->shortDescription; ?><br>
		
		<?php print $UsefulVoteLink; ?>
		<?php print $UselessVoteLink; ?>
		<progress max="<?=$AllVotes?>" value="<?=$data->vote_useful?>"></progress>
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