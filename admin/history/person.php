<?php
require_once '../set_env.inc.php';
//require_once INCLUDE_DIR.'/dbtree/database.php';
//require_once INCLUDE_DIR.'/dbtree/dbtree.php';
//$_ADODB->debug = true;
//print_r($_POST);
//error_reporting(E_ALL);

/*
if ($mode == 'tree') {
    $DB = new CDatabase($dbname, $dbserver, $dbuser, $dbpassword);
    $DBTREE = new CDBTree($DB, "h_tree", "id", array ("left" => "lft", "right" => "rgt", "level" => "level", "parent" => "pid"));
}
*/

/* Сначала обрабатываются изменения в списке связанных ресурсов.
 * Он может изменятся до того как введена основная информация, изменения идут
 * в БД только после нажатия "Сохранить". */
if (!empty ($_POST['story_delete'])) 
{
    $request = process_post_input();
    if (is_array($_POST['story_to_delete'])) 
    {
        $request['story'] = array_diff($request['story'], $_POST['story_to_delete']);
    }
}
elseif (!empty ($_REQUEST['story_to_insert'])) 
{
    $request = process_post_input();
    $ids = explode(' ', ltrim($_REQUEST['story_to_insert']));
    if (is_array($ids))
    {
        $request['story'] = array_merge($request['story'], $ids);
    }
}
elseif ($_POST['add_spelling'])
{
    $request = process_post_input();
    $request['spelling'][] = array('lname' => $request['lname'], 'fname' => $request['fname'], 'sname' => $request['sname']);
}
elseif (is_numeric($_POST['delete_spelling']))
{
    $request = process_post_input();
    $i = $_POST['delete_spelling'];
	$sql = "DELETE FROM h_person_spelling WHERE id = " . $request['spelling'][$i]['id'];
	$_ADODB->Execute($sql);
    $request['spelling'] = array_merge(array_slice($request['spelling'], 0, $i), array_slice($request['spelling'], $i+1)); 
}

