<?php
class ThemeFiles {
	public static function getThemeFiles($path){

		$arrThemeFiles = array('css'=>array(),'js'=>array());
	

		// css files to array
		$directory = $path.'/css';
		$scanned_directory = scandir($directory);
		foreach($scanned_directory as $css_file):
			$arrThemeFiles['css'][] = $css_file;
			$arrThemeFiles['css'] = array_diff($arrThemeFiles['css'], array('..','.'));
		endforeach;

		// js files to array
		$directory = $path.'/js';

		$scanned_directory = scandir($directory);
		foreach($scanned_directory as $js_file):
			$arrThemeFiles['js'][] = $js_file;
			$arrThemeFiles['js'] = array_diff($arrThemeFiles['js'], array('..','.'));
		endforeach;

		return $arrThemeFiles;
	}
}