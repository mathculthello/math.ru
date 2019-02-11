<?php
require('set_env.inc.php');
//$_ADODB->debug=true;
//print_r($_GET);
$where_lname = '';
if(!empty($_POST['lname']))
    $where_lname = ' AND lname LIKE \'%'.$_POST['lname'].'%\'';
$sql = 'SELECT h_person.id,CONCAT(lname,\' \',fname,\' \',sname) FROM h_person LEFT JOIN h_tree ON h_tree.id=h_person.id WHERE h_tree.id IS NULL'.$where_lname.' ORDER BY letter ASC';
$author_list = $_ADODB->Execute($sql);
$_SMARTY->assign('lname', $_POST[lname]);
$_SMARTY->assign('author_list', $author_list->GetAssoc());
$_SMARTY->assign('formName', $formName);
$_SMARTY->assign('elementName', $elementName);
$_SMARTY->assign('authorNameElement', $authorNameElement);
$_SMARTY->assign('reload', $reload);
$_SMARTY->display('authorpicker.tpl');
?>