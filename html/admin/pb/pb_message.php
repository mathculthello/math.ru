<?php
require_once 'set_env.inc.php';

if ($_POST['message']) {
	if (!empty($_POST[save]) && count($_ERROR_MESSAGE) == 0 && !empty($id)) { 
          $sql = 'UPDATE p_message SET state=\''.$_POST['state'].'\',text=\''.addslashes(htmlspecialchars($_POST['text'])).'\' WHERE id='.$id;
          $_ADODB->Execute($sql);
	} elseif (!empty($_POST[remove])) {
          $sql = 'DELETE FROM p_message WHERE id='.$id;
          $_ADODB->Execute($sql);
     }
     Header("Location: /admin/pb_message_list.php?msg=remove");
     exit;
} else {
	if (!empty($id) && is_numeric($id)) { // редактирование
          $sql = 'SELECT id,problem_id,state,DATE_FORMAT(time,\'%d.%m.%Y %H:%i\') AS time,name,email,text FROM p_message WHERE id='.$id;
	     $_POST = $_ADODB->GetRow($sql);
	}
}

$_SMARTY->assign($_POST);
$_SMARTY->display('pb_message.tpl');
?>