<?php

require_once '../set_env.inc.php';
ini_set('display_errors', 'on');

define('DJVUSED', '/home/khutornoy/bin/djvused');
define('DJVUTXT', '/home/khutornoy/bin/djvutxt');

$_ADODB->debug = true;

function disp ($str)
{
    echo $str;
    ob_flush();
    flush();
}

if (isset($_POST['generate']))
{
	$_ADODB->Execute("SET SESSION max_allowed_packet=10000000");
//	$sql = "SELECT id, djvu_file FROM lib_book WHERE djvu_file IS NOT NULL AND djvu_file !='' ORDER BY djvu_file LIMIT ". $_POST['start'] ."," . $_POST['count'];
//	$sql = "SELECT id, djvu_file FROM lib_book WHERE id IN (3,13,14,60,61,62,89,251,378,380) ORDER BY djvu_file LIMIT ". $_POST['start'] ."," . $_POST['count'];
	$sql = "SELECT id, djvu_file FROM lib_book WHERE id IN (3) ORDER BY djvu_file LIMIT ". $_POST['start'] ."," . $_POST['count'];
	$books = $_ADODB->GetAll($sql);

	while (list($k,$v) = each($books)) {

		$text = '';
		$text = shell_exec(DJVUTXT . ' ' . $app_root . '/html/lib/files/' . $v['djvu_file']);
		if ($text) {
			disp(($k + 1) . ' + ' . $v['djvu_file'] . ' ');

			disp(strlen($text) . ' ');
			$text = iconv('UTF-8', 'cp1251', $text);
			disp(strlen($text) . ' ');
			disp(strlen(addslashes($text)) . ' ');
//			echo addslashes($text);
			$sql = 'REPLACE lib_pages_index (book, page, txt) VALUES (' . $v['id'].', 0, \''.addslashes($text).'\')';
			$_ADODB->Execute($sql);

			$pages_number = shell_exec(DJVUSED . ' '.$app_root.'/html/lib/files/'.$v['djvu_file'] . " -e 'n'");
			
			disp($pages_number . '<br>');
			
//			for ($i = 1; $i <= (int)$pages_number; $i++) {
//				$text = '';
//				$text = shell_exec(DJVUTXT . ' --page ' . $i . ' '. $app_root . '/html/lib/files/' . $v['djvu_file']);
//				if ($text) {
//					$text = iconv('UTF-8', 'cp1251', $text);
//					$sql = 'REPLACE lib_pages_index (book, page, txt) VALUES (' . $v['id'].', ' . $i . ', \''.addslashes($text).'\')';
//					$_ADODB->Execute($sql);
//					disp('+');
//				} else {
//					disp('-');
//				}
//				if ($i % 10 == 0) {
//					disp('&nbsp;');
//				}
//				if ($i % 100 == 0) {
//					disp('<br/>');
//				}
//			}
		} else {
			disp(($k + 1) . ' - ' . $v['djvu_file']);
		}

		disp('<br><hr><br>');
	}
} else {
	$_SMARTY->display('lib/fulltext.tpl');
}
?>
