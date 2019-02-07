<?php
require('../set_env.inc.php');
//print_r($_GET);
$where = '';
if (!empty($_POST['lname'])) {
    $where = ' WHERE lname LIKE \'%'.$_POST['lname'].'%\'';
}
$sql = 'SELECT id,CONCAT(lname,\' \',fname,\' \',sname) FROM h_person'.$where.' ORDER BY letter,lname ASC';
$list = $_ADODB->GetAssoc($sql);
$picker = array(
    'title' => 'Выбор персоны', 
    'items' => $list, 
    'form_name' => $_REQUEST['form_name'], 
    'element_name' => $_REQUEST['element_name'], 
    'ismultiple' => $_REQUEST['ismultiple'], 
    'search_title' => 'Фамилия', 
    'search_name' => 'lname', 
    'search_value' => $_POST['lname'],
    'reload' => $_REQUEST['reload'],
    'insert_href' => '/admin/history/person.php?short=1&',
);
$_SMARTY->assign('picker', $picker);
$_SMARTY->display('generic_picker.tpl');
?>