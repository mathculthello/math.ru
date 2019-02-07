<?php
require_once '../set_env.inc.php';
function process_tex($tex, $img_names_base = "img") {
    global $app_root, $_TMP_DIR, $id, $_user_id;
	
	$_tmp = $app_root.'/html/admin/tex2png/temp';
	$_tmp_tex = $_tmp.'/_tmp_latex_w'.$_user_id.'.tex';
	
    if(preg_match_all("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", $tex, $matches)) {
        $h = fopen($_tmp_tex, 'w');
        fwrite($h, $tex);
        fclose($h);
		exec($app_root.'/html/admin/tex2png/tex2png.pl '. $_tmp_tex .' '. $img_names_base.' '. $_user_id, $out, $ret);
		if ($ret > 0) {
			return $out;
		} else {
			return false;
		}
    }
}

if ($_POST['other_formula']) {
	$request = process_post_input();

	if (!empty ($_POST['save']) && !empty ($request['id']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'SELECT * FROM dic_formula WHERE id='.$request['id'];
		$rs = $_ADODB->Execute($sql);
		if ($sql = $_ADODB->GetUpdateSQL($rs, $request)) {
			$_ADODB->Execute($sql);
			$request['close'] = 1;
		}
		$msg = 'update';
	}
	elseif (!empty ($_POST['save']) && empty ($_REQUEST['id']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'SELECT * FROM dic_formula WHERE id=-1';
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
    	if (strpos($request['formula'], '$') !== FALSE) {
    		$ret = process_tex($request['formula'], $_SERVER['DOCUMENT_ROOT']."/dic/img/formula".$request['id']."_");
    		if ($ret) {
    			$_ERROR_MESSAGE[] = 'Ошибка в формулах: '. implode(',', $ret);
    		}
    	}
    }
	
	if (!empty ($_POST['delete']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'DELETE FROM dic_formula WHERE id='.$_REQUEST['id'];
		$_ADODB->Execute($sql);
		$request['close'] = 1;
        $msg = 'delete';
	}

} else {
	if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
		$sql = 'SELECT * FROM dic_formula WHERE id='.$_REQUEST['id'];
		$request = $_ADODB->GetRow($sql);
	}

    if (!empty ($_REQUEST['term'])) 
    {
        $request['term'] = $_REQUEST['term'];
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
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('dic/other_formula.tpl');
?>