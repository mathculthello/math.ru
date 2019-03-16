<?php
require_once '../set_env.inc.php';
//$_ADODB->debug=true;
//print_r($_POST);

if ($_POST['series']) {
    $request = process_post_input();

	if(empty($request[name]))
		$_ERROR_MESSAGE[] = 'Не введено название серии';
    if(empty($request['path']))
        $_ERROR_MESSAGE[] = 'Не введен путь';
    
	if(!empty($_POST[save]) && count($_ERROR_MESSAGE) == 0) { 
	    //записываем и перенаправляем 
		if(!empty($id)) {
	          // редактирование
              $sql = 'UPDATE lib_series SET name=\''.$request['name'].'\',path=\''.$request['path'].'\',descr=\''.$request['descr'].'\' WHERE id='.$id;
              $_ADODB->Execute($sql);
			  $msg = 'update';
	    } else {
	          // добавление
              $sql = 'INSERT lib_series (name,path,descr) VALUES (\''.$request['name'].'\',\''.$request['path'].'\',\''.$request['descr'].'\')';
	          $_ADODB->Execute($sql);
	          $id = $_ADODB->Insert_ID();
			  $msg = 'add';
	    }
	  	Header("Location: ".$_SERVER['PHP_SELF']."?msg=".$msg."&id=".$id);
	    exit;
	} elseif(!empty($_POST['delete'])) {
        $sql = "SELECT COUNT(*) FROM lib_book WHERE series=".$id;
        if($_ADODB->GetOne($sql)) {
            $_ERROR_MESSAGE[] = 'Серия не может быть удалена.';
        } else {
            $sql = "DELETE FROM lib_series WHERE id=".$id;
            $_ADODB->Execute($sql);
            Header("Location: ".$_SERVER['PHP_SELF']."?msg=remove");
            exit;
        }
    }
} else { // GET (редактирование или добавление)
	if(!empty($id) && is_numeric($id)) { // редактирование
		$sql = "SELECT id,path,name,descr FROM lib_series WHERE id=".$id;
		$_POST = $_ADODB->GetRow($sql);
	} else {	// добавление
	}
	if($msg == "add")
		$_MESSAGE = "Серия добавлена";
	elseif($msg == "update")
		$_MESSAGE = "Изменения сохранены";
    elseif($msg == "remove")
        $_MESSAGE = "Серия удалена";
}

$_SMARTY->assign($_POST);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('lib/series.tpl');
?>