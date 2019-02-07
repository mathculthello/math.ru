<?php
require_once '../set_env.inc.php';
//$_ADODB->debug = true;
//var_dump($_SESSION['ludata']);
if (!$_LU->isLoggedIn())
{
    Header('Location:/auth/login.php?redirect=/auth/profile.php');
    exit;
}
if ($_POST['change'])
{
    $sql = 'SELECT password FROM user WHERE id='.$_LU->_auth->authUserId;
    $password = $_ADODB->GetOne($sql);
    if (empty($_POST['email']))
    {
        $_ERROR_MESSSAGE[] = 'Не введен email';
    }
    elseif ($_POST['email'] != $_LU->getProperty('email'))
    {
        $sql = 'SELECT COUNT(*) FROM user WHERE email=\''.addslashes($_POST['email']).'\' AND id!='.$_LU->_auth->authUserId;
        if ($_ADODB->GetOne($sql))
        {
            $_ERROR_MESSAGE[] = 'Указанный email занят';
        }
        
        if (empty($_POST['password']))
        {
            $_ERROR_MESSAGE[] = 'Не указан пароль';
        }
        elseif (md5($_POST['password']) != $password)
        {
            $_ERROR_MESSAGE[] = 'Указан не верный пароль';
        }
    }

    $_newpassword = '';
    if (!empty($_POST['newpassword']))
    {
        if (empty($_POST['password']))
        {
            $_ERROR_MESSAGE[] = 'Не указан пароль';
        }
        elseif (md5($_POST['password']) != $password)
        {
            $_ERROR_MESSAGE[] = 'Указан не верный пароль';
        }
        if ($_POST['newpassword'] != $_POST['newpassword2'])
        {
            $_ERROR_MESSAGE[] = 'Пароль и подтверждение не совпадают';
        }
        
        if (count($_ERROR_MESSAGE) == 0)
        {
            $_newpassword = $_POST['newpassword'];
        }
    }    
//    if (empty($_POST['login']))
//    {
//        $_ERROR_MESSSAGE[] = 'Не введен логин';
//    }
//    else
//    {
//        $sql = 'SELECT COUNT(*) FROM user WHERE login=\''.addslashes($_POST['login']).'\' AND id!='.$_LU->_auth->authUserId;
//        if ($_ADODB->GetOne($sql))
//        {
//            $_ERROR_MESSAGE[] = 'Указанный логин занят';
//        }
//    }
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
        $sql = 'UPDATE user SET '.
        'school=\''.addslashes($_POST['school']).'\','.
        'school_profile=\''.addslashes($_POST['school_profile']).'\','.
        'form_profile=\''.addslashes($_POST['form_profile']).'\','.
        'form=\''.addslashes($_POST['form']).'\','.
        'subj=\''.addslashes($_POST['subj']).'\','.
        'district=\''.addslashes($_POST['district']).'\','.
        'email=\''.addslashes($_POST['email']).
'\',fname=\''.addslashes($_POST['fname']).
'\',sname=\''.addslashes($_POST['sname']).
'\',lname=\''.addslashes($_POST['lname']).
'\',city=\''.addslashes($_POST['city']).'\',region=\''.addslashes($_POST['region']).'\',country=\''.addslashes($_POST['country']).'\''.(!empty($_newpassword)?',password=MD5(\''.addslashes($_newpassword).'\')':'').' WHERE id='.$_LU->_auth->authUserId;
        $_ADODB->Execute($sql);
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['email'] = $_POST['email'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['fname'] = $_POST['fname'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['sname'] = $_POST['sname'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['lname'] = $_POST['lname'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['country'] = $_POST['country'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['city'] = $_POST['city'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['region'] = $_POST['region'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['form_profile'] = $_POST['form_profile'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['form'] = $_POST['form'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['school_profile'] = $_POST['school_profile'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['school'] = $_POST['school'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['subj'] = $_POST['subj'];
        $_SESSION[$_LU->_options['session']['varname']]['auth']['custom']['district'] = $_POST['district'];
        Header('Location:/auth/profile.php');
        exit;
    }

}
$_SMARTY->assign('_menu', array(array('path' => '/lib/', 'title' => 'Библиотека'),array('path' => '/media/', 'title' => 'Медиатека'),array('path' => '/olympiads/', 'title' => 'Олимпиады'),array('path' => '/problems/', 'title' => 'Задачи'),array('path' => '/schools/', 'title' => 'Научные школы'),array('path' => '/teacher/', 'title' => 'Учительская'),array('path' => '/history/', 'title' => 'История математики'),array('path' => '/forum/', 'title' => 'Форумы'),array('path' => '/founders/', 'title' => 'Учредители и спонсоры')));
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
if ($_user_profile == 'student')
{
    $_SMARTY->display('auth/profile_student.tpl');
}
elseif ($_user_profile == 'teacher')
{
    $_SMARTY->display('auth/profile_teacher.tpl');
}
else 
{
    $_SMARTY->display('auth/profile.tpl');
}
?>