<?php
	$this->pageTitle = "A profilom";
	
	$UserLevels = array(
		0 => array(
			"name" => "Általános jogosultságú tag",
			"rights" => array(
				"Tananyagot tölthetsz fel",
				"Az általad feltöltött tananyagokat módosíthatod és törölheted",
				"Eseményeket írhatsz ki és törölhetsz"
			)
		),
		1 => array(
			"name" => "Szerkesztői jogosultságú tag",
			"rights" => array(
				"Híreket írhatsz ki, módosíthatsz és törölhetsz",
				"Új tantárgyakat vehetsz fel a meglévő tárgycsoportokba"
			)
		),
		2 => array(
			"name" => "Tulajdonos jogosultságú tag",
			"rights" => array(
				"Megtekintheted a regisztrált felhasználók listáját",
				"Megtekintheted bármely tag teljesített tárgyait",
				"Bármelyik felhasználó által feltöltött tananyagot módosíthatod és törölheted",
				"Módosíthatod a regisztrált felhasználók jogosultsági szintjét"
			)
		)
	);
?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2>
				<i class="fa fa-user"></i>
				<?php print $model->username; ?>
			</h2>
			<p>
				<?php print $UserLevels[$model->level]["name"]; ?>
			</p>
		</div>
	</div>
	
	<?php
		if (!Yii::app()->user->isGuest && Yii::app()->user->level >= 2) {
			print CHtml::link(
				'<i class="fa fa-users"></i> Regisztrált tagok listája',
				Yii::app()->createUrl('user/list'),
				array(
					'class' => 'btn btn-info btn-sm'
				)
			);
		}
	?>
	
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<h3>Általános információk rólam</h3>
			<p>
				<table class="table">
					<tbody>
						<tr>
							<td>E-mail címed:</td>
							<td><?php print $model->email; ?></td>
						</tr>
						<tr>
							<td>Ekkor regisztráltál hozzánk:</td>
							<td><?php print date("Y. m. d. H:i:s", strtotime($model->date_created)); ?></td>
						</tr>
						<tr>
							<td colspan="2">
								<?php print $model->CompletedCredits; ?>
								szakmai kreditet szereztél eddig
								<?php print $model->CompletedSubjectCount; ?>
								tantárgy teljesítésével.
							</td>
						</tr>
					</tbody>
				</table>
			</p>
		</div>
		
		<div class="col-xs-12 col-sm-6">
			<h3>Miket csinálhatok az oldalon?</h3>
			<p>
				<ul>
					<?php
						for ($i = 0; $i <= $model->level; $i++) {
							foreach ($UserLevels[$i]["rights"] as $Right) {
								print sprintf('<li>%s</li>', $Right);
							}
						}
					?>
				</ul>
			</p>
		</div>
	</div>
</div>