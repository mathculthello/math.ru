<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/set_env.inc.php';
unset($_SESSION['lib_search']);
unset($lib_search);
$navigation['nav_bar'] = array(
	array('url' => '/', 'name' => 'MATH.RU'),
	array('url' => '/lib/', 'name' => 'Библиотека'),
	array('url' => '', 'name' => 'Поиск'),
);
require 'navigation.inc.php';
$_SMARTY->assign($navigation);
$_SMARTY->assign($_SESSION['lib_search']);
$_SMARTY->display('lib/search.tpl');
?>