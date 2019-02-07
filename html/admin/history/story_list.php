<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';

if(!isset($n)) $n = 10;
if(empty($o_by)) {
    $o_by = 'date';
    $o = 0;
}
$paginator = new Paginator($p, array(0 => 'все', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);
$paginator->itemsMessage = 'Всего';

$sql = "SELECT COUNT(*) FROM story";
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = 'SELECT id,DATE_FORMAT(date, \'%d.%m.%Y\') AS date,title,SUBSTRING_INDEX(text,\'@@br@@\',1) AS text FROM h_story ORDER BY '.$o_by.($o == 1 ? ' DESC' : '').$paginator->limit;
$story = $_ADODB->GetAll($sql);

$_columns = array(
    array('name' => 'date', 'title' => 'Добавлен', 'width' => 200, 'ordered' => 1, 'order' => ($o_by=='date' && $o? 0 : 1)),
    array('name' => 'title', 'title' => 'Название', 'ordered' => 1, 'order' => ($o_by=='title' && $o? 0 : 1), 'ref' => '1', 'pop_title' => 'text'),
);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('story', $story);
$_SMARTY->display('history/story_list.tpl');
?>