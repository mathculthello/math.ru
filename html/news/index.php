<?php
/*
 * Created on 12.10.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once '../set_env.inc.php';
require_once '../menu.inc.php';
$data = array();
if (!empty($_GET['id']) && is_numeric($_GET['id']))
{
    $sql = 'SELECT * FROM news WHERE id=\''.addslashes($_GET['id']).'\'';
    $data = $_ADODB->GetRow($sql);
}
$_SMARTY->assign($data);
$_SMARTY->display('news/index.tpl');
?>
