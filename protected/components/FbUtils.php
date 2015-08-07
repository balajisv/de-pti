<?php

class FbUtils {
	public static function AddMetaTags($Title, $Url, $Description) {
		Yii::app()->clientScript->registerMetaTag($Title, null, null, array('property' => 'og:title'));
		Yii::app()->clientScript->registerMetaTag($Url, null, null, array('property' => 'og:url'));
		Yii::app()->clientScript->registerMetaTag($Description, null, null, array('property' => 'og:description'));
	}
}