<?php
require_once '../set_env.inc.php';
require_once '../../teacher/courses.inc.php';
//$_ADODB->debug=true;

if ($_POST['mioo']) {
    $request = process_post_input();

    while (list($k, $v) = each($mandatory_fields)) {
	    if (empty($_POST[$k])) {
    		$_ERROR_MESSAGE[] = 'Не заполнено обязательное поле "' . $v . '"';
    	}
    }

    if (!empty ($_POST['save']) && count($_ERROR_MESSAGE) == 0) 
    {
        if (empty($request['it_email']))
        {
            $request['it_email'] = '0';
        }
        if (empty($request['it_internet']))
        {
            $request['it_internet'] = '0';
        }
        if (empty($request['it_learning']))
        {
            $request['it_learning'] = '0';
        }
        $request['birthdate'] = $request['birthdate_year'] . '-' . $request['birthdate_month'] . '-' . $request['birthdate_day'];

        if (!empty ($request['id'])) 
        {
            $sql = 'SELECT * FROM user_mioo WHERE id = ' . $request['id'];
            $rs = $_ADODB->Execute($sql);
            $r = $rs->FetchRow();
            $rs->MoveFirst();
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
        }
        
    } 
    elseif (!empty ($_POST['delete']) && count($_ERROR_MESSAGE) == 0) 
    {
       if (count($_ERROR_MESSAGE) == 0)
       {
           $sql = 'DELETE FROM user_mioo WHERE id='.$request['id'];
           $_ADODB->Execute($sql);
           unset($request);
           $msg = 'delete';
       }
    } 
    
    if (count($_ERROR_MESSAGE) == 0) {
        Header('Location: /admin/teacher/mioo_list.php?msg='.$msg);
        exit;
    }
} else {
    if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
        $sql = "SELECT * FROM user_mioo WHERE id = " . $_REQUEST['id'];
        $request = $_ADODB->GetRow($sql);
    }
}

if (is_numeric($request['id'])) {
	$request['login'] = $_ADODB->GetOne("SELECT login FROM user WHERE id = " . $request['id']);
}

list($request['birthdate_year'], $request['birthdate_month'], $request['birthdate_day']) = explode('-', $request['birthdate']);

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('teacher/mioo_user.tpl');
?>
