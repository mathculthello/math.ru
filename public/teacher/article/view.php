<?php
require_once '../../set_env.inc.php';
require_once '../menu.inc.php';

$sql = 'SELECT *,ROUND(size/1024, 2) AS size FROM teacher_article WHERE id='.addslashes($_REQUEST['id']);
$article = $_ADODB->GetRow($sql);

$_SMARTY->assign($article);
$_SMARTY->display('teacher/article/article.tpl');
?>
