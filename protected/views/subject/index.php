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
			<div class="flash-notice">
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
			</div>
		';
		
		if (Yii::app()->user->level >= 1) {
			print '
				<p>
					<form method="post" action="'.Yii::app()->createUrl('subject/editSubject').'">
						Új tantárgy létrehozása:<br/>
						<input type="text" name="name" placeholder="Tantárgy neve" style="width: 240px;"/>
						<input type="text" name="semester" placeholder="Félév" style="width: 50px;"/>
						<input type="text" name="credits" placeholder="Kreditérték" style="width: 70px;"/>
						'.CHtml::dropDownList('type', '', CHtml::listData($groups, 'group_id', 'group_name')).'
						<input type="submit" value="Mentés"/>
					</form>
				</p>
			';
		}
	}
	else {
		print '
			<div class="flash-success">
				Regisztrálj hozzánk, mert
				<ul>
					<li>megadhatod, mely tárgyakat teljesítetted, és mi megmutatjuk, mit vehetsz fel,</li>
					<li>nyomon követheted a hiányzásaidat, ha a tantárgy nevére kattintasz,</li>
					<li>ha van valami hasznos anyagod, megoszthatod hallgatótársaiddal,</li>
					<li>kiírhatsz ZH, vizsga és konzultációs időpontokat a tantárgyakhoz.</li>
				</ul>
			</div>
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
