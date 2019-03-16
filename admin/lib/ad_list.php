<?php
/*
 * Created on 18.06.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once '../set_env.inc.php';

$sql = 'SELECT * FROM lib_ad WHERE book_id=0'; 
$ad_list = $_ADODB->GetAll($sql);

$_columns = array(
    array('name' => 'title', 'title' => 'Заголовок', 'ordered' => 1, 'order' => ($paginator->orderBy=='title' && $paginator->order ? 0 : 1), 'ref' => 1),
    array('name' => 'source', 'title' => 'Источник', 'ordered' => 1, 'order' => ($paginator->orderBy=='source' && $paginator->order ? 0 : 1), 'ref' => 1),
    array('name' => 'url', 'title' => 'URL', 'ordered' => 1, 'order' => ($paginator->orderBy=='url' && $paginator->order ? 0 : 1), 'ref' => 1),
);

require_once '../letters.inc.php';
$_SMARTY->assign('person', $person);
$_SMARTY->assign('lname', $_REQUEST['lname']);
$_SMARTY->assign('_columns', $_columns);

$_SMARTY->assign('ad_list', $ad_list);
$_SMARTY->display('lib/ad_list1.tpl'); 
?>
