<?php
require('../set_env.inc.php');
//print_r($_GET);
$where = "";
if(!empty($_POST['lname']))
    $where = " WHERE lname LIKE '%".$_POST['lname']."%'";
$sql = "SELECT id,CONCAT(lname,' ',fname,' ',sname) FROM h_person".$where." ORDER BY letter ASC";
$author_list = $_ADODB->Execute($sql);
$_SMARTY->assign('lname', $_POST[lname]);
$_SMARTY->assign('author_list', $author_list->GetAssoc());
$_SMARTY->assign('formName', $formName);
$_SMARTY->assign('elementName', $elementName);
$_SMARTY->assign('idsElementName', $idsElementName);
$_SMARTY->assign('ismultiple', $ismultiple);
$_SMARTY->assign('authorNameElement', $authorNameElement);
$_SMARTY->assign('reload', $reload);
$_SMARTY->display('lib/author_picker.tpl');
?>