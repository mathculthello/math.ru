<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
//$_ADODB->debug = true;

if (!isset ($n))
    $n = 10;
if (empty ($o_by)) {
    $o_by = 'insert_ts';
    $o = 0;
}
$paginator = new Paginator($page, array (0 => 'все', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);
$paginator->itemsMessage = 'Всего статей';

$sql = 'SELECT COUNT(*) FROM teacher_article';
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = 'SELECT * FROM teacher_article ORDER BY '.$o_by. ($o == 1 ? ' DESC' : '').$paginator->limit;
$doc = $_ADODB->GetAll($sql);

$_columns = array (array ('name' => 'insert_ts', 'title' => 'Дата добавления', 'ordered' => 1, 'order' => ($o_by == 'insert_ts' && $o ? 0 : 1), 'width' => '200', 'type' => 'date', 'date_format' => '%d.%m.%Y %H:%M'), array ('name' => 'title', 'title' => 'Название', 'ordered' => 1, 'order' => ($o_by == 'title' && $o ? 0 : 1), 'ref' => '1'));
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('doc', $doc);
$_SMARTY->display('teacher/article_list.tpl');
?>