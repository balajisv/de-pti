<?php
/* @var $this Controller */ 

$SubjectsSubmenu = array(
	array(
		'label' => 'Összes tantárgy',
		'url' => array('subject/index'),
	),
	array(
		'label' => '',
		'url' => '',
		'itemOptions' => array(
			'role' => 'separator',
			'class' => 'divider'
		)
	)
);

foreach (SubjectGroup::model()->findAll(array('order' => 'group_id')) as $SubjectGroup) {
	$SubjectsSubmenu[] = array(
		'label' => $SubjectGroup->group_name,
		'url' => array("subject/index", 'group_id' => $SubjectGroup->group_id)
	);
}

?>
<!DOCTYPE html>
<html lang="hu">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	
		<meta property="og:locale" content="hu_HU" />
		<meta property="og:site_name" content="DE-PTI" />
		<meta property="og:type" content="website" />
		<meta property="og:image" content="http://users.atw.hu/de-pti/images/fbimg.png" />
		<meta property="fb:admins" content="100004365541257"/>
	
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	
		<!-- jQuery -->
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
		
		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		
		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
		<script src="https://use.fontawesome.com/10d8b55f23.js"></script>
		
		<!-- Custom code -->
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/timeline.css">
		<script type="text/javascript" src="js/template.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript" src="js/cookie.js"></script>

		<?php 
			//jQuery UI
			Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
			Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
			
			//jQuery TimePicker plugin
			Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/css/jquery-timepicker.css');
			Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery-addons/timepicker.js', CClientScript::POS_HEAD);
			
		?>

		<title><?php echo CHtml::encode($this->pageTitle); ?> - DE-PTI</title>
	</head>

	<body<?php print Yii::app()->params["bodyClass"]; ?>>
		<!-- Facebook SDK -->
		<div id="fb-root"></div>
		<script>
			(
				function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					
					if (d.getElementById(id))
						return;
					
					js = d.createElement(s);
					js.id = id;
					js.src = "//connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v2.7";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk')
			);
		</script>
	
		<!--<div class="website-notification text-align-center" id="cookie-warning">
			<div class="col-xs-12">
				<p>
					Ez a webhely is használ sütiket.
				</p>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-info">
						<i class="fa fa-question"></i>
						Miért is?
					</button>
					<button type="button" class="btn btn-success" onclick="$('#cookie-warning').hide();">
						<i class="fa fa-check"></i>
						Rendben
					</button>
				</div>
			</div>
		</div>-->
	
		<nav class="navbar navbar-default navbar-fixed-top nav-unscrolled">
			<div class="container-fluid">
				<!-- Brand and toggle -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">DE-PTI</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<?php 
						$this->widget('zii.widgets.CMenu', array(
							'htmlOptions' => array(
								"class" => "nav navbar-nav"
							),
							'items'=>array(
								array('label'=>'Kezdőlap', 'url'=>array('/site/index')),
								array(
									'label'=>'Tantárgyak <span class="caret"></span>',
									'url'=>'',
									'items' => $SubjectsSubmenu,
									'itemOptions' => array('class' => 'dropdown'),
									'linkOptions' => array(
										'class' => 'dropdown-toggle',
										'data-toggle' => 'dropdown',
										'role' => 'button',
										'aria-haspopup' => "true",
										'aria-expanded' => "false"
									),
									'submenuOptions' => array('class' => 'dropdown-menu')
								),
								array('label'=>'Események', 'url'=>array('/event/index')),
								array('label'=>'Rólunk', 'url'=>array('/site/page', 'view'=>'about')),
								array('label'=>'Oldalak', 'url'=>array('/site/page', 'view'=>'links')),
								array('label'=>'Tudnivalók', 'url'=>array('/site/page', 'view'=>'goodtoknow')),
							),
							'encodeLabel' => false
						)); 
					?>
					
					<ul class="nav navbar-nav navbar-right">
						<?php
							if (Yii::app()->user->isGuest) {
								$LoginLink = Yii::app()->createUrl('user/login');
								print '<li><a href="'.$LoginLink.'">Bejelentkezés</a></li>';
							}
							else {
								$LogoutLink = Yii::app()->createUrl('user/logout');
								print '
									<li><a href="'.Yii::app()->createUrl('user/profile', array('id' => Yii::app()->user->getId())).'">'.Yii::app()->user->name.'</a></li>
									<li><a href="'.$LogoutLink.'">Kijelentkezés</a></li>
								';
							}
						?>
					</ul>
				</div>
			</div>
		</nav>
		
		<?php print $content; ?>
		
		<footer>
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-8 col-sm-4">
						Készítette:
						<a href="https://www.facebook.com/sinkutamas" target="_blank">Sinku Tamás</a>
					</div>
					<div class="col-xs-4 col-sm-8 text-align-right social">
						<a href="https://www.facebook.com/deptibsc" class="fa fa-facebook-official" target="_blank" title="DE-PTI a Facebookon">
							<span class="sr-only">DE-PTI a Facebookon</span>
						</a>
						<a href="https://github.com/std66/de-pti" class="fa fa-github" target="_blank" title="Nyílt forráskódú webhely - Kattints ide és nézd meg a GitHubon.">
							<span class="sr-only">Nyílt forráskódú webhely - Kattints ide és nézd meg a GitHubon.</span>
						</a>
					</div>
				</div>
			</div>
		</footer>
		
		<!-- Old dialog box -->
		<div id="messageBox" style="display: none;">
			<div id="mbText" style="font-size: 8pt;"></div>
		</div>
		
		<!-- New Bootstrap dialog box -->
		<div id="bootstrapMessageBox" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="messageBox-Title"></h4>
					</div>
					
					<div class="modal-body" id="messageBox-Content">
						
					</div>
					
					<div class="modal-footer" id="messageBox-Buttons">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
