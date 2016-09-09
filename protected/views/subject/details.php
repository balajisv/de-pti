<?php

$this->pageTitle = "A tantárgyról bővebben";

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

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2><?php print $data->name; ?></h2>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 col-md-6">
			<p>
				<?php print $data->credits; ?> kreditértékű,
				<?php print $data->group->group_name; ?> tárgycsoportba tartozó tantárgy,
				<?php print ($data->semester == NULL) ? "nincs megadva ajánlott félév." : $data->semester . ". félévben ajánlott."; ?>
			</p>
			<p>
				Eddig <fb:comments-count href="<?php print $FacebookUrl; ?>"><span class="fa fa-spin fa-refresh"></span></fb:comments-count> vélemény érkezett.
			</p>
		</div>
		
		<div class="col-xs-12 col-md-6 text-align-center">
			<p class="btn-group">
				<?php
					print CHtml::link(
						"Tárgyfa",
						array('subject/dependencytree', 'id' => $data->subject_id),
						array('class' => 'btn btn-primary btn-md')
					);
					
					print CHtml::link(
						sprintf("Tananyagok (%d)", $data->filecount),
						array('file/list', 'id' => $data->subject_id),
						array('class' => 'btn btn-success btn-md')
					);
					
					print CHtml::link(
						sprintf("Események (%d)", $data->eventcount),
						array('event/list', 'id' => $data->subject_id),
						array('class' => 'btn btn-default btn-md')
					);
				?>
			</p>
			<p>
				<div class="fb-send" data-href="<?php print $FacebookUrl; ?>" data-colorscheme="light"></div>
				<div class="fb-like" data-href="<?php print $FacebookUrl; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
			</p>
		</div>
	</div>
	
	<?php 
		if (Yii::app()->user->getId()) {
			print '
				<div class="row">
					<div class="col-xs-12">
						<h3>Hiányzások</h3>
						<p>
							<div id="absenteeism">
								Ebből a tárgyból eddig '. (($Misses == 0) ? 'még nincs hiányzásod - jól csinálod' : "$Misses alkalommal hiányoztál") .'.
							</div>
						</p>
						<p class="btn-group">
							<a class="btn btn-danger btn-md" onclick="IncrementAbsenteeism('.$data->subject_id.')">Hiányoztam</a>
							<a class="btn btn-default btn-md" onclick="ResetAbsenteeism('.$data->subject_id.')">Nullázás</a>
						</p>
					</div>
				</div>
			';
		}
	?>
	
	<div class="row">
		<div class="col-xs-12">
			<h3>Előkövetelmények</h3>
			<?php
				if (Yii::app()->user->getId() && Yii::app()->user->level >= 1):
			?>
			<p>
				<p>
					<form method="post" action="<?php print Yii::App()->createUrl("subject/adddependency", array("id" => $data->subject_id)); ?>">
						Előkövetelmény hozzáadása:<br/>
						<div class="input-group">
							<select name="dependency_id" class="form-control" aria-describedby="subject_add_button">
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
							<span class="input-group-btn" id="subject_add_button">
								<button type="submit" class="btn btn-success">
									<i class="fa fa-plus-circle"></i>
									<span class="hidden-xs">Hozzáadás</span>
								</button>
							</span>
						</div>
					</form>
				</p>
				<?php
					endif;
					
					if (count($dependencies) == 0) {
						print '
							<div class="alert alert-info">
								<i class="fa fa-info-circle"></i>
								Ennek a tárgynak nincs előfeltétele.
							</div>
						';
					}
					else {
						print '
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Tantárgy neve</th>
										<th class="text-align-center" style="width: 50px;">Félév</th>
										<th class="text-align-center" style="width: 200px;">Tárgycsoport</th>
									</tr>
								</thead>
								<tbody>
						';
						foreach ($dependencies as $val) {
							$RemoveLink = "";
							if (Yii::app()->user->getId() && Yii::app()->user->level >= 1) {
								$RemoveLink = CHtml::link(
									'<i class="fa fa-times"></i> <span class="hidden-xs">Eltávolítás</span>',
									array('subject/removedependency', 'id' => $val["dependency_id"]),
									array('class' => 'btn btn-sm btn-danger')
								);
							}
						
							print '
								<tr>
									<td>
										'.$RemoveLink.'
										'.CHtml::link($val["shortName"], array('subject/details', 'id' => $val["id"])).'
									</td>
									<td class="text-align-center">'.$val["semester"].'</td>
									<td class="text-align-center">'.$val["group"].'</td>
								</tr>
							';
						}
						print '
								</tbody>
							</table>
						';
					}
				?>
			</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3>Erre a tantárgyra épülő tárgyak</h3>

			<?php
				if (count($based_on) == 0) {
					print '
						<div class="alert alert-info">
							<i class="fa fa-info-circle"></i>
							Nincs olyan tantárgy, amely erre épülne.
						</div>
					';
				}
				else {
					print '
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Tantárgy neve</th>
									<th class="text-align-center" style="width: 50px;">Félév</th>
									<th class="text-align-center" style="width: 200px;">Tárgycsoport</th>
								</tr>
							</thead>
							<tbody>
					';
					
					foreach ($based_on as $CurrentSubject) {
						print '
							<tr>
								<td>'.CHtml::link($CurrentSubject["shortName"], array('subject/details', 'id' => $CurrentSubject["id"])).'</td>
								<td class="text-align-center">'.$CurrentSubject["semester"].'</td>
								<td class="text-align-center">'.$CurrentSubject["group"].'</td>
							</tr>
						';
					}
					
					print '
							</tbody>
						</table>
					';
				}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3>Leírás</h3>
			<p>
				<?php
					if (Yii::app()->user->getId() && Yii::app()->user->level >= 1)
						print '
							<p>
								<a class="btn btn-primary btn-md" onclick="EditDescription(\''.$EditDescriptionLink.'\')">
									Módosítás
								</a>
							</p>
						';
						
					if (empty($data->description))
						print '
							<div class="alert alert-info">
								<i class="fa fa-info-circle"></i>
								Nincs leírás megadva ehhez a tantárgyhoz.
							</div>
						';
					else
						print nl2br($data->description); 
				?>
			</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3>Mit gondolsz erről a tárgyról?</h3>
			
			<div class="text-align-center">
				<div class="fb-comments" data-width="690" data-href="<?php print $FacebookUrl; ?>" data-numposts="5" data-colorscheme="light"></div>
			</div>
		</div>
	</div>
</div>