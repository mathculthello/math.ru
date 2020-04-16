<?php
require_once '../../set_env.inc.php';
require_once '../menu.inc.php';
$id = (int) $_GET['id'];
if(empty($id)) exit;
$sql = "SELECT id,date,title,REPLACE(text,'@@br@@','') AS text,source FROM h_story WHERE id=".$id;
$story = $_ADODB->GetRow($sql);
$_SMARTY->assign($story);
$_SMARTY->display('history/stories/story.tpl');
?>
