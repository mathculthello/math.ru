<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'/dbtree/xdbtree.php';
//$_ADODB->debug=true;
//print_r($_POST);

$DBTREE = new XDBTree($_ADODB, "h_tree", "id", array ("left" => "lft", "right" => "rgt", "level" => "level", "parent" => "pid"));

if ($_POST['person']) {
	$_POST = $request = process_post_input();

	if (empty ($request[lname])) {
		$_ERROR_MESSAGE[] = 'Не введена фамилия';
	}
	elseif (!empty ($_POST['publish']) && empty($request['tree_id']) && empty ($request['path'])) {
		$_ERROR_MESSAGE[] = 'Не введен путь';
	}

	if (!empty ($_POST['save']) && !empty ($_REQUEST['id']) && count($_ERROR_MESSAGE) == 0) {
		$request['letter'] = ord($request['lname'] { 0 });
		if ($request['letter'] < ord('А'))
			$request['letter'] += 1000;
		// редактирование
		$sql = 'SELECT * FROM h_tree_new WHERE id='.$_REQUEST['id'];
		$rs = $_ADODB->Execute($sql);
        if (is_uploaded_file($_FILES['portrait_file']['tmp_name'])) 
        {
            $ext = $_mime_ext[$_FILES['portrait_file']['type']];
            $dest = $_SERVER['DOCUMENT_ROOT'].'/history/tree/new_portrait/'.$request['id'].'.'.$ext;
            $thumb = $_SERVER['DOCUMENT_ROOT'].'/history/tree/new_portrait/'.$request['id'].'.thumb.'.$ext;
            move_uploaded_file($_FILES['portrait_file']['tmp_name'], $dest);
            $size = getimagesize($dest);
            resize_image($dest, $thumb, $_THUMB_WIDTH, $_THUMB_HEIGHT);
            $request['portrait'] = $ext;
            $request['portrait_width'] = $size[0];
            $request['portrait_height'] = $size[1];
            $size = getimagesize($thumb);
            $request['thumb_width'] = $size[0];
            $request['thumb_height'] = $size[1];
        }
		if ($sql = $_ADODB->GetUpdateSQL($rs, $request)) {
			$_ADODB->Execute($sql);
		}
		$msg = 'update';
	}
	elseif (!empty ($_POST['publish']) && count($_ERROR_MESSAGE) == 0) {
        if (!empty($_POST['tree_id']) && is_numeric($_POST['tree_id']))
        {
            $rs = $_ADODB->Execute('SELECT * FROM h_person WHERE id = '.$_POST['tree_id']);
            unset($request['id']);
            $sql = $_ADODB->GetUpdateSQL($rs, $request);
            if ($_ADODB->Execute($sql)) {
                $new_id = $request['tree_id'];
                if ($request['portrait']) {
                    rename($_SERVER['DOCUMENT_ROOT'].'/history/tree/new_portrait/'.$_REQUEST['id'].'.'.$request['portrait'], $_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$new_id.'.'.$request['portrait']);
                    rename($_SERVER['DOCUMENT_ROOT'].'/history/tree/new_portrait/'.$_REQUEST['id'].'.thumb.'.$request['portrait'], $_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$new_id.'.thumb.'.$request['portrait']);
                }

                $sql = 'DELETE FROM h_tree_new WHERE id='.$_REQUEST['id'];
                $_ADODB->Execute($sql); 
            } else {
                $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
            }
        }
        else
        {
            $rs = $_ADODB->Execute('SELECT * FROM h_person WHERE id = -1');
            unset ($request['id']);
            $sql = $_ADODB->GetInsertSQL($rs, $request);
            if ($_ADODB->Execute($sql)) {
                $new_id = $_ADODB->Insert_ID();
                if ($request['portrait']) {
                    rename($_SERVER['DOCUMENT_ROOT'].'/history/tree/new_portrait/'.$_REQUEST['id'].'.'.$request['portrait'], $_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$new_id.'.'.$request['portrait']);
                    rename($_SERVER['DOCUMENT_ROOT'].'/history/tree/new_portrait/'.$_REQUEST['id'].'.thumb.'.$request['portrait'], $_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$new_id.'.thumb.'.$request['portrait']);
                }

                $sql = 'SELECT t.id '.
                'FROM h_tree t, h_person p1, h_person p2 '.
                'WHERE t.pid='.$request['pid'].' AND p1.id='.$new_id.' AND p2.id=t.id AND p2.lname>p1.lname '.
                'ORDER BY p2.lname ';
                if ($before_id = $_ADODB->GetOne($sql)) 
                {
                    $DBTREE->insertBefore($before_id, array('id' => $new_id));
                }
                else
                {
                    $DBTREE->insert($request['pid'], array('id' => $new_id));
                }

                $sql = 'DELETE FROM h_tree_new WHERE id='.$_REQUEST['id'];
                $_ADODB->Execute($sql); 
            } else {
                $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
            }
        }
	}
	elseif (!empty ($_POST['delete']) && count($_ERROR_MESSAGE) == 0) {
		$sql = 'DELETE FROM h_tree_new WHERE id='.$id;
		$_ADODB->Execute($sql);
	}
	if (count($_ERROR_MESSAGE) == 0) {
		Header('Location: /admin/history/tree_new.php?msg='.$msg.'&id='.$_REQUEST['id']);
		exit;
	}
} else {
	if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
		$sql = 'SELECT * FROM h_tree_new WHERE id='.$_REQUEST['id'];
		$_POST = $_ADODB->GetRow($sql);
		$_REQUEST = $_POST;
	}
	if ($msg == "add") {
		$_MESSAGE = "Информация добавлена";
	}
	elseif ($msg == "update") {
		$_MESSAGE = "Изменения сохранены";
	}
	elseif ($msg == "remove") {
		$_MESSAGE = "Информация удалена";
	}
}

if (!empty ($_REQUEST['pid'])) {
	$sql = 'SELECT CONCAT(fname,\' \', sname,\' \', lname) FROM h_person WHERE id='.$_REQUEST['pid'];
	$_SMARTY->assign('pfullname', $_ADODB->GetOne($sql));
}

$_SMARTY->assign($_GET);
$_SMARTY->assign($_POST);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('history/tree_person.tpl');
?>