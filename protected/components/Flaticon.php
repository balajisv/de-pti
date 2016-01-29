<?php

/**
 * A Flaticon CSS betűkészlethez némi segédosztály
 */
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
		'dtd'	=> 'dtd2',
		'asp'	=> 'asp',
		'aspx'	=> 'aspx',
		'bin'	=> 'bin6',
		'bat'	=> 'bat8',
		'bmp'	=> 'bmp2',
		'cab'	=> 'cab',
		'class'	=> 'class3',
		'com'	=> 'com',
		'cfg'	=> 'cfg2',
		'cgi'	=> 'cgi2',
		'csv'	=> 'csv2',
		'db'	=> 'db2',
		'dll'	=> 'dll2',
		'jar'	=> 'jar8',
		'log'	=> 'log2',
		'lua'	=> 'lua',
		'tar'	=> 'tar1',
		'vb'	=> 'vb',
		'xhtml'	=> 'xhtml',
		'xls'	=> 'xls1',
		'xlsx'	=> 'xlsx',
	);

	/**
	 * Regisztrálja a Flaticon-t a weblapon
	 * @param string $CSSDir Az útvonal, ahol a CSS fájlokat tároljuk
	 */
	public static function Register($CSSDir) {
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . $CSSDir."/flaticon.css");
	}
	
	/**
	 * Visszaad egy span tag-et a megadott fájlnév kiterjesztése alapján, amely a kiterjesztéshez tartozó fájlikont jeleníti meg.
	 * @param string $Filename A fájlnév a kiterjesztéssel együtt
	 * @return string A span tag
	 */
	public static function GetByFilename($Filename) {
		$Ext = strtolower(pathinfo($Filename, PATHINFO_EXTENSION));
		
		if (array_key_exists($Ext, self::$Classes))
			return '<span class="flaticon-'.self::$Classes[$Ext].'"></span>';
		else
			return '<span class="flaticon-document325"></span>';
	}
}