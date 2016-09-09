<?php

$this->pageTitle = 'Hír módosítása';
$this->breadcrumbs=array(
	'Hír módosítása',
);

?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<form method="post" action="<?php print Yii::app()->createUrl("site/editnews", array("id" => $data->news_id)); ?>">
				<table class="table">
					<tr>
						<td>
							<label for="title">Cím:</label>
						</td>
						<td>
							<input type="text" class="form-control" id="title" name="title" value="<?php print $data->title; ?>">
						</td>
					</tr>
					<tr>
						<td>
							<label for="subject_id">Tantárgy:</label>
						</td>
						<td>
							<select name="subject_id" id="subject_id" class="form-control">
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
						<td>
							<label for="contents">Tartalom:</label>
						</td>
						<td>
							<textarea name="contents" style="min-height: 200px;" id="contents" class="form-control"><?php print $data->contents; ?></textarea>
						</td>
					</tr>
				</table>
				
				<p class="btn-group">
					<button type="submit" class="btn btn-md btn-success" name="saved">
						<i class="fa fa-save"></i>
						Mentés
					</button>
					<a href="<?php print Yii::app()->createUrl('site/index'); ?>" class="btn btn-md btn-danger">
						<i class="fa fa-times"></i>
						Mégse
					</a>
				</p>
			</form>
		</div>
	</div>
</div>