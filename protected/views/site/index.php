<?php
/* @var $this SiteController */
$this->pageTitle='A debreceni programtervező informatikus hallgatók közössége - 2011 óta';

FbUtils::AddMetaTags(
	"DE-PTI - A Debreceni Egyetem Programtervező informatikus hallgatóinak közössége",
	Yii::app()->params["domain"] . 'de-pti',
	"Szerezd be a legújabb tananyagokat, értesülj a legfrissebb hírekről, és kövesd nyomon a tantárgyaidat!"
);
?>

<section>
	<div class="container">
		<div class="page-header">
			<h1>Mostanában...</h1>
		</div>

		<?php

		if (Yii::app()->user->getId() && (Yii::app()->user->level >= 1)):
			$URL = Yii::app()->createUrl("site/addnews");
			print '
				<div style="margin-bottom: 10px;">
					<button class="btn btn-md btn-success" onclick="ShowAddNews(\''.$URL.'\')">
						<i class="fa fa-plus-circle"></i>
						Hír közzététele
					</button>
				</div>';
		?>
			
		<script language="javascript">
			var Subjects = [
				<?php
					foreach (Subject::model()->findAll(array('order' => 'name')) as $CurrentSubject) {
						print "{ id: ".$CurrentSubject->subject_id.", name: '".$CurrentSubject->name."' },\n";
					}
				?>
			];
		</script>
			
		<?php
			endif;
		?>

		<ul class="timeline">
			<?php

			$i = 1;
			foreach ($model as $Current) {
				$this->renderPartial('_news', array(
					'data' => $Current,
					'invert_timeline' => $i % 2 == 0
				));
				$i++;
			}

			?>
		</ul>
	</div>
</section>