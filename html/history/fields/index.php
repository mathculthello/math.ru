<?php
require_once '../../set_env.inc.php';

$_menu = array(
    array('path' => '/history/people/', 'title' => 'Люди'),
    array('path' => '/history/stories/', 'title' => 'Исторические сюжеты'),
    array('path' => '/history/fields/', 'title' => 'Филдсовские медали'),
    array('path' => '/history/tree/', 'title' => 'Древо Лузина'),
    array('path' => '/history/ministry/', 'title' => 'Министры образования')
);
$_SMARTY->assign('_menu', $_menu);
$_SMARTY->display('history/fields/index.tpl');
?>