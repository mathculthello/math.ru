<?php
require_once '../set_env.inc.php';
require_once 'menu.inc.php';
require_once 'courses.inc.php';

//$_ADODB->debug = true;

$mandatory_fields = array(
'course' => 'Шифр курса', 
'lname' => 'ФИО, Фамилия',
'fname' => 'ФИО, Имя',
'sname' => 'ФИО, Отчество',
'birthdate_year' => 'Дата рождения, год',
'edu_school' => 'Когда и какое учебное заведение окончил(а)',
'edu_spec' => 'Специальность по диплому',
'edu_qual' => 'Квалификация по диплому',
'school_num' => 'Место работы (обр. учреждение), номер ',
'school_name' => 'Место работы (обр. учреждение), полное название ',
'school_addr_zip' => 'Адрес образовательного учреждения и округ, индекс',
'school_addr_city' => 'Адрес образовательного учреждения и округ, город',
'school_addr_txt' => 'Адрес образовательного учреждения и округ, адрес',
'school_pos' => 'Должность и дата назначения',
'school_exp_teacher' => 'Стаж педагогический',
'school_cat_num' => 'Квалификационная категория, разряд',
'school_cat' => 'Квалификационная категория, год и место присвоения',
);

if ($_POST['register']) {

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
    
    while (list($k, $v) = each($mandatory_fields)) {
	    if (empty($_POST[$k])) {
    		$_ERROR_MESSAGE[] = 'Не заполнено обязательное поле "' . $v . '"';
    	}
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
            $_POST['profile'] = 'teacher';
        }
        if (empty($_POST['it_email']))
        {
            $_POST['it_email'] = '0';
        }
        if (empty($_POST['it_internet']))
        {
            $_POST['it_internet'] = '0';
        }
        if (empty($_POST['it_learning']))
        {
            $_POST['it_learning'] = '0';
        }
        $_POST['birthdate'] = $_POST['birthdate_year'] . '-' . $_POST['birthdate_month'] . '-' . $_POST['birthdate_day'];
        if (!$_LU->isLoggedIn()) {
	        $sql = "
				INSERT 
					user (
						login, password, email, 
						profile, fname, sname, 
						lname,city,country,
						region,district,school,
						school_profile,form,form_profile,
						subj
					)
				VALUES 
					('" . addslashes($_POST['newlogin']) . "',
					MD5('" . addslashes($_POST['password']) . "'),
					'" . addslashes($_POST['email']) . "',
					'" . addslashes($_POST['profile']) . "',
					'" . addslashes($_POST['fname']) . "',
					'" . addslashes($_POST['sname']) . "',
					'" . addslashes($_POST['lname']) . "',
					'" . addslashes($_POST['city']) . "',
					'" . addslashes($_POST['country']) . "',
					'" . addslashes($_POST['region']) . "',
					'" . addslashes($_POST['district']) . "',
					'" . addslashes($_POST['school']) . "',
					'" . addslashes($_POST['school_profile']) . "',
					'" . addslashes($_POST['form']) . "',
					'" . addslashes($_POST['form_profile']) . "',
					'" . addslashes($_POST['subj']) . "')";
	        $_ADODB->Execute($sql);
	        $id = $_ADODB->Insert_ID();
	        $sql = 'INSERT phpbb_users (user_id,username,user_password,user_regdate,user_email)'.
	        ' VALUES ('.$id.',\''.addslashes($_POST['newlogin']).'\',MD5(\''.addslashes($_POST['password']).'\'),'.time().',\''.addslashes($_POST['email']).'\')';
	        $_ADODB->Execute($sql);
	        $_LU->login($_POST['newlogin'], $_POST['password']);
	        $_user_login = $_POST['newlogin'];
	        $_user_loggedin = true;
	        
	        $_POST['id'] = $_user_id = $id;
	        
            $sql = "SELECT * FROM user_mioo WHERE id=-1";
            $rs = $_ADODB->Execute($sql);
            if ($sql = $_ADODB->GetInsertSQL($rs, $_POST)) 
            {
                if ($_ADODB->Execute($sql)) 
                {
                	$_user_reg_mioo = 1;
               		$_MESSAGE = 'Регистрация прошла успешно';
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
	        
        } else {
        	$_POST['id'] = $_user_id;
        	$sql = "SELECT id FROM user_mioo WHERE id=" . $_user_id;
        	$_user_reg_mioo = $_ADODB->GetOne($sql);
            if ($_user_reg_mioo) {
            	$sql = "SELECT * FROM user_mioo WHERE id=" . $_user_id;
            	$rs = $_ADODB->Execute($sql);
            	if ($sql = $_ADODB->GetUpdateSQL($rs, $_POST, true)) 
            	{
                	if (!$_ADODB->Execute($sql)) 
                	{
                    	$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg(); 
                	} else {
                		$_MESSAGE = 'Данные изменены';
                	}
            	} 
            	else 
            	{
                	$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg(); 
            	}
            } else {
	            $sql = "SELECT * FROM user_mioo WHERE id=-1";
    	        $rs = $_ADODB->Execute($sql);
        	    if ($sql = $_ADODB->GetInsertSQL($rs, $_POST)) 
            	{
                	if ($_ADODB->Execute($sql)) 
                	{
                		$_user_reg_mioo = 1;
                		$_MESSAGE = 'Регистрация прошла успешно';
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
            }
        }
		
//        mail('khutornoy@mccme.ru', 'Регистрация на курсы МИОО', 'Зарегистрирован новый слушатель:' . $_POST['']);
    }
}

if ($_LU->isLoggedIn() && count($_ERROR_MESSAGE) == 0) {
	$sql = "SELECT * FROM user_mioo WHERE id = " . $_user_id;
	$_POST = $_ADODB->GetRow($sql);
	$_user_reg_mioo = $_POST['id'];
	list($_POST['birthdate_year'], $_POST['birthdate_month'], $_POST['birthdate_day']) = explode('-', $_POST['birthdate']);
}

$_SMARTY->assign($_POST);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->assign('_user_reg_mioo', $_user_reg_mioo);
$_SMARTY->assign('_user_loggedin', $_user_loggedin);
$_SMARTY->display('teacher/reg_courses.tpl');
?>
