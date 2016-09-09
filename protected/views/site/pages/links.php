<?php
/* @var $this SiteController */

$this->pageTitle = 'Hasznos oldalak';
$this->breadcrumbs=array(
	'Oldalak',
);

function DisplayBox($Title, $Content, $ImageURL, $SiteURL) {
	print sprintf('
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail">
				<img src="%s" width="242" height="200">
				<div class="caption">
					<h3>%s</h3>
					<p>
						%s
					</p>
					<p>
						<a href="%s" target="blank" class="btn btn-primary" role="button">
							<i class="fa fa-external-link-square"></i>
							Ugrás
						</a>
					</p>
				</div>
			</div>
		</div>
	', $ImageURL, $Title, $Content, $SiteURL);
}

?>

<div class="container">
	<div class="row">
		<?php
			DisplayBox(
				"Régi DE-PTI",
				"A régi DE-PTI oldal másolata. Nézd meg, milyenek voltunk az indulás pillanatában!",
				"images/siteimage_old-depti.png",
				"http://tomisoft.site90.net/de-pti/old/index9f9a.html"
			);
			
			DisplayBox(
				"DE-MI",
				"A Debreceni Egyetem mérnökinformatikus hallgatóinak közössége.",
				"images/siteimage_de-mi.png",
				"http://users.atw.hu/de-mi"
			);
			
			DisplayBox(
				"Neptun",
				"A Debreceni Egyetem Neptun rendszerének hallgatói oldala.",
				"images/siteimage_neptun.png",
				"http://neptun.unideb.hu/login.php?user=student"
			);
		?>
		
	</div>
	<div class="row">
		
		<?php	
			DisplayBox(
				"DE Informatikai Kar",
				"A Debreceni Egyetem Informatikai karának honlapja.",
				"images/siteimage_inf-unideb.png",
				"http://w1.inf.unideb.hu"
			);
			
			DisplayBox(
				"PTI Tárgyfa",
				"A programtervező informatikus BSc. képzés tárgyfája.",
				"images/siteimage_thaimasszazs-targyfa.png",
				"http://thaimasszazsiskola.hu/targyfelvetel.php"
			);
		?>
	</div>
</div>