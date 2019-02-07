<?php
require('../set_env.inc.php');

$where = ' WHERE 1 = 1';
if (!empty($_POST['title'])) {
    $where .= ' AND title LIKE \'%'.$_POST['title'].'%\'';
}
//CONCAT(
//        CASE type
//            WHEN 'term' THEN '[!]'
//            WHEN 'fact' THEN '[?]'
//            WHEN 'formula' THEN '[*]'
//        END,
//    ' ', title)
$sql = "
SELECT 
    id, title 
FROM 
    dic_term 
$where 
ORDER BY 
    title";

$list = $_ADODB->GetAssoc($sql);

$picker = array(
    'title' => 'Выбор статьи', 
    'items' => $list, 
    'form_name' => $_REQUEST['form_name'], 
    'element_name' => $_REQUEST['element_name'], 
    'text_element_name' => $_REQUEST['text_element_name'], 
    'ismultiple' => $_REQUEST['ismultiple'], 
    'search_title' => 'Заголовок', 
    'search_name' => 'title', 
    'search_value' => $_POST['title'],
    'reload' => $_REQUEST['reload'],
    'noextra' => $_REQUEST['noextra'],
    'insert_href' => '',
);

$_SMARTY->assign('picker', $picker);
$_SMARTY->display('generic_picker.tpl');

?>
