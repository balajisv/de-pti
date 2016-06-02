<?php

function isMobile() {
	$Find = array(
		"android",
		"iphone",
		"ipad",
		"mobile",
		"windows phone"
	);
	
	$UserAgent = strtolower($_SERVER["HTTP_USER_AGENT"]);
	
	foreach ($Find as $MobileUserAgent) {
		if (strpos($UserAgent, strtolower($MobileUserAgent)) !== false) {
			return true;
		}
	}
	
	return false;
}

if (isMobile() && count($_GET) == 0) {
	header("Location: m/index.html");
}
else {
	// change the following paths if necessary
	$yii=dirname(__FILE__).'/framework/yii.php';
	$config=dirname(__FILE__).'/protected/config/main.php';

	// remove the following lines when in production mode
	//defined('YII_DEBUG') or define('YII_DEBUG',true);
	// specify how many levels of call stack should be shown in each log message
	//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

	header("Content-Type: text/html; charset=UTF-8");

	require_once($yii);
	Yii::createWebApplication($config)->run();
}