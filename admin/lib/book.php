<?php
require_once '../set_env.inc.php';
//$_ADODB->debug=true;

//var_dump($_REQUEST);
//echo "<br>";
//var_dump($_FILES);

$file_format = array ('djvu', 'pdf', 'ps', 'html', 'tex');
$_FILES_PATH = $_SERVER['DOCUMENT_ROOT'].'/lib/files';

if (!empty ($_POST['person_delete']))
{
    $request = process_post_input();
    if (is_array($_POST['person_to_delete']))
    {
        $request['person'] = array_diff($request['person'], $_POST['person_to_delete']);
    }
}
elseif (!empty ($_REQUEST['person_to_insert']))
{
    $request = process_post_input();
    $ids = explode(' ', ltrim($_REQUEST['person_to_insert']));
    if (is_array($ids))
    {
        $request['person'] = array_merge((array)$request['person'], $ids);
    }
}
elseif (!empty ($_REQUEST['ad_to_insert']))
{
    $request = process_post_input();
    $ids = explode(' ', ltrim($_REQUEST['ad_to_insert']));
    if (is_array($ids))
    {
        $request['ad'] = array_merge((array)$request['ad'], $ids);
    }
}
elseif (!empty ($_REQUEST['ad_to_delete']))
{
    $request = process_post_input();
    if (is_array($_POST['ad_to_delete']))
    {
        $request['ad'] = array_diff((array)$request['ad'], $_POST['ad_to_delete']);
    }
}
elseif ($_POST['book'])
{
    $request = process_post_input();

    if (empty ($request['title']))
        $_ERROR_MESSAGE[] = 'Не введено название книги';
    if (!empty ($request['year']) && !@ checkdate(1, 1, $request['year']))
        $_ERROR_MESSAGE[] = 'Неверно указан год';
    if (!empty ($request['pages']) && !is_numeric($request['pages']))
        $_ERROR_MESSAGE[] = 'Неверно указано число страниц';
    if (!empty ($request['copies']) && !is_numeric($request['copies']))
        $_ERROR_MESSAGE[] = 'Неверно указан тираж';
    if (!empty ($request['num']) && !is_numeric($request['num']))
        $_ERROR_MESSAGE[] = 'Неверно указан номер в серии';
    if (!is_array($request['person']) || !count($request['person']))
        $_ERROR_MESSAGE[] = 'Не указаны авторы';

    if (!empty ($_POST['save']) && count($_ERROR_MESSAGE) == 0)
    {
        if (!empty ($request['id']))
        {
            $sql = 'SELECT * FROM lib_book WHERE id='.$request['id'];
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
        { // добавление
            $sql = 'SELECT * FROM lib_book WHERE id=-1';
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
        {

            if (is_array($request['ad']))
            {
                $sql = 'DELETE FROM lib_ad WHERE book_id='.$request['id'].' AND id NOT IN('.implode(',', $request['ad']).')';
                $_ADODB->Execute($sql);
            }
            else
            {
                $sql = 'DELETE FROM lib_ad WHERE book_id='.$request['id'];
                $_ADODB->Execute($sql);
            }
            // связь с авторами
            $sql = 'DELETE FROM lib_b2a WHERE book='.$request['id'];
            $_ADODB->Execute($sql);
            while (list (, $v) = @ each($_POST['person']))
            {
                $sql = 'INSERT lib_b2a (book,author,spelling) VALUES ('.$request['id'].','.$v.','.$request['spelling'][$v].')';
                $_ADODB->Execute($sql);
            }

            // связь с каталогом
            $sql = 'DELETE FROM lib_b2c WHERE book='.$request['id'];
            $_ADODB->Execute($sql);
            while (list (, $v) = @ each($request['catalog']))
            {
                $sql = 'INSERT lib_b2c (book, subject) VALUES ('.$request['id'].', '.$v.')';
                $_ADODB->Execute($sql);
            }

            // связь с рубрикатором
            $sql = 'DELETE FROM lib_b2r WHERE book='.$request['id'];
            $_ADODB->Execute($sql);
            while (list (, $v) = @ each($request['rubr']))
            {
                $sql = 'INSERT lib_b2r (book, rubr) VALUES ('.$request['id'].', '.$v.')';
                $_ADODB->Execute($sql);
            }

            // файлы
            while (list (, $f) = each($file_format))
            {
                $path = $_FILES_PATH.'/'.$_POST[$f.'_path'];
                if ($request[$f.'_delete']) {
                    //                    if(file_exists($path) && is_file($path))
                    //                        unlink($path);
                    $sql = 'UPDATE lib_book SET '.$f.'=0 WHERE id='.$request['id'];
                    $_ADODB->Execute($sql);
                }
                elseif (file_exists($path))
                {
                    if (is_file($path))
                    {
                        $size = filesize($path);
                        $sql = 'UPDATE lib_book SET '.$f.'='.$size.','.$f.'_file=\''.$_POST[$f.'_path'].'\' WHERE id='.$request['id'];
                        $_ADODB->Execute($sql);
                    }
                    elseif (is_dir($path))
                    {
                        $path = $path. ($_POST[$f.'_path'] ? '/' : '');
                        $_file = $_FILES[$f.'_file'];
                        if (is_uploaded_file($_file['tmp_name']))
                        {
                            if (file_exists($path.$_file['name']) && is_file($path.$_file['name']))
                            {
                                $_ERROR_MESSAGE[] = 'Файл '.$_path.$_file['name'].' уже существует';
                            }
                            else
                            {
                                move_uploaded_file($_file['tmp_name'], $path.$_file['name']);
                                $sql = 'UPDATE lib_book SET '.$f.'='.$_file['size'].','.$f.'_file=\''.$_POST[$f.'_path']. ($_POST[$f.'_path'] ? '/' : '').$_file['name'].'\' WHERE id='.$request['id'];
                                $_ADODB->Execute($sql);
                            }
                        }
                        elseif (!empty ($_POST[$f.'_path']))
                        {
                            $_ERROR_MESSAGE[] = 'Неверно указан файл:'.$_POST[$f.'_path'];
                        }
                    }
                }
                else
                {
                    $_ERROR_MESSAGE[] = 'Неверно указан путь:'.$_POST[$f.'_path'];
                }
            } //файлы

//            if (is_uploaded_file($_FILES['uploadpicture']['tmp_name'])) {
//              $size = getimagesize($_FILES['uploadpicture']['tmp_name']);
//              $ext = $_mime_ext[$_FILES['uploadpicture']['type']];
//              $sql = "INSERT lib_pic (type,width,height,book) VALUES ('".$ext."',".$size[0].",".$size[1].",".$id.")";
//              $_ADODB->Execute($sql);
//              $pid = $_ADODB->Insert_ID();
//              move_uploaded_file($_FILES['uploadpicture']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/lib/img/".$pid.".".$ext);
//          }
//
//            if (is_array($request['remove_picture']) && count($request['remove_picture'])) {
//              while (list ($pid, $ext) = each($request['remove_picture'])) {
//                  $file_name = $_SERVER['DOCUMENT_ROOT']."/lib/img/".$pid.".".$ext;
//                  unlink($filename);
//              }
//              $sql = "DELETE FROM lib_pic WHERE id IN (".implode(",", array_keys($request['remove_picture'])).")";
//              $_ADODB->Execute($sql);
//          }

        }
//      if (count($_ERROR_MESSAGE) == 0) {
//          Header("Location: ".$_SERVER['PHP_SELF']."?msg=".$msg."&id=".$id);
//          exit;
//      }
    }
    elseif (!empty ($_POST['delete']) && $_user_status == 'admin')
    { //удаление
        $sql = 'DELETE FROM lib_book WHERE id='.$request['id'];
        $_ADODB->Execute($sql);
        $sql = 'DELETE FROM lib_ad WHERE book_id='.$request['id'];
        $_ADODB->Execute($sql);
        $sql = 'DELETE FROM lib_b2a WHERE book='.$request['id'];
        $_ADODB->Execute($sql);
        $sql = 'DELETE FROM lib_b2c WHERE book='.$request['id'];
        $_ADODB->Execute($sql);
        $sql = 'DELETE FROM lib_b2r WHERE book='.$request['id'];
        $_ADODB->Execute($sql);
        $sql = 'DELETE FROM lib_pic WHERE book='.$request['id'];
        $_ADODB->Execute($sql);
        unset($request);
    }
}
else
{ // GET (редактирование или добавление книги)
    if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id']))
    { // редактирование
        $sql = 'SELECT * FROM lib_book WHERE id='.$_REQUEST['id'];
        $request = $_ADODB->GetRow($sql);
        foreach ($file_format as $k => $f)
            if (file_exists($_FILES_PATH.'/'.$request[$f.'_file']) && is_file($_FILES_PATH.'/'.$request[$f.'_file']))
                $request[$f.'_name'] = $request[$f.'_file'];
//      $sql = 'SELECT id,type,width,height FROM lib_pic WHERE book='.$id;
//      $_POST['pictures'] = $_ADODB->GetAll($sql);

        $sql = 'SELECT author FROM lib_b2a WHERE book='.$_REQUEST['id'];
        $request['person'] = $_ADODB->GetCol($sql);
        $sql = 'SELECT author,spelling FROM lib_b2a WHERE book='.$_REQUEST['id'];
        $request['spelling'] = $_ADODB->GetAssoc($sql);
        $sql = 'SELECT subject FROM lib_b2c WHERE book='.$_REQUEST['id'];
        $request['catalog'] = $_ADODB->GetCol($sql);
        $sql = 'SELECT rubr FROM lib_b2r WHERE book='.$_REQUEST['id'];
        $request['rubr'] = $_ADODB->GetCol($sql);
        $sql = 'SELECT id FROM lib_ad WHERE book_id='.$_REQUEST['id'];
        $request['ad'] = $_ADODB->GetCol($sql);

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

// выбираем ТК
$sql = 'SELECT id,name,level FROM lib_catalog WHERE pid!=0 ORDER BY lft';
$request['catalog_list'] = $_ADODB->GetAssoc($sql, false, true);
@ reset($request['catalog']);
while (list (, $v) = @ each($request['catalog']))
    $request['catalog_list'][$v]['checked'] = true;

$sql = 'SELECT id,name FROM lib_rubr';
$request['rubr_list'] = $_ADODB->GetAssoc($sql, false, true);
@ reset($request['rubr']);
while (list (, $v) = @ each($request['rubr']))
    $request['rubr_list'][$v]['checked'] = true;

if (is_array($request['person']) && count($request['person']))
{
    $sql = 'SELECT id,CONCAT(fname,\' \',sname,\' \',lname) AS fullname FROM h_person WHERE id IN ('.implode(',', $request['person']).')';
    $request['person_list'] = $_ADODB->GetAll($sql);
    while (list($k, $v) = each($request['person']))
    {
        $sql = 'SELECT id,CONCAT(fname,\' \',sname,\' \',lname) AS fullname FROM h_person_spelling WHERE person='.$v;
        $request['spelling_options'][$v] = $_ADODB->GetAssoc($sql);
    }
}

if (is_array($request['ad']) && count($request['ad']))
{
    $sql = 'SELECT * FROM lib_ad WHERE id IN ('.implode(',', $request['ad']).')';
    $request['ad_list'] = $_ADODB->GetAll($sql);
}

$sql = 'SELECT id,name FROM lib_series';
$request['series_list'] = $_ADODB->GetAssoc($sql);


$request['ad_columns'] = array (
array ('name' => 'ts', 'title' => 'Дата', 'type' => 'date', 'date_format' => '%d.%m.%Y', 'width' => '100'),
array ('name' => 'page', 'title' => 'Страница', 'width' => '50'),
array ('name' => 'txt', 'title' => 'Текст', 'target' => '_new', 'ref' => 1),
);

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->assign('arch', array ('' => '', 'zip' => 'zip', 'gz' => 'gz', 'tar.gz' => 'tar.gz'));
$_SMARTY->assign('types', array ('book' => 'Книги', 'textbook' => 'Учебники', 'encycl' => 'Словари и энциклопедии'));
$_SMARTY->assign('page', $page);
$_SMARTY->assign('o_by', $o_by);
$_SMARTY->assign('o', $o);
$_SMARTY->assign('n', $n);
$_SMARTY->display('lib/book.tpl');
?>