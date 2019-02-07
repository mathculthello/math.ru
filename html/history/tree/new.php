<?php
require_once '../../set_env.inc.php';
require_once '../menu.inc.php';

//$_ADODB->debug=true;
$_mime_ext = array ('image/jpeg' => 'jpg', 'image/pjpeg' => 'jpg', 'image/gif' => 'gif', 'image/png' => 'png', 'image/bmp' => 'bmp');

unset ($pid);
if (!empty ($_REQUEST['pid'])) 
{
    $pid = addslashes($_REQUEST['pid']);
}
elseif (!empty ($_REQUEST['path'])) 
{
    $sql = 'SELECT id FROM h_person WHERE path=\''.addslashes($_REQUEST['path']).'\'';
    $pid = $_ADODB->GetOne($sql);
}
elseif (!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
    $sql = 'SELECT pid FROM h_tree WHERE id='.$_REQUEST['id'];
    $pid = $_ADODB->GetOne($sql);
}

if (empty ($pid)) {
    Header('Location: /history/tree/');
    exit;
}

if ($_POST['person']) {
    foreach ($_POST as $key => $value) {
        if (is_array($value)) {
            $request[$key] = $value;
            continue;
        }
        $value = trim($value);
        if (get_magic_quotes_gpc())
            $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $_POST[$key] = $value;
        //      $value = addslashes($value);
        $request[$key] = $value;
    }
    if (empty ($request['lname'])) {
        $_ERROR_MESSAGE[] = 'Не введена фамилия';
    }

    if (!empty ($_POST['save']) && count($_ERROR_MESSAGE) == 0) {
        $letter = ord($request['lname'] { 0 });
        if ($letter < ord('А'))
            $letter += 1000;
        $rs = $_ADODB->Execute('SELECT * FROM h_tree_new WHERE id = -1');
        $request['tree_id'] = $request['id'];
        unset ($request['id']);
        $sql = $_ADODB->GetInsertSQL($rs, $request);
        if ($_ADODB->Execute($sql)) {
            $id = $_ADODB->Insert_ID();
            if (is_uploaded_file($_FILES['portrait_file']['tmp_name'])) 
            {
                $ext = $_mime_ext[$_FILES['portrait_file']['type']];
                $dest = $_SERVER['DOCUMENT_ROOT'].'/history/tree/new_portrait/'.$id.'.'.$ext;
                $thumb = $_SERVER['DOCUMENT_ROOT'].'/history/tree/new_portrait/'.$id.'.thumb.'.$ext;
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

            $sql = 'SELECT * FROM h_tree_new WHERE id='.$id;
            $rs = $_ADODB->Execute($sql);
            if ($sql = $_ADODB->GetUpdateSql($rs, $request))
            {
                $_ADODB->Execute($sql);
            }
        } else {
            $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
        }
        if (count($_ERROR_MESSAGE) == 0) {
            Header('Location: /history/tree/index.php?id='.$pid);
            exit;
        }
    }
}
else
{
    if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) 
    {
        $sql = 'SELECT * FROM h_person WHERE id='.$_REQUEST['id'];
        $request = $_ADODB->GetRow($sql);
    }
}

$sql = 'SELECT t.id,p.path,p.lname,p.fname,p.sname FROM h_tree t,h_tree t1,h_person p WHERE t1.id='.$pid.' AND t1.lft BETWEEN t.lft AND t.rgt AND p.id=t.id ORDER BY t.lft';
$tree_path = $_ADODB->GetAll($sql);

$sql = 'SELECT COUNT(*) FROM h_tree';
$total = $_ADODB->GetOne($sql);

$_SMARTY->assign('total', $total);
$_SMARTY->assign('tree_path', $tree_path);
$_SMARTY->assign('pid', $pid);
$_SMARTY->assign($_POST);
$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->display('history/tree/new.tpl');
?>