<?php
require_once 'test_set_env.inc.php';
$_ADODB->debug = true;
print_r($_REQUEST);

if ($_POST['test']) {
    $request = process_post_input();

    if (!empty ($_POST['save']) && !empty ($request['id']) && count($_ERROR_MESSAGE) == 0) {
        // редактирование
        $sql = 'SELECT * FROM test WHERE id='.$request['id'];
        $rs = $_ADODB->Execute($sql);
        if ($sql = $_ADODB->GetUpdateSQL($rs, $request)) {
            $_ADODB->Execute($sql);
        }
        $msg = 'update';
    }
    elseif (!empty ($_POST['save']) && empty ($_REQUEST['id']) && count($_ERROR_MESSAGE) == 0) {
        $sql = 'SELECT * FROM test WHERE id=-1';
        $rs = $_ADODB->Execute($sql);
        if ($sql = $_ADODB->GetInsertSQL($rs, $request)) {
            if ($_ADODB->Execute($sql)) {
                $request['id'] = $_ADODB->Insert_ID();
            } else {
                $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
            }
        } else {
            $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
        }
        $msg = 'insert';
    }
    elseif (!empty ($_POST['delete']) && count($_ERROR_MESSAGE) == 0) {
        $sql = 'DELETE FROM test WHERE id='.$_REQUEST['id'];
        $_ADODB->Execute($sql);
        $msg = 'delete';
    }
//    if (count($_ERROR_MESSAGE) == 0) {
//        Header('Location: /admin/test.php?msg='.$msg.'&id='.$request['id']);
//        exit;
//    }
} else {
    if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
        $sql = 'SELECT * FROM test WHERE id='.$_REQUEST['id'];
        $request = $_ADODB->GetRow($sql);
    }
    if ($msg == "insert") {
        $_MESSAGE = "Информация добавлена";
    }
    elseif ($msg == "update") {
        $_MESSAGE = "Изменения сохранены";
    }
    elseif ($msg == "delete") {
        $_MESSAGE = "Информация удалена";
    }
}

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('test.tpl');
?>
