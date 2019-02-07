<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
//$_ADODB->debug = true;

if (!isset ($n))
	$n = 10;
if (empty ($o_by)) {
	$o_by = 'title';
	$o = 0;
}
$paginator = new Paginator($p, array (0 => 'все', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);

$sql = 'SELECT COUNT(*) FROM teacher_cat';
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = 'SELECT * FROM teacher_cat ORDER BY '.$o_by. ($o == 1 ? ' DESC' : '').$paginator->limit;
$cat = $_ADODB->GetAll($sql);

$_columns = array (
array ('name' => 'path', 'title' => 'Путь', 'ordered' => 1, 'order' => ($o_by == 'path' && $o ? 0 : 1), 'ref' => '1'),
array ('name' => 'title', 'title' => 'Название', 'ordered' => 1, 'order' => ($o_by == 'title' && $o ? 0 : 1), 'ref' => '1')
);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('cat', $cat);
$_SMARTY->display('teacher/cat_list.tpl');
?>