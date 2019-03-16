<?php
require_once '../set_env.inc.php';
require_once '../menu.inc.php';
$_SMARTY->assign('nav_bar', array(array('url' => '/', 'name' => 'MATH.RU'), array('url' => '', 'name' => 'Выездные научные школы')));
$_SMARTY->display('schools/index.tpl');
?>
