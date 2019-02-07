<?php
require_once '../../set_env.inc.php';
require_once 'menu.inc.php';

$sql = 'SELECT d.*,ROUND(d.size/1024, 2) AS size,c.title AS cat_title, c.path AS cat_path FROM teacher_doc d,teacher_cat c WHERE d.id=\''.addslashes($_REQUEST['id']).'\' AND c.id=d.cat';
$doc = $_ADODB->GetRow($sql);
$sql = 'SELECT * FROM teacher_doc_file WHERE doc=\''.addslashes($_REQUEST['id']).'\' ORDER BY id';
$doc['html_parts'] = $_ADODB->GetAll($sql);
if (empty($_REQUEST['part']))
{
    $doc['part'] = 1;
}
else
{
    $doc['part'] = $_REQUEST['part'];
}
if (is_array($doc['html_parts']) && count($doc['html_parts'])) 
{
    $doc['text'] = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/teacher/html/'.$doc['id'].'_'.$doc['html_parts'][$doc['part']-1]['id'].'.htm');
    if (count($doc['html_parts']) == 1)
    {
        unset($doc['html_parts']);
    }
}
$_SMARTY->assign($doc);
$_SMARTY->display('teacher/doc/doc.tpl');
?>
