<?php
require_once 'set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
//$_ADODB->debug = true;

if(!isset($n)) $n = 10;
if(empty($o_by)) {
    $o_by = 'time';
    $o = 1;
}
$paginator = new Paginator($page, array(0 => 'все', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);
$paginator->itemsMessage = 'Всего сообщений';

$sql = 'SELECT COUNT(*) FROM p_message';
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = 'SELECT id,problem_id,DATE_FORMAT(time,\'%d.%m.%Y %H:%i\') AS time,name,email,text FROM p_message ORDER BY time DESC '.$paginator->limit;
$message = $_ADODB->GetAll($sql);

$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('message', $message);
$_SMARTY->display('pb_message_list.tpl');
?>