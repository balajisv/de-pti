<?php

$this->pageTitle=Yii::app()->name . ' - Felhasználók';
$this->breadcrumbs=array(
	'Felhasználók',
);

?>

<h1>Felhasználók</h1>

<table>
	<thead>
		<tr>
			<th>Felhasználónév</th>
			<th>E-Mail cím</th>
			<th style="text-align: center;">Szint</th>
			<th style="text-align: center;">Regisztrált</th>
			<th>Műveletek</th>
		</tr>
	</thead>
	
	<tbody class="list">
		<?php
		
		foreach ($data as $Current) {
			$this->renderPartial('_list_row', array(
				'data' => $Current,
			));
		}
		
		?>
	</tbody>
</table>

<script language="javascript" type="text/javascript">
	ApplyHover();
</script>

<?php

$this->widget('CLinkPager', array(
	'pages' => $pager,
));

?>