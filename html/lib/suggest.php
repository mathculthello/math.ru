<?php
require_once '../set_env.inc.php';
//$_ADODB->debug=true;
unset($_SESSION['lib_search']);
unset($lib_search);
$navigation['nav_bar'] = array(
	array('url' => '/', 'name' => 'MATH.RU'),
	array('url' => '/lib', 'name' => 'Библиотека'),
	array('url' => '', 'name' => 'Обратная связь'),
);
if(!empty($_POST['suggest'])) {
    foreach($_POST as $key => $value) { 
        if(is_array($value)) {
            $request[$key] = $value;
            continue;
        }
	    $value = trim($value);
        if (get_magic_quotes_gpc()) $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $_POST[$key] = $value;
        $value = addslashes($value);
        $data[$key] = $value;
	}
    if(empty($data[stitle])) {
        $_MESSAGE = "Пожалуйста, укажите название книги.";
        $_SMARTY->assign($_POST);
    } else {
        $sql = "INSERT lib_sbook (date,author,title,publ,info,name,occupation,job,contacts) VALUES ".
            "(NOW(),'".$_POST[sauthor]."','".$_POST[stitle]."','".$_POST[publ]."','".$_POST[info]."','".$_POST[name]."','".$_POST[occupation]."','".$_POST[job]."','".$_POST[contacts]."')";
        $_ADODB->Execute($sql);
        $_MESSAGE = "Ваше предложение отправлено. Спасибо!";
    }
}
require 'navigation.inc.php';
$_SMARTY->assign($navigation);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->assign($_SESSION['lib_search']);
$_SMARTY->display('lib/suggest.tpl');
?>