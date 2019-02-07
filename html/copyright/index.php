<?php
require_once '../set_env.inc.php';
$_SMARTY->assign('_menu', array(array('path' => '/lib/', 'title' => 'Библиотека'),array('path' => '/media/', 'title' => 'Медиатека'),array('path' => '/olympiads/', 'title' => 'Олимпиады'),array('path' => '/problems/', 'title' => 'Задачи'),array('path' => '/schools/', 'title' => 'Научные школы'),array('path' => '/teacher/', 'title' => 'Учительская'),array('path' => '/history/', 'title' => 'История математики'),array('path' => '/forum/', 'title' => 'Форумы'),array('path' => '/founders/', 'title' => 'Учредители и спонсоры')));
$_SMARTY->display('copyright/index.tpl');
?>