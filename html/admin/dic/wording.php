<?php
require_once '../set_env.inc.php';
require_once 'tex.inc.php';

if ($_POST['def']) {
	$request = process_post_input();

	if (empty ($request['wording']) && $request['type'] != 'formula') {
		$_ERROR_MESSAGE[] = 'Не введено определение';
	}

	if (!empty ($request['src_code'])) {
		$sql = 'SELECT id FROM dic_src WHERE code=\''.$request['src_code'].'\'';
		$src_id = $_ADODB->GetOne($sql);
		if ($src_id <= 0) {
			$_ERROR_MESSAGE[] = 'Неизвестный код источника';
		} else {
			$request['src'] = $src_id;
		}
	}

	if (!empty ($_POST['save']) && !empty ($request['id']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'SELECT * FROM dic_wording WHERE id='.$request['id'];
		$rs = $_ADODB->Execute($sql);
		if ($sql = $_ADODB->GetUpdateSQL($rs, $request)) {
			$_ADODB->Execute($sql);
			$request['close'] = 1;
		}
		$msg = 'update';
	}
	elseif (!empty ($_POST['save']) && empty ($_REQUEST['id']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'SELECT * FROM dic_wording WHERE id=-1';
		$rs = $_ADODB->Execute($sql);
		if ($sql = $_ADODB->GetInsertSQL($rs, $request)) {
			if ($_ADODB->Execute($sql)) {
                $request['id'] = $_ADODB->Insert_ID();
				$request['close'] = 1;
			} else {
				$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
			}
		} else {
			$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
		}
		$msg = 'insert';
	}
    if (!empty ($request['id']) && count($_ERROR_MESSAGE) == 0) 
    {
    	// generate png images for tex formulas
    	if (strpos($request['wording'], '$') !== FALSE) {
    		$ret = process_tex($request['wording'], $_SERVER['DOCUMENT_ROOT']."/dic/img/w".$request['id']."w_");
    		if ($ret) {
    			$_ERROR_MESSAGE[] = 'Ошибка в формулах в определении: '. implode(',', $ret);
    		}
    	}
    	if (strpos($request['comment'], '$') !== FALSE) {
    		$ret = process_tex($request['comment'], $_SERVER['DOCUMENT_ROOT']."/dic/img/w".$request['id']."c_");
    		if ($ret) {
    			$_ERROR_MESSAGE[] = 'Ошибка в формулах в комментарии: '. implode(',', $ret);
    		}
    	}
    }
	if (!empty ($_POST['delete']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'DELETE FROM dic_wording WHERE id='.$_REQUEST['id'];
		$_ADODB->Execute($sql);
		$request['close'] = 1;
        $msg = 'delete';
	}
    $_ADODB->Execute("INSERT dic_history (term,uid,ts) VALUES(" . $request['term'] . ", $_user_id, NOW())");
} else {
	if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
		$sql = 'SELECT * FROM dic_wording WHERE id='.$_REQUEST['id'];
		$request = $_ADODB->GetRow($sql);
	}

    if (!empty ($_REQUEST['term'])) 
    {
        $request['term'] = $_REQUEST['term'];
    }

    if (!empty ($_REQUEST['type'])) 
    {
        $request['type'] = $_REQUEST['type'];
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

$sql = 'SELECT id, code AS title FROM dic_src ORDER BY title';
$request['src_options'] = $_ADODB->GetAssoc($sql);

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('dic/wording.tpl');
?>