<?php
require_once '../set_env.inc.php';
//$_ADODB->debug=true;
//print_r($_POST);

if ($_POST['cat']) {
    $request = process_post_input();

	if (empty($request['title']))
    {
		$_ERROR_MESSAGE[] = 'Не введено название раздела';
    }
    if (empty($request['path']))
    {
        $_ERROR_MESSAGE[] = 'Не введен уникальный путь';
    }
    
	if (!empty($_POST[save]) && count($_ERROR_MESSAGE) == 0) 
    { 
		if(!empty($request['id'])) 
        {
            $sql = 'SELECT * FROM teacher_cat WHERE id='.$request['id'];
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
            $sql = 'SELECT * FROM teacher_cat WHERE id=-1';
            $rs = $_ADODB->Execute($sql);
            if ($sql = $_ADODB->GetInsertSQL($rs, $request)) 
            {
                if ($_ADODB->Execute($sql)) 
                {
                    $request['id'] = $_ADODB->Insert_ID();
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
    elseif (!empty($_POST['delete'])) 
    {
        $sql = 'SELECT COUNT(*) FROM teacher_doc WHERE cat='.$request['id'];
        if ($_ADODB->GetOne($sql)) 
        {
            $_ERROR_MESSAGE[] = 'Раздел не может быть удален.';
        } 
        else 
        {
            $sql = 'DELETE FROM teacher_cat WHERE id='.$request['id'];
            $_ADODB->Execute($sql);
            unset($request);
        }
        $msg = 'delete';
    }
} 
else 
{
    if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) 
    {
        $sql = 'SELECT * FROM teacher_cat WHERE id='.$_REQUEST['id'];
        $request = $_ADODB->GetRow($sql);
    }
}

if ($msg == "insert") 
{
    $_MESSAGE = "Раздел добавлен";
}
elseif ($msg == "update") 
{
    $_MESSAGE = "Изменения сохранены";
}
elseif ($msg == "delete") 
{
    $_MESSAGE = "Раздел удален";
}

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('teacher/cat.tpl');
?>