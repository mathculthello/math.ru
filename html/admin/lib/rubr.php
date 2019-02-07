<?php
require_once '../set_env.inc.php';
//$_ADODB->debug=true;
//print_r($_POST);

if ($_POST['rubr']) {
    $request = process_post_input();
    
	if(empty($request[name]))
		$_ERROR_MESSAGE[] = 'Не введено название рубрики';
    
	if(!empty($_POST[save]) && count($_ERROR_MESSAGE) == 0) { 
	    //записываем и перенаправляем 
		if(!empty($_POST['id'])) {
	          // редактирование
              $sql = 'UPDATE lib_rubr SET name=\''.$request['name'].'\',path=\''.$request['path'].'\' WHERE id='.$id;
              $_ADODB->Execute($sql);
			  $msg = 'update';
	    } else {
	          // добавление
              $sql = 'INSERT lib_rubr (name,path) VALUES (\''.$request['name'].'\',\''.$request['path'].'\')';
	          $_ADODB->Execute($sql);
	          $id = $_ADODB->Insert_ID();
			  $msg = 'add';
	    }
	  	Header("Location: ".$_SERVER['PHP_SELF']."?msg=".$msg."&id=".$id);
	    exit;
	} elseif(!empty($_POST[remove])) {
        $sql = "SELECT COUNT(*) FROM lib_b2r WHERE rubr=".$_POST['id'];
        if($_ADODB->GetOne($sql)) {
            $_ERROR_MESSAGE[] = 'Рубрика не может быть удалена.';
        } else {
            $sql = "DELETE FROM lib_rubr WHERE id=".$_POST['id'];
            $_ADODB->Execute($sql);
            Header("Location: ".$_SERVER['PHP_SELF']."?msg=remove");
            exit;
        }
    }
} else { // GET (редактирование или добавление)
	if(!empty($id) && is_numeric($id)) { // редактирование
		$sql = "SELECT id,name,path FROM lib_rubr WHERE id=".$id;
		$_POST = $_ADODB->GetRow($sql);
	} else {	// добавление
	}
	if($msg == "add")
		$_MESSAGE = "Рубрика добавлена";
	elseif($msg == "update")
		$_MESSAGE = "Изменения сохранены";
    elseif($msg == "remove")
        $_MESSAGE = "Рубрика удалена";
}

$_SMARTY->assign($_POST);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('lib/rubr.tpl');
?>