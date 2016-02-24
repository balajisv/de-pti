<?php
/* @var $this CourseController */

$this->pageTitle=Yii::app()->name . ' - Tantárgyak';

$this->breadcrumbs=array(
	'Tantárgyak',
);
?>
<h1>Tantárgyak</h1>

<?php
	if (Yii::app()->user->getId()) {
		print '
			<div class="flash-notice" id="completesubject_notice" style="display: none;">
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
				<input type="button" onclick="CookieHide(\'completesubject_notice\')" value="Megértettem">
			</div>
			<script type="text/javascript">
				CheckDisplay("completesubject_notice");
			</script>
		';
		
		if (Yii::app()->user->level >= 1) {
			print '
				<p>
					<input type="button" value="Új tantárgy" onclick="newSubject()">
				</p>
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
			<div class="flash-success" id="why_register" style="display: none;">
				Regisztrálj hozzánk, mert
				<ul>
					<li>megadhatod, mely tárgyakat teljesítetted, és mi megmutatjuk, mit vehetsz fel,</li>
					<li>nyomon követheted a hiányzásaidat, ha a tantárgy nevére kattintasz,</li>
					<li>ha van valami hasznos anyagod, megoszthatod hallgatótársaiddal,</li>
					<li>kiírhatsz ZH, vizsga és konzultációs időpontokat a tantárgyakhoz.</li>
				</ul>
				<input type="button" onclick="CookieHide(\'why_register\')" value="Ezt nem akarom többé látni">
			</div>
			<script type="text/javascript">
				CheckDisplay("why_register");
			</script>
		';
	}
	
	foreach ($groups as $CurrentGroup) {
		$this->renderPartial('_listgroup', array(
			'GroupName' => $CurrentGroup->group_name,
			'Subjects' => $CurrentGroup->subjects,
			'completedSubjects' => $completedSubjects,
			'completableSubjects' => $completableSubjects,
		));
	}
?>

<script language="javascript" type="text/javascript">
	ApplyHover();
</script>
