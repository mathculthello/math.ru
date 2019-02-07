<?php
require_once '../../set_env.inc.php';
require_once '../menu.inc.php';

$sql = 'SELECT id,title,source,IF(LOCATE(\'@@br@@\',txt),SUBSTRING_INDEX(txt,\'@@br@@\',1),LEFT(txt,0)) AS text FROM teacher_article ORDER BY insert_ts DESC';
$article_list = $_ADODB->GetAll($sql);
$_SMARTY->assign('article_list', $article_list);
$_SMARTY->display('teacher/article/index.tpl');
?>