<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
//$_ADODB->debug = true;

if (!isset ($n))
	$n = 10;
if (empty ($o_by)) {
	$o_by = 'ord';
	$o = 0;
}
$paginator = new Paginator($p, array (0 => 'все', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);
$paginator->itemsMessage = 'Всего новостей';

if ($_REQUEST['moveup']) {
	$sql = 'SELECT t1.ord, MAX(t2.ord) AS neword FROM news t1 LEFT JOIN news t2 ON t2.ord < t1.ord WHERE t1.id='.$_REQUEST['moveup'].' GROUP BY t1.id';
	$ord = $_ADODB->GetRow($sql);
	if ($ord['neword']) {
		$sql = 'UPDATE news SET ord='.$ord['ord'].' WHERE ord='.$ord['neword'];
		$_ADODB->Execute($sql);
		$sql = 'UPDATE news SET ord='.$ord['neword'].' WHERE id='.$_REQUEST['moveup'];
		$_ADODB->Execute($sql);
	}
}
if ($_REQUEST['movedown']) {
	$sql = 'SELECT t1.ord, MIN(t2.ord) AS neword FROM news t1 LEFT JOIN news t2 ON t2.ord > t1.ord WHERE t1.id='.$_REQUEST['movedown'].' GROUP BY t1.id';
	$ord = $_ADODB->GetRow($sql);
	if ($ord['neword']) {
		$sql = 'UPDATE news SET ord='.$ord['ord'].' WHERE ord='.$ord['neword'];
		$_ADODB->Execute($sql);
		$sql = 'UPDATE news SET ord='.$ord['neword'].' WHERE id='.$_REQUEST['movedown'];
		$_ADODB->Execute($sql);
	}
}
if ($_REQUEST['movestart']) {
    $sql = 'SELECT t1.ord, MIN(t2.ord) AS neword FROM news t1 LEFT JOIN news t2 ON t2.ord < t1.ord WHERE t1.id='.$_REQUEST['movestart'].' GROUP BY t1.id';
	$ord = $_ADODB->GetRow($sql);
	if ($ord['neword']) {
		$sql = 'UPDATE news SET ord=ord+1';
		$_ADODB->Execute($sql);
		$sql = 'UPDATE news SET ord='.$ord['neword'].' WHERE id='.$_REQUEST['movestart'];
		$_ADODB->Execute($sql);
	}
}
if ($_REQUEST['moveend']) {
	$sql = 'SELECT t1.ord, MAX(t2.ord) AS neword FROM news t1 LEFT JOIN news t2 ON t2.ord > t1.ord WHERE t1.id='.$_REQUEST['moveend'].' GROUP BY t1.id';
	$ord = $_ADODB->GetRow($sql);
	if ($ord['neword']) {
		$sql = 'UPDATE news SET ord=ord-1';
		$_ADODB->Execute($sql);
		$sql = 'UPDATE news SET ord='.$ord['neword'].' WHERE id='.$_REQUEST['moveend'];
		$_ADODB->Execute($sql);
	}
}
if ($_REQUEST['delete']) {
    $sql = 'DELETE FROM news WHERE id IN('.@implode(',', @array_values($_REQUEST['selected'])).')';
    $_ADODB->Execute($sql);
}


$sql = "SELECT COUNT(*) FROM news";
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = 'SELECT id,ord,DATE_FORMAT(date, \'%d.%m.%Y\') AS date,title,text FROM news ORDER BY '.$o_by. ($o == 1 ? ' DESC' : '').$paginator->limit;
$news = $_ADODB->GetAll($sql);

$_columns = array (array ('name' => 'date', 'title' => 'Дата', 'width' => 200, 'ordered' => 1, 'order' => ($o_by == 'date' && $o ? 0 : 1)), array ('name' => 'title', 'title' => 'Заголовок', 'ordered' => 1, 'order' => ($o_by == 'title' && $o ? 0 : 1), 'ref' => '1'), array ('name' => 'ord', 'title' => 'Порядок', 'ordered' => 1, 'order' => ($o_by == 'ord' && $o ? 0 : 1), 'width' => '100'),);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('news', $news);
$_SMARTY->display('news/news_list.tpl');
?>