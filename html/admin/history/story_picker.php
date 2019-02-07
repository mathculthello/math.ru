<?php
require('../set_env.inc.php');
//print_r($_GET);
$where = '';
if (!empty($_POST['title'])) {
    $where = ' WHERE title LIKE \'%'.$_POST['title'].'%\'';
}
$sql = 'SELECT id,title FROM h_story'.$where.' ORDER BY title ASC';
$list = $_ADODB->GetAssoc($sql);
$picker = array(
    'title' => 'Выбор очерка', 
    'items' => $list, 
    'form_name' => $_REQUEST['form_name'], 
    'element_name' => $_REQUEST['element_name'], 
    'ismultiple' => $_REQUEST['ismultiple'], 
    'search_title' => 'Заголовок', 
    'search_name' => 'title', 
    'search_value' => $_POST['title'],
    'reload' => $_REQUEST['reload'],
    'insert_href' => '/admin/history/story.php?short=1&',
);
$_SMARTY->assign('picker', $picker);
$_SMARTY->display('generic_picker.tpl');
?>