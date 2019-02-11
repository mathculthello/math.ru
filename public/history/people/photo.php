<?php
require_once '../../set_env.inc.php';
require_once '../menu.inc.php';
//$_ADODB->debug=true;

if (!empty ($_GET['path'])) 
{
	$where = 'path=\''.addslashes($_GET['path']).'\'';
}
elseif (!empty ($_GET['id'])) 
{
	$where = 'id='.addslashes($_GET['id']);
} 
else 
{
	exit;
}
$sql = 'SELECT p.*,REPLACE(p.shortbio,\'@@br@@\',\'\') AS shortbio,COUNT(g.id) AS photo FROM h_person p LEFT JOIN h_person_gallery g ON g.person=p.id WHERE '.$where.' GROUP BY p.id';
$person = $_ADODB->GetRow($sql);
$sql = 'SELECT id,ext,width,height,thumb_width,thumb_height FROM h_person_gallery WHERE person='.$person['id'];
$person['photo'] = $_ADODB->GetAll($sql);

$_SMARTY->assign($person);
$_SMARTY->display('history/people/photo.tpl');
?>