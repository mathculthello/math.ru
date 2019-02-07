<?php
require_once '../../set_env.inc.php';
require_once 'menu.inc.php';
require_once '../menu.inc.php';

$where = '';
if (!empty($_GET['cat_path'])) 
{
    $sql = 'SELECT * FROM teacher_cat WHERE path=\''.addslashes($_GET['cat_path']).'\'';
    $cat = $_ADODB->GetRow($sql);
    $where = ' WHERE cat='.$cat['id'];
}

$sql = 'SELECT * FROM teacher_doc';
$sql .= $where;
$doc = $_ADODB->GetAll($sql);

$_SMARTY->assign('doc', $doc);
$_SMARTY->assign('cat', $cat);
$_SMARTY->assign('_path', '/teacher/doc/'.$cat['path']);
$_SMARTY->display('teacher/doc/doc_list.tpl');
?>
