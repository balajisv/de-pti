<h3><?php print $GroupName; ?></h3>

<table>
	<thead>
		<tr>
			<th style="width: 20px; text-align: center;">Félév</th>
			<?php if (Yii::app()->user->getId()): ?>
				<th style="width: 16px; text-align: center;">Telj.</th>
			<?php endif; ?>
			<th>Tantárgy</th>
			<th style="width: 20px; text-align: center;">Kredit</th>
			<th style="width: 20px; text-align: center;">Fájlok</th>
			<th style="width: 130px; text-align: center;">Műveletek</th>
		</tr>
	</thead>
	
	<tbody class="list">
		<?php
			foreach ($Subjects as $Current) {
				$this->renderPartial('_subjectTableRows', array(
					'data' => $Current,
					'isCompleted' => in_array($Current->subject_id, $completedSubjects),
					'isCompletable' => in_array($Current->subject_id, $completableSubjects),
					'drawbg' => false,
				));
			}
		?>
	</tbody>
</table>