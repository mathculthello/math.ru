<?php
require_once '../../set_env.inc.php';
require_once '../menu.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
$paginator = new Paginator($page);

$sql = "SELECT COUNT(*) FROM h_story";
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = "SELECT id,date,title,source,IF(LOCATE('@@br@@',text),SUBSTRING_INDEX(text,'@@br@@',1),LEFT(text,400)) AS text FROM h_story ORDER BY date DESC ".$paginator->limit;
$story = $_ADODB->GetAll($sql);
$_SMARTY->assign('p', $paginator);
$_SMARTY->assign('story', $story);
$_SMARTY->display('history/stories/index.tpl');