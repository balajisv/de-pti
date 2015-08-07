<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/subjectdetails.js', CClientScript::POS_HEAD);

$this->pageTitle=Yii::app()->name . ' - ' . $data->name;

$this->breadcrumbs=array(
	'Tantárgyak' => array('index'),
	$data->name,
);

$EditDescriptionLink = Yii::App()->createUrl("subject/editdescription", array("id" => $data->subject_id));
$FacebookUrl = Yii::app()->params['domain'] . Yii::App()->createUrl("subject/details", array("id" => $data->subject_id));

FbUtils::AddMetaTags(
	"DE-PTI - ".$data->name,
	Yii::app()->params["domain"] . Yii::app()->createUrl('subject/index'),
	"Tudj meg többet erről a ".$data->group->group_name." tárgycsoportba tartozó tantárgyról!"
);

?>

<h1><?php print $data->name; ?></h1>

<p>
	<?php print $data->credits; ?> kreditértékű,
	<?php print $data->group->group_name; ?> tárgycsoportba tartozó tantárgy,
	<?php print ($data->semester == NULL) ? "nincs megadva ajánlott félév." : $data->semester . ". félévben ajánlott."; ?>
	<br/>
	Ehhez a tantárgyhoz <?php print $data->filecount; ?> fájl és <?php print $data->eventcount; ?> esemény tartozik.
	Eddig <fb:comments-count href="<?php print $FacebookUrl; ?>"><span class="fa fa-spin fa-refresh"></span></fb:comments-count> vélemény érkezett.
</p>

<div style="margin-bottom: 15px;">
	<div style="float: left;">
		<?php print CHtml::link("[Tárgyfa]", array('subject/dependencytree', 'id' => $data->subject_id)); ?>
		<?php print CHtml::link("[Fájlok]", array('file/list', 'id' => $data->subject_id)); ?>
		<?php print CHtml::link("[Események]", array('event/list', 'id' => $data->subject_id)); ?>
	</div>
	<div style="float: right;">
		<div class="fb-send" data-href="<?php print $FacebookUrl; ?>" data-colorscheme="light"></div>
		<div class="fb-like" data-href="<?php print $FacebookUrl; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
	</div>
	<div style="clear: both;"></div>
</div>

<?php 
if (Yii::app()->user->getId()) {
	print '
		<h3>Hiányzások</h3>
		<p>
			<div id="absenteeism">
				Ebből a tárgyból eddig '. (($Misses == 0) ? 'még nincs hiányzásod - jól csinálod' : "$Misses alkalommal hiányoztál") .'.
			</div>
			<a href="#" onclick="IncrementAbsenteeism('.$data->subject_id.')">[Hiányoztam]</a>
			<a href="#" onclick="ResetAbsenteeism('.$data->subject_id.')">[Nullázás]</a>
		</p>
	';
}
?>

<h3>Előkövetelmények</h3>
<?php
	if (Yii::app()->user->getId() && Yii::app()->user->level >= 1):
?>
<p>
	<form method="post" action="<?php print Yii::App()->createUrl("subject/adddependency", array("id" => $data->subject_id)); ?>">
		Előkövetelmény hozzáadása:<br/>
		<select name="dependency_id">
			<?php
				foreach (Subject::model()->findAll(array('order' => 'name')) as $CurrentSubject) {
					if (
						//Az aktuális tárgy nem a megjelenített tárgy, és
						$CurrentSubject->subject_id != $data->subject_id &&
						//Az aktuális tárgy ajánlott féléve kisebb, vagy
						(
							$CurrentSubject->semester < $data->semester ||
							//Vagy a tárgynak nincs ajánlott féléve
							$data->semester == null
						) &&
						//Első féléves tárgynak nem lehet előkövetelménye
						$data->semester != 1
					) {
						print '<option value="'.$CurrentSubject->subject_id.'">'.$CurrentSubject->name."</option>\n";
					}
				}
			?>
		</select>
		<input type="submit" value="Hozzáadás">
	</form>
	<?php
		endif;
	?>
</p>

<?php
	if (count($dependencies) == 0) {
		print "<p>A tárgynak nincs előkövetelménye.</p>";
	}
	else {
		print '
			<table>
				<thead>
					<tr>
						<th>Tantárgy neve</th>
						<th style="text-align: center; width: 50px;">Félév</th>
						<th style="text-align: center; width: 200px;">Tárgycsoport</th>
					</tr>
				</thead>
				<tbody class="list">
		';
		foreach ($dependencies as $val) {
			$RemoveLink = "";
			if (Yii::app()->user->getId() && Yii::app()->user->level >= 1) {
				$RemoveLink = CHtml::link("[X]", array('subject/removedependency', 'id' => $val["dependency_id"]));
			}
		
			print '
				<tr>
					<td>
						'.$RemoveLink.'
						'.CHtml::link($val["shortName"], array('subject/details', 'id' => $val["id"])).'
					</td>
					<td style="text-align: center;">'.$val["semester"].'</td>
					<td style="text-align: center;">'.$val["group"].'</td>
				</tr>
			';
		}
		print '
				</tbody>
			</table>
		';
	}
?>

<h3>Erre a tantárgyra épülő tárgyak</h3>

<?php
	if (count($based_on) == 0) {
		print "<p>Nincs olyan tantárgy, amely erre épülne.</p>";
	}
	else {
		print '
			<table>
				<thead>
					<tr>
						<th>Tantárgy neve</th>
						<th style="text-align: center; width: 50px;">Félév</th>
						<th style="text-align: center; width: 200px;">Tárgycsoport</th>
					</tr>
				</thead>
				<tbody class="list">
		';
		
		foreach ($based_on as $CurrentSubject) {
			print '
				<tr>
					<td>'.CHtml::link($CurrentSubject["shortName"], array('subject/details', 'id' => $CurrentSubject["id"])).'</td>
					<td style="text-align: center;">'.$CurrentSubject["semester"].'</td>
					<td style="text-align: center;">'.$CurrentSubject["group"].'</td>
				</tr>
			';
		}
		
		print '
				</tbody>
			</table>
		';
	}
?>

<h3>Leírás</h3>
<p>
	<?php
		if (Yii::app()->user->getId() && Yii::app()->user->level >= 1)
			print '<a href="#" onclick="EditDescription(\''.$EditDescriptionLink.'\')">[Módosítás]</a><br>';
			
		print empty($data->description) ? "Nincs leírás megadva ehhez a tantárgyhoz" : nl2br($data->description); 
	?>
</p>

<h3>Mit gondolsz erről a tárgyról?</h3>
<div class="fb-comments" data-width="690" data-href="<?php print $FacebookUrl; ?>" data-numposts="5" data-colorscheme="light"></div>

<script language="javascript" type="text/javascript">
	ApplyHover();
</script>