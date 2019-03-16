<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';

if (!isset ($n))
	$n = 50;
if (empty ($o_by)) {
	$o_by = 'title';
	$o = 0;
}
if (empty($type)) {
	$type = 'term';
}


$paginator = new Paginator($page, array (0 => 'все', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);
if ($type == 'fact') {
	$paginator->itemsMessage = 'Всего фактов';
} elseif ($type == 'term') {
	$paginator->itemsMessage = 'Всего понятий';
} elseif ($type == 'formula') {
    $paginator->itemsMessage = 'Всего формул';
}

$sql = 'SELECT COUNT(*) FROM dic_term WHERE type=\''.$type.'\'';
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = 'SELECT t.*, COUNT(DISTINCT d.id) AS def, COUNT(DISTINCT c.id) AS comp FROM dic_term t LEFT JOIN dic_wording d ON d.term=t.id LEFT JOIN dic_comp c ON c.term=t.id WHERE t.type=\''.$type.'\' GROUP BY t.id ORDER BY '.$o_by. ($o == 1 ? ' DESC' : '').$paginator->limit;
$term = $_ADODB->GetAll($sql);
if ($type == 'fact') {
	$_columns = array (
		array ('name' => 'title', 'title' => 'Название факта', 'ordered' => 1, 'order' => ($o_by == 'title' && $o ? 0 : 1), 'ref' => '1'), 
		array ('name' => 'def', 'title' => 'Формулировок', 'ordered' => 1, 'order' => ($o_by == 'def' && $o ? 0 : 1), 'width' => '200'),
		array ('name' => 'comp', 'title' => 'Сравнений', 'ordered' => 1, 'order' => ($o_by == 'comp' && $o ? 0 : 1), 'width' => '200'),
	);
} elseif($type == 'term') {
	$_columns = array (
		array ('name' => 'title', 'title' => 'Название понятия', 'ordered' => 1, 'order' => ($o_by == 'title' && $o ? 0 : 1), 'ref' => '1'), 
		array ('name' => 'def', 'title' => 'Определений', 'ordered' => 1, 'order' => ($o_by == 'def' && $o ? 0 : 1), 'width' => '200'),
		array ('name' => 'comp', 'title' => 'Сравнений', 'ordered' => 1, 'order' => ($o_by == 'comp' && $o ? 0 : 1), 'width' => '200'),
	);
} elseif($type == 'formula') {
    $_columns = array (
        array ('name' => 'title', 'title' => 'Название формулы', 'ordered' => 1, 'order' => ($o_by == 'title' && $o ? 0 : 1), 'ref' => '1') 
    );
}

$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('term', $term);
$_SMARTY->assign('type', $type);
$_SMARTY->display('dic/term_list.tpl');

?>