elseif ($_POST['person']) {
    $request = process_post_input();

    if (empty ($request['lname'])) 
    {
        $_ERROR_MESSAGE[] = 'Не введена фамилия';
    }
    if (empty ($request['path'])) 
    {
        $_ERROR_MESSAGE[] = 'Не введен путь';
    }

    if (!empty ($_POST['save']) && count($_ERROR_MESSAGE) == 0) 
    {
        $request['letter'] = ord($request['lname'] { 0 });
        if ($request['letter'] < ord('А')) 
        {
            $request['letter'] += 1000;
        }
        if (isset($request['show_in_history']))
        {
            $request['show_in_history'] = 1;
        }
        else
        {
            $request['show_in_history'] = 0;
        }

        if (!empty ($request['id'])) 
        {
            $sql = 'SELECT * FROM h_person WHERE id='.$request['id'];
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
            // добавление
            $sql = 'SELECT * FROM h_person WHERE id=-1';
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
            if ($request['delete_portrait']) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$request['id'].'.'.$request['portrait']);
                unlink($_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$request['id'].'.thumb.'.$request['portrait']);
                $request['portrait'] = '';
                $request['portrait_width'] = 0;
                $request['portrait_height'] = 0;
                $request['thumb_width'] = 0;
                $request['thumb_height'] = 0;
            }
            if (is_uploaded_file($_FILES['portrait_file']['tmp_name'])) 
            {
                $ext = $_mime_ext[$_FILES['portrait_file']['type']];
                $dest = $_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$request['id'].'.'.$ext;
                $thumb = $_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$request['id'].'.thumb.'.$ext;
                move_uploaded_file($_FILES['portrait_file']['tmp_name'], $dest);
                $size = getimagesize($dest);
                resize_image($dest, $thumb, $_THUMB_WIDTH, $_THUMB_HEIGHT);
                $request['portrait'] = $ext;
                $request['portrait_width'] = $size[0];
                $request['portrait_height'] = $size[1];
                $size = getimagesize($thumb);
                $request['thumb_width'] = $size[0];
                $request['thumb_height'] = $size[1];
            }
            $sql = 'SELECT * FROM h_person WHERE id='.$request['id'];
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


            $sql = 'DELETE FROM h_s2p WHERE person='.$request['id'];
            $_ADODB->Execute($sql);
            while (list (, $v) = @ each($_POST['story'])) {
                $sql = 'INSERT h_s2p (story,person) VALUES ('.$v.','.$request['id'].')';
                $_ADODB->Execute($sql);
            }

            if (is_array($request['image_to_delete']) && count($request['image_to_delete'])) 
            {
                while (list ($id, $ext) = each($request['image_to_delete'])) 
                {
                    unlink($_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$request['id'].'_image'.$id.'.'.$ext);
                    unlink($_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$request['id'].'_image'.$id.'.thumb.'.$ext);
                }
                $sql = 'DELETE FROM h_person_gallery WHERE id IN ('.implode(',', array_keys($request['image_to_delete'])).')';
                $_ADODB->Execute($sql);
            }
            
            if (is_uploaded_file($_FILES['new_image_file']['tmp_name'])) 
            {
                $ext = $_mime_ext[$_FILES['new_image_file']['type']];
                $sql = 'SELECT * FROM h_person_gallery WHERE id=-1';
                $rs = $_ADODB->Execute($sql);
                $sql = $_ADODB->GetInsertSQL($rs, array('person' => $request['id'], 'ext' => $ext, 'descr' => $request['new_image_descr']));
                $_ADODB->Execute($sql);
                $id = $_ADODB->Insert_ID();
                $dest = $_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$request['id'].'_image'.$id.'.'.$ext;
                $thumb = $_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$request['id'].'_image'.$id.'.thumb.'.$ext;
                move_uploaded_file($_FILES['new_image_file']['tmp_name'], $dest);
                $size = getimagesize($dest);
                $img['width'] = $size[0];
                $img['height'] = $size[1];
                resize_image($dest, $thumb, $_THUMB_WIDTH, $_THUMB_HEIGHT);
                $size = getimagesize($thumb);
                $img['thumb_width'] = $size[0];
                $img['thumb_height'] = $size[1];
                $sql = 'SELECT * FROM h_person_gallery WHERE id='.$id;
                $rs = $_ADODB->Execute($sql);
                $sql = $_ADODB->GetUpdateSQL($rs, $img, true);
                $_ADODB->Execute($sql);
            }
            
            if (is_array($request['image']) && count($request['image'])) 
            {
                while (list ($id, $img) = each($request['image'])) 
                {
                    $sql = 'SELECT * FROM h_person_gallery WHERE id='.$id;
                    $rs = $_ADODB->Execute($sql);
                    if ($sql = $_ADODB->GetUpdateSQL($rs, $img))
                    {
                        $_ADODB->Execute($sql);
                    }
                }
            }

            $sql = 'SELECT * FROM h_person_spelling WHERE id=-1';
            $rs_insert = $_ADODB->Execute($sql);
            while (list($k, $v) = @each($request['spelling']))
            {
		        $v['letter'] = ord($v['lname'] { 0 });
		        if ($v['letter'] < ord('А')) 
		        {
		            $v['letter'] += 1000;
		        }
                $v['person'] = $request['id'];
                if (!empty($v['id']) && is_numeric($v['id']))
                {
                    $sql = 'SELECT * FROM h_person_spelling WHERE id='.$v['id'];
                    $rs_update = $_ADODB->Execute($sql);
                    if (!isset($v['disp']))
                    {
                        $v['disp'] = '0';
                    }
                    if (!($sql = $_ADODB->GetUpdateSQL($rs_update, $v, true)) || !$_ADODB->Execute($sql)) 
                        $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
                }
                else
                {
                    if (!($sql = $_ADODB->GetInsertSQL($rs_insert, $v)) || !$_ADODB->Execute($sql)) 
                        $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
                }
            }
        }


    }
    elseif (!empty ($_POST['delete']) && !empty($request['id'])) {
        $sql = 'DELETE FROM h_person WHERE id='.$request['id'];
        $_ADODB->Execute($sql);
        $sql = 'DELETE FROM h_person_gallery WHERE person='.$request['id'];
        $_ADODB->Execute($sql);
        $sql = 'DELETE FROM h_s2p WHERE person='.$request['id'];
        $_ADODB->Execute($sql);
        unset($request);
        $msg = 'delete';
    }
    
