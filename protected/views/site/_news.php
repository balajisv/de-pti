<li<?php print $invert_timeline ? ' class="timeline-inverted"' : ''; ?>>
	<div class="timeline-badge"></div>
	<div class="timeline-panel">
		<div class="timeline-heading">
			<h4 class="timeline-title">
				<?php print CHtml::link($data->title, array('site/showNews', 'id' => $data->news_id)); ?>
			</h4>
			<p>
				<small class="text-muted">
					<i class="fa fa-clock-o"></i>
					<?php
						$str = new StringHelper();
					
						print date('Y. m. d. H:i', strtotime($data->date_created)); 
						
						if ($data->date_created != $data->date_updated) {
							print " (módosítva: " . date('Y. m. d. H:i', strtotime($data->date_updated)) . ")";
						}
						
						if ($data->subject_id != null) {
							$SubjName = $str->substr($data->subject->name, 0, 50);
							print ' - ' . CHtml::link(
								$SubjName,
								array(
									'subject/details',
									'id' => $data->subject->subject_id
								)
							);
						}
						print ' - <b>'.$data->user->username.'</b>';
					?>
				</small>
			</p>
			<?php
				if (Yii::app()->user->getId() && Yii::app()->user->level >= 1) {
					print '<p><div class="btn-group">';
					
					print CHtml::link(
						'<i class="fa fa-edit"></i> Módosítás',
						Yii::app()->createUrl("site/editnews", array(
							'id' => $data->news_id
						)),
						array(
							'class' => 'btn btn-sm btn-primary'
						)
					);
					
					print sprintf(
						'<a onclick="DeleteNews(\'%s\')" class="btn btn-sm btn-danger">
							<i class="fa fa-trash-o"></i>
							Törlés
						</a>',
						Yii::app()->createUrl("site/deletenews", array('id' => $data->news_id))
					);
					
					print '</div></p>';
				}
			?>
		</div>
		<div class="timeline-body text-align-justify">
			<p><?php print $str->substr($data->contents, 0, 400); ?></p>
		</div>
	</div>
</li>