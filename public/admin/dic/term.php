<?php
require_once '../set_env.inc.php';
require_once 'PHP/Compat.php';
PHP_Compat::loadFunction('array_combine');
//$_ADODB->debug = true;
//print_r($_REQUEST);

function process_tex($tex, $img_names_base = "img") {
    global $app_root, $_TMP_DIR, $id, $_user_id;
	
	$_tmp = $app_root.'/html/admin/tex2png/temp';
	$_tmp_tex = $_tmp.'/_tmp_latex_term'.$_user_id.'.tex';
	
    if(preg_match_all("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", $tex, $matches)) {
//print_r($matches);
        $h = fopen($_tmp_tex, 'w');
        fwrite($h, $tex);
        fclose($h);
//echo `pwd`;
//$app_root."/html/admin/tex2png/tex2png.pl ".$_tmp."/_tmp_latex.tex  ".$img_names_base.'<br>';
		exec($app_root.'/html/admin/tex2png/tex2png.pl '. $_tmp_tex .' '. $img_names_base.' '. $_user_id, $out, $ret);
		if ($ret > 0) {
			return $out;
		} else {
			return false;
		}
//		exec('ls -la  ', $out);
//		$out = `$app_root.'/html/admin/tex2png/tex2png.pl '. $_tmp_tex .' '. $img_names_base`;
//		return $app_root.'/html/admin/tex2png/tex2png.pl '. $_tmp_tex .' '. $img_names_base.':<br/>'.implode('<br/>', $out); 
    }
}

if (isset($_REQUEST['del_wording']) && is_numeric($_REQUEST['del_wording']))
{
	$sql = 'DELETE FROM dic_wording WHERE id='.$_REQUEST['del_wording'];
	$_ADODB->Execute($sql);
}

if (isset($_REQUEST['del_formula']) && is_numeric($_REQUEST['del_formula']))
{
    $sql = 'DELETE FROM dic_formula WHERE id='.$_REQUEST['del_formula'];
    $_ADODB->Execute($sql);
}

if (isset($_REQUEST['del_comp']) && is_numeric($_REQUEST['del_comp']))
{
	$sql = 'DELETE FROM dic_comp WHERE id='.$_REQUEST['del_comp'];
	$_ADODB->Execute($sql);
	$sql = 'DELETE FROM dic_comp_src WHERE comp='.$_REQUEST['del_comp'];
	$_ADODB->Execute($sql);
}

