<?php
/* @var $this CourseController */

$this->pageTitle='Tantárgyak';

$this->breadcrumbs=array(
	'Tantárgyak',
);
?>

<div class="container">
	

<?php
	if (Yii::app()->user->getId()) {
		print '
			<div class="row">
				<div class="col-xs-12">
					<div class="alert alert-info text-align-justify" id="completesubject_notice" style="display: none;">
						<p>
							<i class="fa fa-info-circle"></i>
							Lehetősége van bejelölni azokat a tantárgyakat, amelyeket már teljesített. Így az
							oldal ki fogja jelölni azokat a tantárgyakat, amelyeknek teljesíti az előfeltételeit, vagy
							nincs előfeltétele. Ehhez használja a Telj. oszlopban lévő jelölőnégyzeteket.
							<br/>
							<b>Megjegyzés:</b>
							<ul>
								<li>
									Amennyiben olyan tárgyat jelöl be, amelyeknek további előfeltételei vannak,
									azokat az oldal automatikusan fel fogja venni a teljesített tantárgyak közé.
								</li>
								<li>
									Amennyiben egy olyan tárgy mellől veszi ki a jelölést, amit már teljesített,
									az összes rá épülő tantárgy is eltávolításra kerül.
								</li>
							</ul>
						</p>
						
						<p>
							<button onclick="CookieHide(\'completesubject_notice\')" class="btn btn-sm btn-primary">
								Rendben
							</button>
						</p>
					</div>
					<script type="text/javascript">
						CheckDisplay("completesubject_notice");
					</script>
				</div>
			</div>
		';
		
		if (Yii::app()->user->level >= 1) {
			print '
				<div class="row">
					<div class="col-xs-12">
						<p>
							<button class="btn btn-md btn-success" onclick="newSubject()">
								<i class="fa fa-plus-circle"></i>
								Új tantárgy
							</button>
						</p>
					</div>
				</div>
			';
			
			$SubjectGroups = array();
			foreach ($groups as $CurrentGroup) {
				$SubjectGroups[] = sprintf('[%d, "%s"]', $CurrentGroup->group_id, $CurrentGroup->group_name);
			}
			
			$result = implode(',', $SubjectGroups);
			print '
				<script type="text/javascript">
					function newSubject() {
						var groups = [' . $result . '];
						ShowNewSubjectDialog(groups);
					}
				</script>
			';
		}
	}
	else {
		print '
			<div class="row">
				<div class="col-xs-12">
					<div class="alert alert-info" id="why_register" style="display: none;">
						<p>
							<i class="fa fa-info-circle"></i>
							Regisztrálj hozzánk, mert
							<ul>
								<li>megadhatod, mely tárgyakat teljesítetted, és mi megmutatjuk, mit vehetsz fel,</li>
								<li>nyomon követheted a hiányzásaidat, ha a tantárgy nevére kattintasz,</li>
								<li>ha van valami hasznos anyagod, megoszthatod hallgatótársaiddal,</li>
								<li>kiírhatsz ZH, vizsga és konzultációs időpontokat a tantárgyakhoz.</li>
							</ul>
						</p>
						<p>
							<button onclick="CookieHide(\'why_register\')" class="btn btn-sm btn-primary">
								Elrejtés
							</button>
						</p>
					</div>
					<script type="text/javascript">
						CheckDisplay("why_register");
					</script>
				</div>
			</div>
		';
	}
?>

<table class="table table-striped table-content-vertical-middle">
	<thead>
		<tr>
			<?php $Cols = 4; ?>
			<th class="text-align-center">Félév</th>
			<?php if (Yii::app()->user->getId()): $Cols++; ?>
				<th style="width: 16px; text-align: center;">Telj.</th>
			<?php endif; ?>
			<th>Tantárgy</th>
			<th class="text-align-center">Kredit</th>
			<th class="text-align-center">Műveletek</th>
		</tr>
	</thead>
	
	<tbody>

<?php
	foreach ($groups as $CurrentGroup) {
		$this->renderPartial('_listgroup', array(
			'GroupName' => $CurrentGroup->group_name,
			'Subjects' => $CurrentGroup->subjects,
			'completedSubjects' => $completedSubjects,
			'completableSubjects' => $completableSubjects,
			'TableColumns' => $Cols
		));
	}
?>
	</tbody>
</table>

		</div>
	</div>
</div>