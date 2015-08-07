<?php

class Flaticon {
	private static $Classes = array(
		'zip'	=> 'zip6',
		'rar'	=> 'rar2',
		'7z'	=> '7z1',
		'xml'	=> 'xml5',
		'pdf'	=> 'pdf19',
		'doc'	=> 'doc2',
		'docx'	=> 'docx',
		'cpp'	=> 'cpp1',
		'gif'	=> 'gif3',
		'jav'	=> 'jar8',
		'jpg'	=> 'jpg3',
		'ps'	=> 'ps',
		'rtf'	=> 'rtf',
		'txt'	=> 'txt2',
		'sql'	=> 'sql3',
	);

	public static function Register($CSSDir) {
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . $CSSDir."/flaticon.css");
	}
	
	public static function GetByFilename($Filename) {
		$Ext = strtolower(pathinfo($Filename, PATHINFO_EXTENSION));
		
		return '<span class="flaticon-'.self::$Classes[$Ext].'"></span>';
	}
}