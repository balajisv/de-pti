<?php

Flaticon::Register("/css/flaticon");

$this->pageTitle = "Tananyagok";

$this->breadcrumbs=array(
	'Tantárgyak' => array('subject/index'),
	$data->name => array('subject/details', 'id'=>$data->subject_id),
	'Fájlok',
);

$form_target = Yii::App()->createUrl("file/upload", array("id" => $data->subject_id));

function GetMaxUploadFileSize() {
	$val = trim(ini_get("post_max_size"));
	$last = strtolower($val[strlen($val)-1]);
	switch($last) {
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
	 }
	 return $val;
}

$formatter = new CFormatter();
$UploadLimit = $formatter->formatSize(GetMaxUploadFileSize());

?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2><?php print $data->name; ?></h2>
		</div>
	</div>

	<?php if (Yii::app()->user->getId()): ?>
	<div class="row">
		<div class="col-xs-12">
			<p>
				<button class="btn btn-md btn-success" onclick="ShowUploadDialog('<?php print $form_target; ?>', '<?php print $UploadLimit; ?>', '<?php print GetMaxUploadFileSize(); ?>')">
					<i class="fa fa-upload"></i>
					Fájl feltöltése
				</button>
			</p>
		</div>
	</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-xs-12">
			<?php if ($data->filecount == 0): ?>
				<div class="alert alert-info">
					<p>
						Még senki sem töltött fel fájlt ehhez a tantárgyhoz.
						<?php
							if (Yii::app()->user->getId())
								print '
									Ez egy remek lehetőség arra, hogy segíts a hallgatótársaidnak!
									Kattints a <b>Fájl feltöltése</b> gombra, töltsd fel a jegyzeteidet, és bármit, ami
									szerinted hasznos lehet a tantárgy teljesítéséhez!
								';
						?>
					</p>
				</div>
			<?php else: ?>
				<table class="table table-striped table-content-vertical-middle">
					<thead>
						<tr>
							<th style="width: 20px;"></th>
							<th>Fájlnév</th>
							<th class="text-align-center">Letöltve</th>
							<th class="text-align-center">Hasznos?</th>
							<th class="text-align-center">Műveletek</th>
						</tr>
					</thead>
					
					<tbody>
					
					<?php
						foreach ($data->files as $Current) {
							$this->renderPartial('_files', array(
								'data' => $Current,
							));
						}
					?>
					
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	</div>
</div>