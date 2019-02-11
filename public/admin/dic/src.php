<?php
require_once '../set_env.inc.php';
require_once 'PHP/Compat.php';
PHP_Compat::loadFunction('array_combine');
//$_ADODB->debug = true;
//print_r($_REQUEST);

if ($_POST['src']) {
	$request = process_post_input();

	if (empty ($request['title'])) {
		$_ERROR_MESSAGE[] = 'Не введен заголовок';
	}
	if (empty ($request['code'])) {
		$_ERROR_MESSAGE[] = 'Не введен код источника';
	}
	$sql = 'SELECT COUNT(*) FROM dic_src WHERE code=\''.$request['code'].'\' AND id!='.$request['id'];
	$cnt = $_ADODB->GetOne($sql);
	if ($cnt > 0) {
		$_ERROR_MESSAGE[] = 'Источник с таким кодом уже существует';
	}
	
	if (!empty ($_POST['save']) && !empty ($request['id']) && count($_ERROR_MESSAGE) == 0) {
		// редактирование
		$sql = 'SELECT * FROM dic_src WHERE id='.$request['id'];
		$rs = $_ADODB->Execute($sql);
		if ($sql = $_ADODB->GetUpdateSQL($rs, $request)) {
			$_ADODB->Execute($sql);
		}
		$msg = 'update';
	}
	elseif (!empty ($_POST['save']) && empty ($_REQUEST['id']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'SELECT * FROM dic_src WHERE id=-1';
		$rs = $_ADODB->Execute($sql);
		if ($sql = $_ADODB->GetInsertSQL($rs, $request)) {
			if ($_ADODB->Execute($sql)) {
                $request['id'] = $_ADODB->Insert_ID();
			} else {
				$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
			}
		} else {
			$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
		}
		$msg = 'insert';
	}
	elseif (!empty ($_POST['delete']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'DELETE FROM dic_src WHERE id='.$_REQUEST['id'];
		$_ADODB->Execute($sql);
		$sql = 'DELETE FROM dic_comp_src WHERE src='.$_REQUEST['id'];
		$_ADODB->Execute($sql);
		$sql = 'DELETE FROM dic_wording WHERE src='.$_REQUEST['id'];
		$_ADODB->Execute($sql);
        $msg = 'delete';
	}
//	if (count($_ERROR_MESSAGE) == 0) {
//		Header('Location: /admin/dic/src.php?msg='.$msg.'&id='.$request['id']);
//		exit;
//	}
} else {
	if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
		$sql = 'SELECT * FROM dic_src WHERE id='.$_REQUEST['id'];
		$request = $_ADODB->GetRow($sql);
	}
	if ($msg == "insert") {
		$_MESSAGE = "Информация добавлена";
	}
	elseif ($msg == "update") {
		$_MESSAGE = "Изменения сохранены";
	}
	elseif ($msg == "delete") {
		$_MESSAGE = "Информация удалена";
	}
}

$_SMARTY->assign($request);
$_SMARTY->assign('type_options', array('textbook' => 'Учебник', 'aid' => 'Уч.пособие', 'book' => 'Книга', 'person' => 'Автор', 'inet' => 'Интернет-ресурс', 'other' => 'Другое'));
$_SMARTY->assign('grade_options', array_combine(range(1, 11), range(1, 11)));
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('dic/src.tpl');
?>