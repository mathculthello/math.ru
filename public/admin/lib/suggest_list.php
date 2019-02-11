<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
$paginator = new Paginator($page);

$sql = "SELECT COUNT(*) FROM lib_sbook";
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = "SELECT id,DATE_FORMAT(date, '%d.%m %k:%i') AS date,author,title,publ,info,name,occupation,job,contacts FROM lib_sbook ORDER BY date DESC ".$paginator->limit;
$suggest = $_ADODB->GetAll($sql);
//var_dump($paginator);
$_SMARTY->assign('p', $paginator);
$_SMARTY->assign('suggest', $suggest);
$_SMARTY->display('lib/suggest_list.tpl');
?>