if ($_POST['add_ref'])
{
    $request = process_post_input();
    $request['references'][] = array(); 
}
elseif (is_numeric($_POST['delete_ref'])) {
    $request = process_post_input();
    $i = $_POST['delete_ref'];
    $request['references'] = array_merge(array_slice($request['references'], 0, $i), array_slice($request['references'], $i+1)); 
}
elseif ($_POST['term']) {
	$request = process_post_input();

	if (empty ($request['title'])) {
		$_ERROR_MESSAGE[] = 'Не введено название термина';
	}
    if (!empty ($request['ref_title'])) {
        $sql = "
            SELECT id 
            FROM dic_term 
            WHERE title='" . addslashes($request['ref_title']) . "'";
        $ref = $_ADODB->GetOne($sql);
        if ($ref <= 0) {
            $_ERROR_MESSAGE[] = "Неизвестная статья '" . $request['ref_title'] . "'";
        } else {
            $request['ref'] = $ref;
        }
    }
    if (is_array($request['references'])) {
        $sql = "
            SELECT id 
            FROM dic_term 
            WHERE title='%s'
        ";
        foreach ($request['references'] as $k => $r) {
            $ref_id = $_ADODB->GetOne(sprintf($sql, $r['title']));
            if ($ref_id <= 0) {
                $_ERROR_MESSAGE[] = "Неизвестная статья '" . $r['title'] . "'";
            } else {
                $request['references'][$k]['id'] = $ref_id;
            }
        }
    }
	if (!empty ($request['src_entry_code'])) {
		$sql = 'SELECT id FROM dic_src WHERE code=\''.$request['src_entry_code'].'\'';
		$src_id = $_ADODB->GetOne($sql);
		if ($src_id <= 0) {
			$_ERROR_MESSAGE[] = 'Неизвестный код источника для словарной статьи';
		} else {
			$request['src_entry'] = $src_id;
		}
	}
	if (!empty ($request['src_formula_code'])) {
		$sql = 'SELECT id FROM dic_src WHERE code=\''.$request['src_formula_code'].'\'';
		$src_id = $_ADODB->GetOne($sql);
		if ($src_id <= 0) {
			$_ERROR_MESSAGE[] = 'Неизвестный код источника для строгой формулировки';
		} else {
			$request['src_formula'] = $src_id;
		}
	}
	if (!empty ($request['src_comment_code'])) {
		$sql = 'SELECT id FROM dic_src WHERE code=\''.$request['src_comment_code'].'\'';
		$src_id = $_ADODB->GetOne($sql);
		if ($src_id <= 0) {
			$_ERROR_MESSAGE[] = 'Неизвестный код источника для комментария';
		} else {
			$request['src_comment'] = $src_id;
		}
	}
	if (!empty ($request['src_history_code'])) {
		$sql = 'SELECT id FROM dic_src WHERE code=\''.$request['src_history_code'].'\'';
		$src_id = $_ADODB->GetOne($sql);
		if ($src_id <= 0) {
			$_ERROR_MESSAGE[] = 'Неизвестный код источника для исторической справки';
		} else {
			$request['src_history'] = $src_id;
		}
	}
	if (!empty ($request['src_illustration_code'])) {
		$sql = 'SELECT id FROM dic_src WHERE code=\''.$request['src_illustration_code'].'\'';
		$src_id = $_ADODB->GetOne($sql);
		if ($src_id <= 0) {
			$_ERROR_MESSAGE[] = 'Неизвестный код источника для иллюстраций';
		} else {
			$request['src_illustration'] = $src_id;
		}
	}

    $request['grade'] = @implode(',', $request['grade']);
	
    if (!empty ($_POST['save']) && !empty ($request['id']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'SELECT * FROM dic_term WHERE id='.$request['id'];
		$rs = $_ADODB->Execute($sql);
		if ($sql = $_ADODB->GetUpdateSQL($rs, $request)) {
			$_ADODB->Execute($sql);
		}
		$request['term'] = $request['id'];
		$sql = 'SELECT * FROM dic_term_text WHERE term='.$request['id'];
		$rs = $_ADODB->Execute($sql);
		if ($sql = $_ADODB->GetUpdateSQL($rs, $request)) {
			$_ADODB->Execute($sql);
		}
		$msg = 'update';
	}
	elseif (!empty ($_POST['save']) && empty ($_REQUEST['id']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'SELECT * FROM dic_term WHERE id=-1';
		$rs = $_ADODB->Execute($sql);
		if ($sql = $_ADODB->GetInsertSQL($rs, $request)) {
			if ($_ADODB->Execute($sql)) {
                $request['id'] = $_ADODB->Insert_ID();
                $request['term'] = $_ADODB->Insert_ID();
			} else {
				$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
			}
		} else {
			$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
		}
		$sql = 'SELECT * FROM dic_term_text WHERE term=-1';
		$rs = $_ADODB->Execute($sql);
		if ($sql = $_ADODB->GetInsertSQL($rs, $request)) {
			if ($_ADODB->Execute($sql)) {
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
    	if (strpos($request['title'], '$') !== FALSE) {
    		$ret = process_tex($request['title'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$request['id']."t_");
    		if ($ret) {
    			$_ERROR_MESSAGE[] = 'Ошибка в формулах в названии: '. implode(',', $ret);
    		}
    	}
    	if (strpos($request['entry'], '$') !== FALSE) {
    		$ret = process_tex($request['entry'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$request['id']."e_");
    		if ($ret) {
    			$_ERROR_MESSAGE[] = 'Ошибка в формулах в словарной статье: '. implode(',', $ret);
    		}
    	}
    	if (strpos($request['formula'], '$') !== FALSE) {
    		$ret = process_tex($request['formula'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$request['id']."f_");
    		if ($ret) {
    			$_ERROR_MESSAGE[] = 'Ошибка в формулах в определении: '. implode(',', $ret);
    		}
    	}
    	if (strpos($request['illustration'], '$') !== FALSE) {
    		$ret = process_tex($request['illustration'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$request['id']."i_");
    		if ($ret) {
    			$_ERROR_MESSAGE[] = 'Ошибка в формулах в иллюстрациях: '. implode(',', $ret);
    		}
    	}
    	if (strpos($request['comment'], '$') !== FALSE) {
    		$ret = process_tex($request['comment'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$request['id']."c_");
    		if ($ret) {
    			$_ERROR_MESSAGE[] = 'Ошибка в формулах в комментарии: '. implode(',', $ret);
    		}
    	}
    	if (strpos($request['history'], '$') !== FALSE) {
    		$ret = process_tex($request['history'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$request['id']."h_");
    		if ($ret) {
    			$_ERROR_MESSAGE[] = 'Ошибка в формулах в исторической справке: '. implode(',', $ret);
    		}
    	}
        
        $sql = 'DELETE FROM dic_t2r WHERE term='.$request['id'];
        $_ADODB->Execute($sql);
        while (list (, $v) = @ each($request['rubr'])) 
        {
            $sql = 'INSERT dic_t2r (term, rubr) VALUES ('.$request['id'].', '.$v.')';
            $_ADODB->Execute($sql);
        }

        $sql = 'DELETE FROM dic_ref WHERE term1='.$request['id'];
        $_ADODB->Execute($sql);
        while (list (, $v) = @ each($request['references'])) {
            $sql = 'INSERT dic_ref (term1, term2) VALUES ('.$request['id'].', '.$v['id'].')';
            $_ADODB->Execute($sql);
        }
    }
	
	if (!empty ($_POST['delete']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'DELETE FROM dic_term WHERE id='.$_REQUEST['id'];
		$_ADODB->Execute($sql);
		$sql = 'DELETE FROM dic_term_text WHERE term='.$_REQUEST['id'];
		$_ADODB->Execute($sql);
		$sql = 'DELETE FROM dic_wording WHERE term='.$_REQUEST['id'];
		$_ADODB->Execute($sql);
		$sql = 'DELETE FROM dic_comp WHERE term='.$_REQUEST['id'];
		$_ADODB->Execute($sql);
        $msg = 'delete';
	}
	
	if (count($_ERROR_MESSAGE) == 0) {
        $_ADODB->Execute("INSERT dic_history (term,uid,ts) VALUES(" . $request['id'] . ", $_user_id, NOW())");
		Header('Location: /admin/dic/term.php?type='.$request['type'].'&msg='.$msg.'&id='.$request['id']);
		exit;
	}
} else {
	if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
		$sql = "
            SELECT 
                t.*,tt.*, t1.title AS ref_title 
            FROM 
                dic_term t, dic_term_text tt LEFT JOIN dic_term t1 ON t1.id = t.ref
            WHERE 
                t.id=" . $_REQUEST['id'] . " AND tt.term = t.id";
		$request = $_ADODB->GetRow($sql);
        $request['grade'] = explode(',', $request['grade']);
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

if (!empty ($request['id']) && is_numeric($request['id'])) {
    $sql = 'SELECT w.*,s.code AS src FROM dic_wording w LEFT JOIN dic_src s ON s.id=w.src WHERE w.term='.$request['id'];
    $request['def'] = $_ADODB->GetAll($sql);
    $sql = 'SELECT c.* FROM dic_comp c WHERE c.term='.$request['id'];
    $request['comp'] = $_ADODB->GetAll($sql);
    while (list($k, $v) = each($request['comp'])) {
        $sql = 'SELECT src FROM dic_comp_src WHERE comp='.$v['id'];
        $request['comp'][$k]['src'] = $_ADODB->GetCol($sql);
    }
    $sql = 'SELECT rubr FROM dic_t2r WHERE term='.$request['id'];
    $request['rubr'] = $_ADODB->GetCol($sql);
    if (!$_POST['add_ref'] && !is_numeric($_POST['delete_ref']) && count($_ERROR_MESSAGE) == 0) {
        $sql = 'SELECT t.id,t.title FROM dic_ref r,dic_term t WHERE t.id=r.term2 AND r.term1='.$request['id'];
        $request['references'] = $_ADODB->GetAll($sql);
    }
    $request['change_history'] = $_ADODB->GetAll("SELECT h.*,u.login FROM dic_history h LEFT JOIN user u ON u.id = h.uid WHERE term = " . $request['id'] . " ORDER BY ts");
    if ($request['type'] == 'formula') {
        $sql = 'SELECT * FROM dic_formula WHERE term='.$request['id'];
        $request['other_formula'] = $_ADODB->GetAll($sql);
    }
}

if (!empty($_REQUEST['type'])) {
	$request['type'] = $_REQUEST['type'];
} elseif (empty($request['type'])) {
	$request['type'] = 'term';
}

$sql = 'SELECT id, code AS title FROM dic_src ORDER BY title';
$request['src_options'] = $_ADODB->GetAssoc($sql);

$sql = 'SELECT id,name,level FROM dic_rubr WHERE pid!=0 ORDER BY lft';
$request['rubr_list'] = $_ADODB->GetAssoc($sql, false, true);
@ reset($request['rubr']);
while (list (, $v) = @ each($request['rubr'])) {
    $request['rubr_list'][$v]['checked'] = true;
}

$_SMARTY->assign($request);
$_SMARTY->assign('type_options', array('textbook' => 'Учебник', 'aid' => 'Уч.пособие', 'book' => 'Книга', 'person' => 'Автор', 'inet' => 'Интернет-ресурс', 'other' => 'Другое'));
$_SMARTY->assign('fact_type_options', array('theorem' => 'Теорема', 'formula' => 'Формула', 'axiom' => 'Аксиома'));
$_SMARTY->assign('grade_options', array_combine(range(5, 11), range(5, 11)));
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
if ($request['type'] == 'fact') {
	$_SMARTY->assign('def_columns', array(
		array ('name' => 'wording', 'title' => 'Формулировка', 'ref' => '1'), 
		array ('name' => 'comment', 'title' => 'Комментарий'), 
		array ('name' => 'src', 'title' => 'Источник', 'width' => '300'),
	));
} elseif ($request['type'] == 'term') {
	$_SMARTY->assign('def_columns', array(
		array ('name' => 'wording', 'title' => 'Определение', 'ref' => '1'), 
		array ('name' => 'comment', 'title' => 'Комментарий'), 
		array ('name' => 'src', 'title' => 'Источник', 'width' => '300'),
	));
} elseif ($request['type'] == 'formula') {
    $_SMARTY->assign('def_columns', array(
        array ('name' => 'src', 'title' => 'Учебник', 'width' => '300', 'ref' => '1'),
        array ('name' => 'comment', 'title' => 'Комментарий'), 
    ));
    $_SMARTY->assign('formula_columns', array(
        array ('name' => 'formula', 'title' => 'Формула', 'ref' => '1'),
        array ('name' => 'comment', 'title' => 'Комментарий'), 
    ));
}
$_SMARTY->assign('comp_columns', array(
	array ('name' => 'comp', 'title' => 'Сравнение', 'ref' => '1'), 
	array ('name' => 'src', 'title' => 'Источники', 'type' => 'multiple_options', 'options' => $request['src_options'], 'width' => '300'),
));
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->assign('tab', $_REQUEST['tab']);
if ($request['type'] == 'formula') {
    $_SMARTY->display('dic/formula.tpl');
} else {
    $_SMARTY->display('dic/term.tpl');
}
?>