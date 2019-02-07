<?php
require_once '../set_env.inc.php';
$sql = 'SELECT id,path,name FROM lib_series';
$series = $_ADODB->GetAll($sql);
$_columns = array (
array('name' => 'path', 'title' => 'Путь', 'width' => '200', 'ref' => 1),
array('name' => 'name', 'title' => 'Название', 'width' => '600', 'ref' => 1),
);
$_SMARTY->assign('series', $series);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->display('lib/series_list.tpl');
?>