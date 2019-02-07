<?php
require_once '../set_env.inc.php';
//$_ADODB->debug = true;
//print_r($_REQUEST);

if ($_POST['lecture']) {
	$request = process_post_input();

	if (empty ($request['title'])) 
    {
		$_ERROR_MESSAGE[] = 'Не введен заголовок';
	}

	if (!empty ($_POST['save']) && count($_ERROR_MESSAGE) == 0) 
    {
        if (!empty ($request['id'])) 
        {
            $sql = 'SELECT * FROM media_lecture WHERE id='.$request['id'];
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
            $sql = 'SELECT * FROM media_lecture WHERE id=-1';
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
        }

        if (!empty ($request['id'])) 
        {// связанные ресурсы
        
            // Файл
            $_FILES_PATH = $_SERVER['DOCUMENT_ROOT'].'/media/files';
            if (empty($request['path'])) {
                $sql = 'UPDATE media_lecture SET path=\'\' WHERE id='.$request['id'];
                $_ADODB->Execute($sql);
            }
            elseif (file_exists($_FILES_PATH.'/'.$request['path']) && is_file($_FILES_PATH.'/'.$request['path'])) 
            {
                $size = filesize($_FILES_PATH.'/'.$request['path']);
                $sql = 'UPDATE media_lecture SET size='.$size.',path=\''.$request['path'].'\' WHERE id='.$request['id'];
                $_ADODB->Execute($sql);
            } 
            else 
            {
                $_ERROR_MESSAGE[] = 'Неверно указан путь:'.$request['path'];
                $sql = 'UPDATE media_lecture SET path=\'\' WHERE id='.$request['id'];
                $_ADODB->Execute($sql);
            }

            // Картинки
            if (is_array($request['image_to_delete']) && count($request['image_to_delete'])) 
            {
                while (list ($id, $ext) = each($request['image_to_delete'])) 
                {
                    unlink($_SERVER['DOCUMENT_ROOT'].'/media/img/'.$request['id'].'_image'.$id.'.'.$ext);
                    unlink($_SERVER['DOCUMENT_ROOT'].'/media/img/'.$request['id'].'_image'.$id.'.thumb.'.$ext);
                }
                $sql = 'DELETE FROM media_lecture_gallery WHERE id IN ('.implode(',', array_keys($request['image_to_delete'])).')';
                $_ADODB->Execute($sql);
            }
            
            if (is_uploaded_file($_FILES['new_image_file']['tmp_name'])) 
            {
                $ext = $_mime_ext[$_FILES['new_image_file']['type']];
                $sql = 'SELECT * FROM media_lecture_gallery WHERE id=-1';
                $rs = $_ADODB->Execute($sql);
                $sql = $_ADODB->GetInsertSQL($rs, array('lecture' => $request['id'], 'ext' => $ext, 'descr' => $request['new_image_descr']));
                $_ADODB->Execute($sql);
                $id = $_ADODB->Insert_ID();
                $dest = $_SERVER['DOCUMENT_ROOT'].'/media/img/'.$request['id'].'_image'.$id.'.'.$ext;
                $thumb = $_SERVER['DOCUMENT_ROOT'].'/media/img/'.$request['id'].'_image'.$id.'.thumb.'.$ext;
                move_uploaded_file($_FILES['new_image_file']['tmp_name'], $dest);
                $size = getimagesize($dest);
                $img['width'] = $size[0];
                $img['height'] = $size[1];
                resize_image($dest, $thumb, $_THUMB_WIDTH, $_THUMB_HEIGHT);
                $size = getimagesize($thumb);
                $img['thumb_width'] = $size[0];
                $img['thumb_height'] = $size[1];
                $sql = 'SELECT * FROM media_lecture_gallery WHERE id='.$id;
                $rs = $_ADODB->Execute($sql);
                $sql = $_ADODB->GetUpdateSQL($rs, $img, true);
                $_ADODB->Execute($sql);
            }
            
            if (is_array($request['image']) && count($request['image'])) 
            {
                while (list ($id, $img) = each($request['image'])) 
                {
                    $sql = 'SELECT * FROM media_lecture_gallery WHERE id='.$id;
                    $rs = $_ADODB->Execute($sql);
                    if ($sql = $_ADODB->GetUpdateSQL($rs, $img))
                    {
                        $_ADODB->Execute($sql);
                    }
                }
            }
        }
	}
    elseif (!empty ($_POST['delete']) && count($_ERROR_MESSAGE) == 0) 
    {
		$sql = 'DELETE FROM media_lecture WHERE id='.$_REQUEST['id'];
		$_ADODB->Execute($sql);
        $sql = 'DELETE FROM media_lecture_gallery WHERE lecture='.$_REQUEST['id'];
        $_ADODB->Execute($sql);
        unset($request);
        $msg = 'delete';
    } 

    
//	if (count($_ERROR_MESSAGE) == 0) {
//		Header('Location: /admin/media/lecture.php?msg='.$msg.'&id='.$request['id']);
//		exit;
//	}
} else {
	if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
		$sql = 'SELECT * FROM media_lecture WHERE id='.$_REQUEST['id'];
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

$sql = 'SELECT id, title FROM media_cat';
$request['cat_list'] = $_ADODB->GetAssoc($sql);

// Изображения
if ($request['id']) 
{
    $sql = 'SELECT id,descr,ext,width,height,thumb_width,thumb_height FROM media_lecture_gallery WHERE lecture='.$request['id'];
    $request['image'] = $_ADODB->GetAll($sql);
}

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('media/lecture.tpl');
?>