<?php
require_once '../set_env.inc.php';
$sql = 'SELECT id,path,name FROM lib_rubr';
$rubr = $_ADODB->GetAll($sql);
$_columns = array (
array('name' => 'path', 'title' => 'Путь', 'width' => '200', 'ref' => 1),
array('name' => 'name', 'title' => 'Название', 'width' => '600', 'ref' => 1),
);
$_SMARTY->assign('rubr', $rubr);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->display('lib/rubr_list.tpl');
?>