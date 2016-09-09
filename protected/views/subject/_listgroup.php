<tr>
	<td colspan="<?php print $TableColumns; ?>">
		<h3><?php print $GroupName; ?></h3>
	</td>
</tr>
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