<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Hírek - http://www.inf.unideb.hu';

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/news_deik_header.js', CClientScript::POS_HEAD);
?>

<h1>Hírek</h1>

<div style="margin-bottom: 10px;">
	<b>Hírforrás:</b>
	<?php echo CHtml::link('DE-PTI', array('site/index')); ?> |
	inf.unideb.hu
</div>

<div class="flash-error">
	<b>Figyelem!</b> A tartalmat nem a <?php print Yii::app()->name; ?> szolgáltatja. A webhely üzemeltetője
	nem vállal felelősséget a külső webhelyekről letöltött adatok által okozott károkért, továbbá nem garantálja
	azon tartalmak pontosságát és megbízhatóságát. A szolgáltatás használatával Ön tudomásul veszi, hogy saját
	felelősségére tekinti meg ezt az oldalt.
</div>

<div id="contents"></div>

<div id="url_warning" title="Idegen hivatkozás" style="display: none;">
	<p>
		<b>Figyelem!</b> A külső weblapokról származó hivatkozások veszélyesek lehetnek.
		Ennek ellenére megnyitja a hivatkozást?<br/><br/>
		<span id="url"></span>
	</p>
</div>

<script type="text/javascript" src="js/news_deik.js"></script>