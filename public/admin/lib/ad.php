<?php
require_once '../set_env.inc.php';
//$_ADODB->debug=true;
//print_r($_POST);

if ($_POST['ad']) 
{
    $request = process_post_input();
    if (empty($request['txt'])) {
        $_ERROR_MESSAGE[] = 'Не введен текст';
    }
    
    if (!empty($_POST['save']) && count($_ERROR_MESSAGE) == 0) 
    {
        if (!empty($request['id'])) 
        {
            $sql = 'SELECT * FROM lib_ad WHERE id='.$request['id'];
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
            $sql = 'SELECT * FROM lib_ad WHERE id=-1';
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
    elseif(!empty($_POST['delete']) && !empty($request['id'])) 
    {
        $sql = 'DELETE FROM lib_ad WHERE id='.$request['id'];
        $_ADODB->Execute($sql);
        unset($request);
        $msg = 'delete';
    }
} 
else 
{
    if (!empty($_REQUEST['id']) && is_numeric($_REQUEST['id'])) 
    {
        $sql = 'SELECT * FROM lib_ad WHERE id='.$_REQUEST['id'];
        $request = $_ADODB->GetRow($sql);
    } 
}

if ($msg == "insert") 
{
    $_MESSAGE = "Информация добавлена";
}
elseif ($msg == "update") 
{
    $_MESSAGE = "Изменения сохранены";
}
elseif ($msg == "delete") 
{
    $_MESSAGE = "Информация удалена";
}

if ($_REQUEST['book_id'])
{
    $sql = 'SELECT djvu_shift FROM lib_book WHERE book='.$_REQUEST['book_id'];
    $request['djvu_shift'] = $_ADODB->GetOne($sql);
}

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
if ($_REQUEST['short']) 
{
    $_SMARTY->assign($_GET);
    $_SMARTY->display('lib/ad_short.tpl');
}
else
{
    $_SMARTY->display('lib/ad.tpl');
}
?>