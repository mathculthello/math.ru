<?php
/*
 * Created on 24.01.2005
 *
 */
require_once 'set_env.inc.php';
require_once 'browse.inc.php';

$root_dir = $_SERVER['DOCUMENT_ROOT'];
$path = empty($_GET['path']) ? '/' : $_GET['path'];
$dir_info = browse_dir($path, $root_dir, $_GET['filter']);
$dir_info['title'] = realpath($root_dir.$path);
$dir_info['path'] = str_replace('\\', '/', substr(realpath($root_dir.$path), strlen(realpath($root_dir))).'/');
$_SMARTY->assign('dir_info', $dir_info);
$_SMARTY->assign('form', $_GET['form']); 
$_SMARTY->assign('field', $_GET['field']); 
$_SMARTY->assign('filter', $_GET['filter']); 
$_SMARTY->display('browse.tpl');
?>