<?php
require_once 'test_set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
$_ADODB->debug = true;

if (!isset ($n))
    $n = 10;
if (empty ($o_by)) {
    $o_by = 'txt';
    $o = 0;
}
$paginator = new Paginator($p, array (0 => 'всю', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);
$paginator->itemsMessage = 'Всего фигни';


$sql = "SELECT COUNT(*) FROM test";
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = 'SELECT * FROM test ORDER BY '.$o_by. ($o == 1 ? ' DESC' : '').$paginator->limit;
$test = $_ADODB->GetAll($sql);

$_columns = array (array ('name' => 'txt', 'title' => 'Заголовок', 'width' => 200, 'ordered' => 1, 'order' => ($o_by == 'txt' && $o ? 0 : 1), 'ref' => 1));
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('test', $test);
$_SMARTY->display('test_list.tpl');
?>