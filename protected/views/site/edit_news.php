<?php

$this->pageTitle=Yii::app()->name . ' - Regisztráció';
$this->breadcrumbs=array(
	'Hír módosítása',
);

?>

<h1>Hír módosítása</h1>

<form method="post" action="<?php print Yii::app()->createUrl("site/editnews", array("id" => $data->news_id)); ?>">
	<table>
		<tr>
			<td class="name">Cím:</td>
			<td><input type="text" name="title" value="<?php print $data->title; ?>" style="width: 600px;"></td>
		</tr>
		<tr>
			<td class="name">Tantárgy:</td>
			<td>
				<select name="subject_id">
					<?php
						$selected = ($data->subject_id == null) ? " selected" : "";
						print '<option value=""'.$selected.'>--- Nincs tantárgyhoz rendelve ---</option>\n';
					
						foreach ($subjects as $subject) {
							$selected = ($data->subject_id == $subject->subject_id) ? " selected" : "";
							print '<option value="'.$subject->subject_id.'"'.$selected.'>'.$subject->name."</option>\n";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="name">Tartalom:</td>
			<td><textarea name="contents" style="width: 600px; height: 150px;"><?php print $data->contents; ?></textarea></td>
		</tr>
	</table>
	
	<input type="submit" value="Mentés" name="saved">
</form>