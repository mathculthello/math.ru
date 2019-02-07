<?php
require_once '../set_env.inc.php';
//$_ADODB->debug=true;
//print_r($_POST);
//print_r($_FILES);

if ($_POST['cat']) {
    $request = process_post_input();

	if (empty($request['title']))
    {
		$_ERROR_MESSAGE[] = 'Не введено название документа';
    }
    
	if (!empty($_POST['save']) && count($_ERROR_MESSAGE) == 0) 
    { 
		if(!empty($request['id'])) 
        {
            $sql = 'SELECT * FROM teacher_doc WHERE id='.$request['id'];
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
            $sql = 'SELECT * FROM teacher_doc WHERE id=-1';
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
        
        if (!empty ($request['id'])) 
        {// связанные ресурсы
            if ($request['delete_file']) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/teacher/doc/'.$request['path']);
                $request['size'] = 0;
                $request['path'] = '';
            }
            if (is_uploaded_file($_FILES['upload_file']['tmp_name'])) 
            {
                $request['path'] = $_FILES['upload_file']['name'];
                if (file_exists($_SERVER['DOCUMENT_ROOT'].'/teacher/doc/'.$_FILES['upload_file']['name']))
                    $request['path'] = $request['id'].'_'.$request['path'];
                $dest = $_SERVER['DOCUMENT_ROOT'].'/teacher/doc/'.$request['path'];
                move_uploaded_file($_FILES['upload_file']['tmp_name'], $dest);
                $request['size'] = filesize($dest);
            }
            $sql = 'SELECT * FROM teacher_doc WHERE id='.$request['id'];
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


            if (is_array($request['file_to_delete']) && count($request['file_to_delete'])) 
            {
                while (list ($id, $path) = each($request['file_to_delete'])) 
                {
                    unlink($_SERVER['DOCUMENT_ROOT'].'/teacher/html/'.$request['id'].'_'.$id.'.htm');
                }
                $sql = 'DELETE FROM teacher_doc_file WHERE id IN ('.implode(',', array_keys($request['file_to_delete'])).')';
                $_ADODB->Execute($sql);
            }
            
            if (is_uploaded_file($_FILES['new_file_file']['tmp_name'])) 
            {
                $size = filesize($_FILES['new_file_file']['tmp_name']);
                $sql = 'SELECT * FROM teacher_doc_file WHERE id=-1';
                $rs = $_ADODB->Execute($sql);
                $sql = $_ADODB->GetInsertSQL($rs, array('doc' => $request['id'], 'title' => $request['new_file_title']));
                $_ADODB->Execute($sql);
                $id = $_ADODB->Insert_ID();
                $dest = $_SERVER['DOCUMENT_ROOT'].'/teacher/html/'.$request['id'].'_'.$id.'.htm';
                move_uploaded_file($_FILES['new_file_file']['tmp_name'], $dest);
            }
            
            if (is_array($request['file']) && count($request['file'])) 
            {
                while (list ($id, $img) = each($request['file'])) 
                {
                    $sql = 'SELECT * FROM teacher_doc_file WHERE id='.$id;
                    $rs = $_ADODB->Execute($sql);
                    if ($sql = $_ADODB->GetUpdateSQL($rs, $img))
                    {
                        $_ADODB->Execute($sql);
                    }
                }
            }
        }
        
	} 
    elseif (!empty($_POST['delete'])) 
    {
        $sql = 'DELETE FROM teacher_doc WHERE id='.$request['id'];
        $_ADODB->Execute($sql);
        $sql = 'DELETE FROM teacher_doc_file WHERE doc='.$request['id'];
        $_ADODB->Execute($sql);
        unset($request);
        $msg = 'delete';
    }
} 
else 
{
    if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) 
    {
        $sql = 'SELECT * FROM teacher_doc WHERE id='.$_REQUEST['id'];
        $request = $_ADODB->GetRow($sql);
    }
}

if ($msg == "insert") 
{
    $_MESSAGE = "Документ добавлен";
}
elseif ($msg == "update") 
{
    $_MESSAGE = "Изменения сохранены";
}
elseif ($msg == "delete") 
{
    $_MESSAGE = "Документ удален";
}

if ($request['id']) 
{
    $sql = 'SELECT * FROM teacher_doc_file WHERE doc='.$request['id'];
    $request['file'] = $_ADODB->GetAll($sql);
}


$sql = 'SELECT id,title FROM teacher_cat';
$request['cat_list'] = $_ADODB->GetAssoc($sql); 

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('teacher/doc.tpl');
?>