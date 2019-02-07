<?php
require_once '../set_env.inc.php';

function create_cdkey($school_type, $school_num, $user_login) {
	global $_ADODB;
	
	$key = 'P1S4-M2S6-';
	switch ($school_type) {
		case 'school':
			$key .= 'SCHL-' . $school_num;
			break;
		case 'liceum':
			$key .= 'LICM-' . $school_num;
			break;
		case 'high':
			$key .= 'HGSL-' . $school_num;
			break;
		case 'uvk':
			$key .= 'UVKS-' . $school_num;
			break;
	}
	$sql = "UPDATE user SET cdkey = '" . $key . "' WHERE login = '" . $user_login . "'";
	$_ADODB->Execute($sql);
	
	return $key;
}

if ($_POST['reg']) {

    $_ERROR_MESSAGE = array();

    if (!$_LU->isLoggedIn()) {
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
    }
    
    if (empty($_POST['school_num'])) {
    	$_ERROR_MESSAGE[] = 'Не введен номер образовательного учреждения';
    } elseif (strlen($_POST['school_num']) != 4 || !is_numeric($_POST['school_num'])) {
    	$_ERROR_MESSAGE[] = 'Неправильно введен номер образовательного учреждения';
    }

    if (empty($_POST['school'])) {
    	$_ERROR_MESSAGE[] = 'Не введено полное название образовательного учреждения';
    }

    if (empty($_POST['contact_fio'])) {
    	$_ERROR_MESSAGE[] = 'Не введены ФИО контактного лица';
    }

    if (empty($_POST['contact_pos'])) {
    	$_ERROR_MESSAGE[] = 'Не введена должность контактного лица';
    }

    if (empty($_POST['contact_phone'])) {
    	$_ERROR_MESSAGE[] = 'Не введен контактный телефон';
    } elseif (!preg_match('/^\(\d+\)-\d{3}-\d{4}$/', $_POST['contact_phone'])) {
    	$_ERROR_MESSAGE[] = 'Неправильно введен контактный телефон';
    }

    if (empty($_POST['contact_zip'])) {
    	$_ERROR_MESSAGE[] = 'Не введен индекс';
    } elseif (strlen($_POST['contact_zip']) != 6 || !is_numeric($_POST['contact_zip'])) {
    	$_ERROR_MESSAGE[] = 'Неправильно введен индекс';
    }
    
    if (empty($_POST['contact_address'])) {
    	$_ERROR_MESSAGE[] = 'Не введен адрес школы';
    }
    
    if (count($_ERROR_MESSAGE) == 0)
    {
        if (empty($_POST['profile']))
        {
            $_POST['profile'] = 'teacher';
        }
        
        if (!$_LU->isLoggedIn()) {
	        $sql = 'INSERT user (login,password,email,profile,fullname,city,country,region,district,school,school_profile,form,form_profile,subj) '.
	        ' VALUES (\''.addslashes($_POST['newlogin']).'\',MD5(\''.addslashes($_POST['password']).'\'),\''.addslashes($_POST['email']).'\',\''.addslashes($_POST['profile']).'\',\''.addslashes($_POST['fullname']).'\',\''.addslashes($_POST['city']).'\',\''.addslashes($_POST['country']).'\',\''.addslashes($_POST['region']).'\','.
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
	        $_user_login = $_POST['newlogin'];
        }
        
        $sql = "
			UPDATE user SET 
				school = '". addslashes($_POST['school']) ."',
				school_profile = '". addslashes($_POST['school_profile']) ."',
				school_type = '". addslashes($_POST['school_type']) ."',
				school_num = '". addslashes($_POST['school_num']) ."',
				contact_fio = '". addslashes($_POST['contact_fio']) ."',
				contact_pos = '". addslashes($_POST['contact_pos']) ."',
				contact_phone = '". addslashes($_POST['contact_phone']) ."',
				contact_zip = '". addslashes($_POST['contact_zip']) ."',
				contact_address = '". addslashes($_POST['contact_address']) ."',
				school_site = '". addslashes($_POST['school_site']) ."',
				extra_info = '". addslashes($_POST['extra_info']) ."'
			WHERE login = '". $_user_login ."'";
        $_ADODB->Execute($sql);
		
		create_cdkey($_POST['school_type'], $_POST['school_num'], $_user_login);
		
        Header('Location:/auth/cd_key.php');
        exit;
    }
}

$_SMARTY->assign($_POST);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->display('auth/reg_mos1.tpl');
?>
