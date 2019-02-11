<?php
require_once '../set_env.inc.php';

$nav_bar = array(
				array('url' => '/', 'name' => 'MATH.RU'),
				array('url' => '', 'name' => 'Медиатека'),
				);
$_SMARTY->assign('nav_bar', $nav_bar);
$_menu = array(
    array('path' => '/media/cat/mmmf', 'title' => 'Лекции, прочитанные на Малом мехмате МГУ'),
    array('path' => '/media/cat/dubna', 'title' => 'Лекции летней школы &#171;Современная математика&#187;'),
    array('path' => 'http://www.etudes.ru', 'title' => 'Математические этюды'),
    array('path' => 'http://www.tcheb.ru', 'title' => 'Механизмы П.Л.Чебышева'),
);
$_SMARTY->assign('_menu', $_menu);
$_SMARTY->display('media/index.tpl');
?>