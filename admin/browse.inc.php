<?php


/*
 * Created on 24.01.2005
 *
 */

function browse_dir($dir, $root_dir = '', $filter = '') {
	$file_filters = array ('djvu' => array ('djvu', 'djv'), 'ps' => array ('ps'), 'pdf' => array ('pdf'), 'html' => array ('html', 'htm'), 'tex' => array ('tex'),);
	if (empty ($root_dir)) {
		$root_dir = $_SERVER['DOCUMENT_ROOT'];
	}
	$dh = opendir($root_dir.$dir);
	while (false !== ($filename = readdir($dh))) {

		if (is_dir($root_dir.$dir.$filename)) {
			if (!(realpath($root_dir.$dir) == realpath($root_dir) && $filename == '..'))
				$files['dirs'][] = $filename;
		} else {
			$path_parts = pathinfo($filename);
			if (empty ($filter) || in_array($path_parts["extension"], $file_filters[$filter]))
				$files['files'][] = $filename;
		}
	}

	@ sort($files['dirs']);
	@ sort($files['files']);
	return $files;
}
?>





