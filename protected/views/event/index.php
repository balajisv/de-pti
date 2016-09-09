<?php

$this->pageTitle = 'Közelgő események';

?>

<div class="container">
	<?php
		if (!Yii::app()->user->isGuest) {
			print '
				<div class="row">
					<div class="col-xs-12">
						<div class="alert alert-info">
							<p>
								<i class="fa fa-info-circle"></i>
								Tudsz valami olyan eseményt, amit még nem látsz itt? A "Tantárgyak" menüpontban
								megoszthatod velünk!
							</p>
						</div>
					</div>
				</div>
			';
		}
	?>

	<div class="row">
		<div class="col-xs-12">

<?php

if (count($model) == 0) {
	print '
		<div class="alert alert-info">
			<i class="fa fa-info-circle"></i>
			Mostanában nem lesz semmi említésre méltó dolog...
		</div>
	';
}
else {
	print '
		<ul class="timeline">
	';
	
	$i = 1;
	foreach ($model as $Current) {
		$DeleteLink = "";
		if (!Yii::app()->user->isGuest) {
			$DeleteLink = CHtml::link(
				'<i class="fa fa-trash"></i> Törlés',
				array(
					"event/delete",
					"id" => $Current->event_id
				),
				array(
					'class' => 'btn btn-sm btn-danger'
				)
			);
		}
		
		$DetailsLink = CHtml::Link(
			'Bővebben',
			array(
				'event/details',
				'id' => $Current->event_id
			),
			array(
				'class' => 'btn btn-sm btn-primary'
			)
		);
		
		print '
			<li'.($i % 2 == 0 ? ' class="timeline-inverted"' : '').'>
				<div class="timeline-badge"></div>
				<div class="timeline-panel">
					<div class="timeline-heading">
						<h4 class="timeline-title">
							'.$Current->formattedType.'
						</h4>
						<p>
							<small class="text-muted">
								<i class="fa fa-clock-o"></i>
								'.$Current->formattedTime.'<br>
								<div class="cut-text">
									'.CHtml::Link($Current->subject->name, array('subject/details', 'id' => $Current->subject_id)).'
								</div>
							</small>
						</p>
					</div>
					<div class="timeline-body text-align-justify">
						<p>'.$Current->shortNotes.'</p>
						<p class="btn-group">
							'.$DetailsLink.'
							'.$DeleteLink.'
						</p>
					</div>
				</div>
			</li>
		';
		
		$i++;
	}
	
	print '
		</ul>
	';
}

?>
		</div>
	</div>
</div>