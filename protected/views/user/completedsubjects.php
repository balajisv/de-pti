<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user_list.js', CClientScript::POS_HEAD);

$this->pageTitle=Yii::app()->name . ' - Felhasználók';
$this->breadcrumbs=array(
	'Felhasználók',
);

?>

<h1><?php print $user->username; ?> teljesített tantárgyai</h1>

<p>
	<?php print "Összesen $creditsCompleted kredit"; ?>
</p>

<table>
	<thead>
		<tr>
			<th>Tantárgy</th>
			<th style="text-align: center; width: 20px;">Félév</th>
			<th style="text-align: center; width: 50px;">Kredit</th>
		</tr>
	</thead>
	
	<tbody class="list">
		<?php
		
		foreach ($subjects as $CurrentSubject) {
			print '
				<tr>
					<td>'.$CurrentSubject->shortName.'</td>
					<td style="text-align: center;">'.$CurrentSubject->semester.'</td>
					<td style="text-align: center;">'.$CurrentSubject->credits.'</td>
				</tr>
			';
		}
		
		?>
	</tbody>
</table>

<script language="javascript" type="text/javascript">
	ApplyHover();
</script>