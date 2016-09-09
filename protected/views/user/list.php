<?php

$this->pageTitle = "Regisztrált tagok";
$this->breadcrumbs=array(
	"Regisztrált tagok",
);

?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-content-vertical-middle">
				<thead>
					<tr>
						<th>Felhasználónév</th>
						<th>E-Mail cím</th>
						<th class="text-align-center">Szint</th>
						<th class="text-align-center">Regisztrált</th>
						<th class="text-align-center">Műveletek</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					
					foreach ($data as $Current) {
						$this->renderPartial('_list_row', array(
							'data' => $Current,
						));
					}
					
					?>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 text-align-center">
			<?php

			$this->widget('CLinkPager', array(
				'pages' => $pager,
			));

			?>
		</div>
	</div>
</div>