<?php
/*
 * Created on 02.02.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once '../../set_env.inc.php';
if (empty($_REQUEST['path']))
{
    exit;
}
$sql = 'SELECT CONCAT(\'/history/people/portrait/\', id, \'.\', portrait) AS src,portrait_width AS width,portrait_height AS height FROM h_person WHERE path=\''.addslashes($_REQUEST['path']).'\'';
$portrait_info = $_ADODB->GetRow($sql);
$_SMARTY->assign($portrait_info);
$_SMARTY->display('history/people/portrait.tpl');
?>
