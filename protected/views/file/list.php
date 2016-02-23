<?php

Flaticon::Register("/css/flaticon");

$this->pageTitle=Yii::app()->name . ' - Fájlok - ' . $data->name;

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

<h1>Tantárgyhoz kapcsolódó fájlok</h1>
<h4><?php print $data->name; ?></h4>

<?php if (Yii::app()->user->getId()): ?>
<div style="margin-bottom: 10px;">
	<button onclick="ShowUploadDialog('<?php print $form_target; ?>', '<?php print $UploadLimit; ?>', '<?php print GetMaxUploadFileSize(); ?>')">Fájl feltöltése</button>
</div>
<?php endif; ?>

<?php if ($data->filecount == 0): ?>
<div class="flash-notice">
	<table>
		<tr>
			<td style="width: 60px;"><img src="images/cryingsmiley.png" width="60" height="60"/></td>
			<td>
				Még senki sem töltött fel fájlt ehhez a tantárgyhoz.
				<?php
					if (Yii::app()->user->getId())
						print '
							Ez egy remek lehetőség arra, hogy segíts a hallgatótársaidnak!
							Kattints a <b>Fájl feltöltése</b> gombra, töltsd fel a jegyzeteidet, és bármit, ami
							szerinted hasznos lehet a tantárgy teljesítéséhez!
						';
				?>
			</td>
		</tr>
	</table>
</div>
<?php else: ?>
<table>
	<thead>
		<tr>
			<th style="width: 20px;"></th>
			<th>Fájlnév</th>
			<th style="width: 30px; text-align: center;">Letöltve</th>
			<th style="width: 100px; text-align: center;">Műveletek</th>
		</tr>
	</thead>
	
	<tbody class="list">
	
	<?php
		foreach ($data->files as $Current) {
			$this->renderPartial('_files', array(
				'data' => $Current,
			));
		}
	?>
	
	</tbody>
</table>

<script language="javascript" type="text/javascript">
	ApplyHover();
</script>
<?php endif; ?>