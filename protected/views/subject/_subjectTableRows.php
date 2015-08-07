<?php
	$checkbox = CHtml::checkBox(
		'SubjectCompleted_'.$data->subject_id,
		$isCompleted,
		array(
			'onclick' => 'ToggleSubjectCompletion('.$data->subject_id.', this)',
		)
	);
	
	$class = "";
	if ($isCompletable)
		$class .= "completable";
	else if ($isCompleted)
		$class .= "completed";
		
	$Group = ($data->group == null) ? "Nincs besorolva" : $data->group->group_name;
?>
<tr id="subject_<?php print $data->subject_id; ?>" class="<?php print $class; ?>">
	<td style="text-align: center;"><?php print $data->semester; ?></td>
	<?php
		if (Yii::app()->user->getId())
			print '<td id="td_subject_'.$data->subject_id.'">'.$checkbox.'</td>';
	?>
	<td><?php print CHtml::link($data->shortName, array('subject/details', 'id' => $data->subject_id)); ?></td>
	<td style="text-align: center;"><?php print $data->credits; ?></td>
	<td style="text-align: center;"><?php print $data->filecount; ?></td>
	<td style="text-align: center;">
		<?php print CHtml::link('[Fájlok]', array('file/list', 'id' => $data->subject_id)); ?>
		<?php print CHtml::link('[Események]', array('event/list', 'id' => $data->subject_id)); ?>
	</td>
</tr>