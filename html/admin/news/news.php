<?php
require_once '../set_env.inc.php';
//$_ADODB->debug = true;
//print_r($_REQUEST);

if ($_POST['news']) {
	$request = process_post_input();

	if (empty ($request['title'])) {
		$_ERROR_MESSAGE[] = 'ГЌГҐ ГўГўГҐГ¤ГҐГ­ Г§Г ГЈГ®Г«Г®ГўГ®ГЄ';
	}

	if (!empty ($_POST['save']) && !empty ($request['id']) && count($_ERROR_MESSAGE) == 0) {
		// Г°ГҐГ¤Г ГЄГІГЁГ°Г®ГўГ Г­ГЁГҐ
		$sql = 'SELECT * FROM news WHERE id='.$request['id'];
		$rs = $_ADODB->Execute($sql);
		if ($sql = $_ADODB->GetUpdateSQL($rs, $request)) {
			$_ADODB->Execute($sql);
		}
		$msg = 'update';
	}
	elseif (!empty ($_POST['save']) && empty ($_REQUEST['id']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'SELECT * FROM news WHERE id=-1';
		$rs = $_ADODB->Execute($sql);
		if ($sql = $_ADODB->GetInsertSQL($rs, $request)) {
			if ($_ADODB->Execute($sql)) {
                $request['id'] = $_ADODB->Insert_ID();
                $sql = 'UPDATE news SET ord='.$request['id'].' WHERE id='.$request['id'];
                $_ADODB->Execute($sql);
			} else {
				$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
			}
		} else {
			$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
		}
		$msg = 'insert';
	}
	elseif (!empty ($_POST['delete']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'DELETE FROM news WHERE id='.$_REQUEST['id'];
		$_ADODB->Execute($sql);
        $msg = 'delete';
	}
	if (count($_ERROR_MESSAGE) == 0) {
		Header('Location: /admin/news/news.php?msg='.$msg.'&id='.$request['id']);
		exit;
	}
} else {
	if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
		$sql = 'SELECT * FROM news WHERE id='.$_REQUEST['id'];
		$request = $_ADODB->GetRow($sql);
	}
	if ($msg == "insert") {
		$_MESSAGE = "Г€Г­ГґГ®Г°Г¬Г Г¶ГЁГї Г¤Г®ГЎГ ГўГ«ГҐГ­Г ";
	}
	elseif ($msg == "update") {
		$_MESSAGE = "Г€Г§Г¬ГҐГ­ГҐГ­ГЁГї Г±Г®ГµГ°Г Г­ГҐГ­Г»";
	}
	elseif ($msg == "delete") {
		$_MESSAGE = "Г€Г­ГґГ®Г°Г¬Г Г¶ГЁГї ГіГ¤Г Г«ГҐГ­Г ";
	}
}

if (empty ($request['date'])) {
	$request['date'] = date("Y-m-d");
}
$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('news/news.tpl');
?>