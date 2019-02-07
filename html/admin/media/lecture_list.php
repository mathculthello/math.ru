<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
//$_ADODB->debug = true;

if (!isset ($n))
	$n = 10;
if (empty ($o_by)) {
	$o_by = 'date';
	$o = 0;
}
$paginator = new Paginator($p, array (0 => 'все', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);
$paginator->itemsMessage = 'Всего лекций';

$sql = "SELECT COUNT(*) FROM media_lecture";
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = 'SELECT id,date,codec,size,CONCAT(width,\'x\',height) AS res,lect,place,title,anno FROM media_lecture ORDER BY '.$o_by. ($o == 1 ? ' DESC' : '').$paginator->limit;
$lecture = $_ADODB->GetAll($sql);

$_columns = array (
array ('name' => 'date', 'title' => 'Дата', 'width' => 200, 'ordered' => 1, 'order' => ($o_by == 'date' && $o ? 0 : 1), 'width' => 80), 
array ('name' => 'title', 'title' => 'Название', 'ordered' => 1, 'order' => ($o_by == 'title' && $o ? 0 : 1), 'ref' => '1'), 
array ('name' => 'codec', 'title' => 'Формат', 'ordered' => 1, 'order' => ($o_by == 'codec' && $o ? 0 : 1), 'width' => '100'),
array ('name' => 'size', 'title' => 'Размер', 'ordered' => 1, 'order' => ($o_by == 'size' && $o ? 0 : 1), 'width' => '100'),
array ('name' => 'res', 'title' => 'Разрешение', 'ordered' => 1, 'order' => ($o_by == 'res' && $o ? 0 : 1), 'width' => '100'),

);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('lecture', $lecture);
$_SMARTY->display('media/lecture_list.tpl');
?>