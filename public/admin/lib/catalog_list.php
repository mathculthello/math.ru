<?php
//ini_set('display_errors', 'on');
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'/dbtree/xdbtree.php';
//$_ADODB->debug = true;

$tree = new XDBTree($_ADODB, 'lib_catalog', 'id', array('left' => "lft", "right" => "rgt", "level" => "level", "parent" => "pid", 'order' => 'ord'));

if (!empty($_GET['moveup'])) {
    $tree->moveUp($_GET['moveup']);
} elseif (!empty($_GET['movedown'])) {
    $tree->moveDown($_GET['movedown']);
} elseif (!empty($_GET['delit'])) {
    $tree->delete($_GET['delit']);
} elseif (!empty($_GET['clear'])) {
    $sql = 'DELETE FROM lib_b2c WHERE subject='.$_GET['clear'];
    $_ADODB->Execute($sql);
}
/*
$sql = 'SELECT c1.id, c1.ord, c1.name, c1.path, COUNT(*) AS level ' .
       'FROM lib_catalog c1, lib_catalog c2 '.
       'WHERE c1.pid!=0 AND c1.lft BETWEEN c2.lft AND c2.rgt '.
       'GROUP BY c1.id '.
       'ORDER BY c1.ord';
*/
$sql = 'SELECT c.id, c.name, c.path, c.level, COUNT(b2c.subject) AS books '. 
       'FROM lib_catalog c LEFT JOIN lib_b2c b2c '. 
       'ON b2c.subject=c.id '.
       'WHERE c.pid != 0 '.
       'GROUP BY c.id '.
       'ORDER BY c.ord';
$catalog = $_ADODB->GetAll($sql);
$_SMARTY->assign('catalog', $catalog);
$_SMARTY->display('lib/catalog_list.tpl');
?>