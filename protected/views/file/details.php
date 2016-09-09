<?php

$this->pageTitle = "A tananyagról bővebben";

$this->breadcrumbs=array(
	'Tantárgyak' => array('subject/index'),
	$data->subject->name => array('subject/details', 'id'=>$data->subject_id),
	'Fájlok' => array('file/list', 'id'=>$data->subject_id),
	$data->filename_real,
);

$FacebookUrl = Yii::app()->params['domain'] . Yii::App()->createUrl("file/details", array("id" => $data->file_id));

?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2><?php print $data->filename_real; ?></h2>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<p>
				<?php 
					print CHtml::link(
						'<i class="fa fa-download"></i> Letöltés',
						array(
							'file/download',
							'id'=>$data->file_id
						),
						array(
							'class' => 'btn btn-md btn-primary'
						)
					);
				?>
					
				<p>
					<?php print $data->formattedBytes; ?>
					<br/>
					Eddig <?php print $data->downloads; ?> alkalommal töltötték le.
				</p>
			</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<p>
				<?php print CHtml::link($data->subject->name, array('subject/details', 'id'=>$data->subject_id)); ?>
				[<?php print $data->subject->group->group_name; ?>] tantárgyhoz tartozó fájl.
			</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<h3>Leírás</h3>
			<p>
				<?php print nl2br($data->description); ?>
			</p>
		</div>
		
		<div class="col-xs-12 col-sm-6">
			<h3>Egyéb adatok</h3>
			<p>
				Ezt a fájlt <b><?php print $data->user->username; ?></b> töltötte fel
				<?php print $data->formattedUploadTime; ?>-kor
				
				<?php
					if ($data->date_created == $data->date_updated)
						print ' és azóta nem volt módosítva.';
					else
						print ', és utoljára módosítva '.$data->formattedModifyTime.'-kor volt.';
				?>
			</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3>Te is letöltötted? Mondd el a véleményed róla!</h3>
			<div class="fb-comments" data-width="690" data-href="<?php print $FacebookUrl; ?>" data-numposts="5" data-colorscheme="light"></div>
		</div>
	</div>
</div>