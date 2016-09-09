<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user_list.js', CClientScript::POS_HEAD);

$this->pageTitle = $user->username . " teljesített tantárgyai";
$this->breadcrumbs=array(
	'Felhasználók',
);

?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<p>
				<?php print "Összesen $creditsCompleted szakmai kredit teljesítve."; ?>
			</p>			
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-striped table-content-vertical-middle">
				<thead>
					<tr>
						<th>Tantárgy</th>
						<th class="text-align-center" style="width: 20px;">Félév</th>
						<th class="text-align-center" style="width: 50px;">Kredit</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					
					foreach ($subjects as $CurrentSubject) {
						print '
							<tr>
								<td>'.$CurrentSubject->shortName.'</td>
								<td class="text-align-center" >'.$CurrentSubject->semester.'</td>
								<td class="text-align-center" >'.$CurrentSubject->credits.'</td>
							</tr>
						';
					}
					
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>


