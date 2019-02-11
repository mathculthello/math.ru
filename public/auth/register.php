<?php
require_once '../set_env.inc.php';
//$_ADODB->debug = true;
//var_dump($_POST);

if ($_POST['choose_profile'])
{
    
}
elseif ($_POST['register'])
{
    $_ERROR_MESSAGE = array();
    if (empty($_POST['newlogin']))
    {
        $_ERROR_MESSAGE[] = 'Не введен логин';
    }
    else
    {
        $sql = 'SELECT COUNT(*) FROM user WHERE login=\''.addslashes($_POST['newlogin']).'\'';
        if ($_ADODB->GetOne($sql))
        {
            $_ERROR_MESSAGE[] = 'Указанный логин занят';
        }
    }

    if (empty($_POST['email']))
    {
        $_ERROR_MESSAGE[] = 'Не введен email';
    }
    else
    {
        $sql = 'SELECT COUNT(*) FROM user WHERE email=\''.addslashes($_POST['email']).'\'';
        if ($_ADODB->GetOne($sql))
        {
            $_ERROR_MESSAGE[] = 'Указанный email занят';
        }
    }

    if (empty($_POST['password']))
    {
        $_ERROR_MESSAGE[] = 'Не указан пароль';
    }
    if ($_POST['password'] != $_POST['password2'])
    {
        $_ERROR_MESSAGE[] = 'Пароль и подтверждение не совпадают';
    }
    if (empty($_POST['fname']) || empty($_POST['sname']) || empty($_POST['lname']))
    {
        $_ERROR_MESSAGE[] = 'Поля Фамилия, Имя и Отчество обязательны для заполнения';
    }

    if (!preg_match('/^[a-zA-Zа-яА-Я]{2,}$/', $_POST['fname']))
    {
        $_ERROR_MESSAGE[] = 'Неверно заполнено обязательное поле "Имя"';
    }
    if (!preg_match('/^[a-zA-Zа-яА-Я]{2,}$/',$_POST['sname']))
    {
        $_ERROR_MESSAGE[] = 'Неверно заполнено обязательное поле "Отчество"';
    }
    if (!preg_match('/^[a-zA-Zа-яА-Я]{2,}$/',$_POST['lname']))
    {
        $_ERROR_MESSAGE[] = 'Неверно заполнено обязательное поле "Фамилия"';
    }
    
    if (count($_ERROR_MESSAGE) == 0)
    {
        if (empty($_POST['profile']))
        {
            $_POST['profile'] = 'student';
        }
        $sql = 'INSERT user (login,password,email,profile,fname,sname,lname,city,country,region,district,school,school_profile,form,form_profile,subj) '.
        ' VALUES (\''.addslashes($_POST['newlogin']).'\',MD5(\''.addslashes($_POST['password']).'\'),\''.
        addslashes($_POST['email']).'\',\''.addslashes($_POST['profile']).'\',\''.
        addslashes($_POST['fname']).'\',\''.addslashes($_POST['sname']).'\',\''.addslashes($_POST['lname']).'\',\''.addslashes($_POST['city']).
'\',\''.addslashes($_POST['country']).'\',\''.addslashes($_POST['region']).'\','.
        '\''.addslashes($_POST['district']).'\','.
        '\''.addslashes($_POST['school']).'\','.
        '\''.addslashes($_POST['school_profile']).'\','.
        '\''.addslashes($_POST['form']).'\','.
        '\''.addslashes($_POST['form_profile']).'\','.
        '\''.addslashes($_POST['subj']).'\''.
        ')';
        $_ADODB->Execute($sql);
        $id = $_ADODB->Insert_ID();
        $sql = 'INSERT phpbb_users (user_id,username,user_password,user_regdate,user_email)'.
        ' VALUES ('.$id.',\''.addslashes($_POST['newlogin']).'\',MD5(\''.addslashes($_POST['password']).'\'),'.time().',\''.addslashes($_POST['email']).'\')';
        $_ADODB->Execute($sql);
        $_LU->login($_POST['newlogin'], $_POST['password']);
        Header('Location:/auth/profile.php');
        exit;
    }

}
$_SMARTY->assign('_menu', array(array('path' => '/lib/', 'title' => 'Библиотека'),array('path' => '/media/', 'title' => 'Медиатека'),array('path' => '/olympiads/', 'title' => 'Олимпиады'),array('path' => '/problems/', 'title' => 'Задачи'),array('path' => '/schools/', 'title' => 'Научные школы'),array('path' => '/teacher/', 'title' => 'Учительская'),array('path' => '/history/', 'title' => 'История математики'),array('path' => '/forum/', 'title' => 'Форумы'),array('path' => '/founders/', 'title' => 'Учредители и спонсоры')));
$_SMARTY->assign($_POST);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
//if ($_POST['choose_profile'] || $_POST['register'])
//{
//if ($_POST['profile'] == 'teacher')
//{
//    $_SMARTY->display('auth/register_teacher.tpl');
//}
//elseif ($_POST['profile'] == 'student')
//{
//    $_SMARTY->display('auth/register_student.tpl');
//}
//else
//{
//    $_SMARTY->display('auth/register.tpl');
//}
//}
//else
//{
//    $_SMARTY->display('auth/register_profile.tpl');
//}
$_SMARTY->display('auth/register_new.tpl');
?>