<?php

Yii::import("application.components.StringHelper");

$UsefulVoteLink = CHtml::link(
	sprintf('<i class="fa fa-thumbs-up"></i> (%d)', $data->vote_useful),
	array('file/vote', 'id'=>$data->file_id, 'useful' => 1),
	array(
		'title' => 'Hasznos',
		'class' => 'btn btn-sm btn-success'
	)
);

$UselessVoteLink = CHtml::link(
	sprintf('<i class="fa fa-thumbs-down"></i> (%d)', $data->vote_useless),
	array('file/vote', 'id'=>$data->file_id, 'useful' => 0),
	array(
		'title' => 'Nem hasznos',
		'class' => 'btn btn-sm btn-danger'
	)
);
?>

<tr>
	<td><?php print Flaticon::GetByFilename($data->filename_real); ?></td>
	<td>
		<?php print CHtml::link($data->filename_real, array('file/download', 'id'=>$data->file_id)); ?><br/>
		<?php print $data->shortDescription; ?><br>
		
		
	</td>
	<td class="text-align-center"><?php print $data->downloads; ?></td>
	<td class="text-align-center">
		<div class="btn-group">
			<?php 
				print $UsefulVoteLink;
				print $UselessVoteLink;
			?>
		</div>
	</td>
	<td class="text-align-center">
		<div class="btn-group">
			<?php 
				print CHtml::link(
					'<i class="fa fa-info-circle"></i> Bővebben',
					array(
						'file/details',
						'id' => $data->file_id
					),
					array(
						'class' => 'btn btn-primary btn-sm'
					)
				);
				
				if (Yii::app()->user->getId() && (Yii::app()->user->level >= 1 || Yii::app()->user->getId() == $data->user_id)) {
					print CHtml::link(
						'<i class="fa fa-trash"></i> Törlés',
						array(
							'file/delete',
							'id' => $data->file_id
						),
						array(
							'class' => 'btn btn-danger btn-sm'
						)
					);
				}
			?>
		</div>
	</td>
</tr>