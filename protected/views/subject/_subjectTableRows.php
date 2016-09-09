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
		$class .= "danger";
	else if ($isCompleted)
		$class .= "success";
		
	$Group = ($data->group == null) ? "Nincs besorolva" : $data->group->group_name;
?>
<tr id="subject_<?php print $data->subject_id; ?>" class="<?php print $class; ?>">
	<td class="text-align-center"><?php print $data->semester; ?></td>
	<?php
		if (Yii::app()->user->getId())
			print '<td id="td_subject_'.$data->subject_id.'">'.$checkbox.'</td>';
	?>
	<td>
		<?php print CHtml::link($data->shortName, array('subject/details', 'id' => $data->subject_id)); ?>
	</td>
	<td class="text-align-center"><?php print $data->credits; ?></td>
	<td class="text-align-center">
		<div class="btn-group">
			<?php 
				print CHtml::link(
					sprintf('Tananyagok (%d)', $data->filecount),
					array(
						'file/list',
						'id' => $data->subject_id
					),
					array(
						'class' => 'btn btn-sm btn-primary'
					)
				);
				
				print CHtml::link(
					sprintf('Események (%d)', $data->eventcount),
					array(
						'event/list',
						'id' => $data->subject_id
					),
					array(
						'class' => 'btn btn-sm btn-default'
					)
				);
			?>
		</div>
	</td>
</tr>