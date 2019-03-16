<?php
require_once '../set_env.inc.php';
//$_ADODB->debug=true;

if ($_POST['user']) {
    $request = process_post_input();

    if (empty ($request['login'])) 
    {
        $_ERROR_MESSAGE[] = 'Пустой login';
    }
    else
    {
        $sql = 'SELECT COUNT(*) FROM user WHERE login=\''.addslashes($request['login']).'\''.($request['id'] ? ' AND id!='.$request['id'] : '' );
        if ($_ADODB->GetOne($sql))
        {
            $_ERROR_MESSAGE[] = 'Указанный login занят';
        }
    }
    if (empty ($request['email'])) 
    {
        $_ERROR_MESSAGE[] = 'Пустой email';
    }
    else
    {
        $sql = 'SELECT COUNT(*) FROM user WHERE email=\''.addslashes($request['email']).'\''.($request['id'] ? ' AND id!='.$request['id'] : '' );
        if ($_ADODB->GetOne($sql))
        {
            $_ERROR_MESSAGE[] = 'Указанный email занят';
        }
    }
    if (!empty ($request['new_password']) && ($request['new_password'] != $request['new_password2'])) 
    {
        $_ERROR_MESSAGE[] = 'Пароль и подтверждение не совпадают';
    }
    if (!empty ($_POST['save']) && empty($request['id']) && empty($request['new_password'])) 
    {
        $_ERROR_MESSAGE[] = 'Не задан пароль';
    }


    if (!empty ($_POST['save']) && count($_ERROR_MESSAGE) == 0) 
    {
        if (!empty ($request['new_password']))
        {
            $request['password'] = md5($request['new_password']);
        }
        
        if (!empty ($request['id'])) 
        {
            $sql = 'SELECT * FROM user WHERE id='.$request['id'];
            $rs = $_ADODB->Execute($sql);
            if ($sql = $_ADODB->GetUpdateSQL($rs, $request, true)) 
            {
                if (!$_ADODB->Execute($sql)) 
                {
                    $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg(); 
                }
            } 
            else 
            {
                $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg(); 
            }

            $msg = 'update';
        }
        else 
        {
            $sql = 'SELECT * FROM user WHERE id=-1';
            $rs = $_ADODB->Execute($sql);
            
            if ($sql = $_ADODB->GetInsertSQL($rs, $request)) 
            {
                if ($_ADODB->Execute($sql)) 
                {
                    $request['id'] = $_ADODB->Insert_ID();
                    $sql = 'INSERT phpbb_users (user_id,username,user_password,user_regdate,user_email)'.
                    ' VALUES ('.$request['id'].',\''.$request['login'].'\',\''.$request['password'].'\','.time().',\''.$request['email'].'\')';
                    $_ADODB->Execute($sql);
                } 
                else 
                {
                    $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
                }
            } 
            else 
            {
                $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
            }

            $msg = 'insert';
        }
        
    } 
    elseif (!empty ($_POST['delete']) && count($_ERROR_MESSAGE) == 0) 
    {
       if (count($_ERROR_MESSAGE) == 0)
       {
           $sql = 'DELETE FROM user WHERE id='.$request['id'];
           $_ADODB->Execute($sql);
           $sql = 'DELETE FROM phpbb_users WHERE user_id='.$request['id'];
           $_ADODB->Execute($sql);
           unset($request);
           $msg = 'delete';
       }
    } 
    if (count($_ERROR_MESSAGE) == 0) {
        Header('Location: /admin/auth/user.php?msg='.$msg.'&id='.$request['id']);
        exit;
    }
} else {
    if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
        $sql = 'SELECT * FROM user WHERE id='.$_REQUEST['id'];
        $request = $_ADODB->GetRow($sql);
    }
}

if ($_REQUEST['msg'] == 'insert') 
{
    $_MESSAGE = 'Информация добавлена';
}
elseif ($_REQUEST['msg'] == 'update') 
{
    $_MESSAGE = 'Изменения сохранены';
}
elseif ($_REQUEST['msg'] == 'delete') 
{
    $_MESSAGE = 'Информация удалена';
}

$request['profile_options'] = array('student' => 'Ученик', 'teacher' => 'Учитель', 'parent' => 'Родитель', 'other' => 'Другое');
$request['status_options'] = array('user' => 'Пользователь', 'editor' => 'Редактор', 'admin' => 'Администратор', 'dic_editor' => 'Редактор словаря', 'teacher_editor' => 'Редактор учительской');

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('auth/user.tpl');
?>