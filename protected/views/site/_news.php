<div class="news">
	<div class="title"><?php print CHtml::link($data->title, array('site/showNews', 'id' => $data->news_id)); ?></div>
	<div class="metadata">
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
		
		<span style="float: right;">
			<?php
				if (Yii::app()->user->getId() && Yii::app()->user->level >= 1) {
					print CHtml::link("[Módosítás]", Yii::app()->createUrl("site/editnews", array('id' => $data->news_id))) . " ";
					print '<a href="#" onclick="DeleteNews(\''.
						Yii::app()->createUrl("site/deletenews", array('id' => $data->news_id))
					.'\')">[Törlés]</a>';
				}
			?>
		</span>
	</div>
	
	<div class="content">
		<?php print $str->substr($data->contents, 0, 400); ?>
	</div>
</div>