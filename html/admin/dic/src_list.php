<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';

if (!isset ($n))
	$n = 20;
if (empty ($o_by)) {
	$o_by = 'title';
	$o = 0;
}



$paginator = new Paginator($page, array (0 => 'все', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);
$paginator->itemsMessage = 'Всего источников';
$sql = 'SELECT COUNT(*) FROM dic_src';
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = 'SELECT s.*,CONCAT(s.grade_from, \'-\', s.grade_to) AS grade,s.publ FROM dic_src s ORDER BY '.$o_by. ($o == 1 ? ' DESC' : '').$paginator->limit;
$sources = $_ADODB->GetAll($sql);
$_columns = array (
array ('name' => 'code', 'title' => 'Код', 'ordered' => 1, 'order' => ($o_by == 'code' && $o ? 0 : 1)), 
array ('name' => 'type', 'title' => 'Вид', 'ordered' => 1, 'order' => ($o_by == 'type' && $o ? 0 : 1), 'type' => 'options', 'options' => array('textbook' => 'Учебник', 'aid' => 'Уч.пособие', 'book' => 'Книга', 'person' => 'Автор', 'inet' => 'Интернет-ресурс', 'other' => 'Другое')), 
array ('name' => 'title', 'title' => 'Название', 'ordered' => 1, 'order' => ($o_by == 'title' && $o ? 0 : 1), 'ref' => '1'), 
array ('name' => 'author', 'title' => 'Авторы', 'ordered' => 1, 'order' => ($o_by == 'author' && $o ? 0 : 1)),
array ('name' => 'year', 'title' => 'Год', 'ordered' => 1, 'order' => ($o_by == 'year' && $o ? 0 : 1)),
array ('name' => 'grade', 'title' => 'Классы', 'ordered' => 1, 'order' => ($o_by == 'grade' && $o ? 0 : 1)),
array ('name' => 'publ', 'title' => 'Издательство', 'ordered' => 1, 'order' => ($o_by == 'publ' && $o ? 0 : 1))

);

$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('src', $sources);
$_SMARTY->display('dic/src_list.tpl');
?>
