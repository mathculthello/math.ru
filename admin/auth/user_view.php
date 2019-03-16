<?php

require_once '../set_env.inc.php';

$sql = "SELECT * FROM user WHERE id = '" . intval($_REQUEST['id']) . "'";
$user = $_ADODB->GetRow($sql);

$user['profile_options'] = array('student' => 'Ученик', 'teacher' => 'Учитель', 'parent' => 'Родитель', 'other' => 'Другое');
$user['status_options'] = array('user' => 'Пользователь', 'editor' => 'Редактор', 'admin' => 'Администратор', 'dic_editor' => 'Редактор словаря', 'teacher_editor' => 'Редактор учительской');

$_SMARTY->assign($user);
$_SMARTY->display('auth/user_view.tpl');
?>
