<?php
/* @var $this Controller */ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="hu" lang="hu">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="hu" />
	<meta property="og:locale" content="hu_HU" />
	<meta property="og:site_name" content="DE-PTI" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="http://users.atw.hu/de-pti/images/fbimg.png" />
	<meta property="fb:admins" content="100004365541257"/>
	

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<?php 
		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
		Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/cookie.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/main.js', CClientScript::POS_HEAD);
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div id="fb-root"></div>
	<script>
		(
			function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v2.0";
			  fjs.parentNode.insertBefore(js, fjs);
			}
			(document, 'script', 'facebook-jssdk')
		);
	</script>

	<div class="container" id="page">
		<div id="header">
			<div id="logo">
				<?php echo CHtml::encode(Yii::app()->name); ?>
				<div style="font-size: 8pt;">Programtervező informatikusok közössége - Debreceni Egyetem Informatikai Kar</div>
			</div>
		</div>

		<div id="mainmenu">
			<?php 
				$this->widget('zii.widgets.CMenu', array(
					'items'=>array(
						array('label'=>'Kezdőlap', 'url'=>array('/site/index')),
						array('label'=>'Tantárgyak', 'url'=>array('/subject/index')),
						array('label'=>'Események', 'url'=>array('/event/index')),
						array('label'=>'Rólunk', 'url'=>array('/site/page', 'view'=>'about')),
						array('label'=>'Oldalak', 'url'=>array('/site/page', 'view'=>'links')),
						array('label'=>'Tudnivalók', 'url'=>array('/site/page', 'view'=>'goodtoknow')),
					),
				)); 
			?>
		</div>
		
		<div class="col-container">
			<div class="col-left">
				<?php
					$this->renderPartial("//layouts/loginbox");
					$this->renderPartial("//layouts/leftbox", array(
						"Title" => "Neptun",
						"Content" => '
							<div style="text-align: center;">
								<a href="https://www-1.neptun.unideb.hu/hallgato" target="blank">1. szerver</a><br>
								<a href="https://www-2.neptun.unideb.hu/hallgato" target="blank">2. szerver</a><br>
								<a href="https://www-3.neptun.unideb.hu/hallgato" target="blank">3. szerver</a><br>
								<a href="http://neptun.unideb.hu/login.php?user=student" target="blank">Mindegy</a>
							</div>
						'
					));
					$this->renderPartial("//layouts/leftbox", array(
						"Title" => "Ajánlj ismerőseidnek!",
						"Content" => '
							<div class="fb-like" data-href="http://users.atw.hu/de-pti" data-layout="box_count" data-action="recommend" data-show-faces="false" data-share="true"></div>
						'
					));
					$this->renderPartial("//layouts/leftbox", array(
						"Title" => "Facebook",
						"Content" => '
							<div class="fb-like-box" data-href="https://www.facebook.com/deptibsc" data-width="180" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
						'
					));
				?>
			</div>
			
			<div class="col-right">
			<?php /*
				if(isset($this->breadcrumbs)) {
					$this->widget('zii.widgets.CBreadcrumbs', array(
						'links'=>$this->breadcrumbs,
					)); 
				}*/
			?>

			<?php
				if (Yii::app()->params['underDeveloping']) {
					print '
						<div class="flash-error" style="margin: 10px 20px;">
							<b>Figyelem!</b> A webhely jelenleg fejlesztés alatt áll. Előfordulhat, hogy bizonyos funkciók nem megfelelően
							vagy egyáltalán nem működnek. A használatából keletkezett károkért a webhely tulajdonosa semmilyen
							felelősséget nem vállal.
						</div>
					';
				}
			?>

			<?php echo $content; ?>
		</div>
		</div>
		
		<div class="clear"></div>

		<div id="footer">
			A webhely használatával Ön automatikusan elfogadja a 
			<?php print CHtml::link('webhely nyilatkozatait', array('site/page', 'view' => 'law')); ?>.<br/>
			Copyright &copy; <?php echo date('Y'); ?>: TomiSoft
		</div>
		
		<!-- Dialog box -->
		<div id="messageBox" style="display: none;">
			<div id="mbText" style="font-size: 8pt;"></div>
		</div>

	</div>

</body>
</html>
