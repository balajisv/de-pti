<?php

/**
 * Néhány Facebook-ot megsegítő függvény és eljárás.
 */
class FbUtils {
	/**
	 * Regisztrálja az FB API számára szükséges meta tag-eket.
	 * @param string $Title A webhely címe
	 * @param string $Url A webhely URL-címe
	 * @param string $Description A webhely rövid leírása
	 */
	public static function AddMetaTags($Title, $Url, $Description) {
		Yii::app()->clientScript->registerMetaTag($Title, null, null, array('property' => 'og:title'));
		Yii::app()->clientScript->registerMetaTag($Url, null, null, array('property' => 'og:url'));
		Yii::app()->clientScript->registerMetaTag($Description, null, null, array('property' => 'og:description'));
	}
}