//    if (count($_ERROR_MESSAGE) == 0) {
//        Header('Location: '.$_SERVER['PHP_SELF'].'?msg='.$msg.'&id='.$request['id']);
//        exit;
//    }
    
}
elseif (!empty($_REQUEST['delete']) && !empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
{
    $sql = 'DELETE FROM h_person WHERE id='.$_REQUEST['id'];
    $_ADODB->Execute($sql);
    $msg = 'delete';
}
else 
{
    if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) 
    {
        $sql = 'SELECT * FROM h_person WHERE id='.$_REQUEST['id'];
        $request = $_ADODB->GetRow($sql);

        $sql = 'SELECT * FROM h_person_spelling WHERE person='.$_REQUEST['id'].' ORDER BY id';
        $request['spelling'] = $_ADODB->GetAll($sql);
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




if (!empty ($request['id']) && is_numeric($request['id'])) 
{
        // связанные ресурсы
        // истории
        $sql = 'SELECT story,1 FROM h_s2p WHERE person='.$request['id'];
        $request['story'] = @ array_keys($_ADODB->GetAssoc($sql));
        // книги
        $sql = 'SELECT '. ('').'b.id AS _key,b.id,b.title,b.year,b.pages,ROUND(b.djvu/1024/1024,2) AS djvu,ROUND(b.pdf/1024/1024,2) AS pdf,ROUND(b.ps/1024/1024,2) AS ps,ROUND(b.html/1024/1024,2) AS html,ROUND(b.tex/1024/1024,2) AS tex,b.djvu_file,b.pdf_file,b.ps_file,b.html_file,b.tex_file'.' FROM lib_book b,lib_b2a b2a WHERE b.id=b2a.book AND b2a.author='.$request['id'].' ORDER BY b.title';
        $request['books'] = $_ADODB->GetAssoc($sql);
        if (!empty ($request['books'])) {
            $sql = 'SELECT b2a.book,a.id,LEFT(a.fname,1) AS fname,LEFT(a.sname,1) AS sname,a.lname,a.letter FROM lib_b2a b2a,h_person a WHERE b2a.book IN('.implode(',', array_keys($request['books'])).') AND a.id=b2a.author ORDER BY a.letter';
            $_authors = $_ADODB->GetAll($sql);
            while (list (, $v) = each($_authors)) {
                $request['books'][$v['book']]['authors'][] = $v;
            }
        }
        // древо лузина
}

/* Информация о связанных ресурсах */
// Сюжеты
$request['story_columns'] = array(
array('name' => 'title', 'title' => 'Название', 'ref' => 1),
);
if (is_array($request['story']) && count($request['story'])) 
{
    $sql = 'SELECT id,title FROM h_story WHERE id IN ('.implode(',', $request['story']).')';
    $request['story_list'] = $_ADODB->GetAll($sql);
}
// Изображения, древо Лузина
if ($request['id']) 
{
    $sql = 'SELECT id,descr,ext,width,height,thumb_width,thumb_height FROM h_person_gallery WHERE person='.$request['id'];
    $request['image'] = $_ADODB->GetAll($sql);
    $sql = 'SELECT t.id,p.path,p.lname,p.fname,p.sname FROM h_tree t,h_tree t1,h_person p WHERE t1.id='.$request['id'].' AND t1.lft BETWEEN t.lft AND t.rgt AND p.id=t.id ORDER BY t.lft';
    $request['tree_path'] = $_ADODB->GetAll($sql);
}


$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->assign('page', $page);
$_SMARTY->assign('o_by', $o_by);
$_SMARTY->assign('o', $o);
$_SMARTY->assign('n', $n);
if ($_REQUEST['short']) 
{
    $_SMARTY->assign($_GET);
    $_SMARTY->display('history/person_short.tpl');
}
else
{
    $_SMARTY->display('history/person.tpl');
}

?>