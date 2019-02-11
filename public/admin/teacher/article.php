<?php
require_once '../set_env.inc.php';
//$_ADODB->debug=true;

if ($_POST['article']) {
    $request = process_post_input();

    if (empty ($request['title'])) 
    {
        $_ERROR_MESSAGE[] = 'Пустое название';
    }

    if (!empty ($_POST['save']) && count($_ERROR_MESSAGE) == 0) 
    {
        if (!empty ($request['id'])) 
        {
            $sql = 'SELECT * FROM teacher_article WHERE id='.$request['id'];
            $rs = $_ADODB->Execute($sql);
            $r = $rs->FetchRow();
            $rs->MoveFirst();
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
            $request['insert_ts'] = time();

            $sql = 'SELECT * FROM teacher_article WHERE id=-1';
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
                unlink($_SERVER['DOCUMENT_ROOT'].'/teacher/article/'.$request['path']);
                $request['size'] = 0;
                $request['path'] = '';
            }
            if (is_uploaded_file($_FILES['upload_file']['tmp_name'])) 
            {
                $request['path'] = $_FILES['upload_file']['name'];
                if (file_exists($_SERVER['DOCUMENT_ROOT'].'/teacher/article/'.$_FILES['upload_file']['name']))
                    $request['path'] = $request['id'].'_'.$request['path'];
                $dest = $_SERVER['DOCUMENT_ROOT'].'/teacher/article/'.$request['path'];
                move_uploaded_file($_FILES['upload_file']['tmp_name'], $dest);
                $request['size'] = filesize($dest);
            }
            $sql = 'SELECT * FROM teacher_article WHERE id='.$request['id'];
            $rs = $_ADODB->Execute($sql);
            if ($r['forum'] != $request['forum'])
            {
                if ($request['forum'])// Заводим или переносим тему
                {
                    if ($r['topic']) // переносим
                    {
                        $sql = 'UPDATE phpbb_topics SET forum_id='.$request['forum'].' WHERE topic_id='.$r['topic'];
                        $_ADODB->Execute($sql);
                        $sql = 'UPDATE phpbb_posts SET forum_id='.$request['forum'].' WHERE topic_id='.$r['topic'];
                        $_ADODB->Execute($sql);
                    }
                    else // новая тема
                    {
                        $sql = 'INSERT phpbb_topics (topic_title, topic_time, forum_id, topic_poster) '.
                        'VALUES (\''.$request['title'].'\','.time().','.$request['forum'].','.$_user_id.')';
                        $_ADODB->Execute($sql);
                        $topic_id = $_ADODB->Insert_ID();
                        $sql = 'INSERT phpbb_posts (topic_id, forum_id, poster_id, post_time) '.
                        'VALUES ('.$topic_id.','.$request['forum'].','.$_user_id.','.time().')';
                        $_ADODB->Execute($sql);
                        $post_id = $_ADODB->Insert_ID();
                        $sql = 'INSERT phpbb_posts_text (post_id, post_subject, post_text) '.
                        'VALUES ('.$post_id.',\''.$request['title'].'\',\''.$request['txt'].'\')';
                        $_ADODB->Execute($sql);
                        $sql = 'UPDATE phpbb_topics SET topic_first_post_id='.$post_id.', topic_last_post_id='.$post_id.' WHERE topic_id='.$topic_id;
                        $_ADODB->Execute($sql);
                        $request['topic'] = $topic_id;
                    }
                }
                else
                {
                    $request['forum'] = $request['topic'] = 0;
                }
            }
            $rs->MoveFirst();
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
        }
    } 
    elseif (!empty ($_POST['delete']) && count($_ERROR_MESSAGE) == 0) 
    {
       if (count($_ERROR_MESSAGE) == 0)
       {
           $sql = 'DELETE FROM teacher_article WHERE id='.$request['id'];
           $_ADODB->Execute($sql);
           unset($request);
           $msg = 'delete';
       }
    } 
//    if (count($_ERROR_MESSAGE) == 0) {
//        Header('Location: /admin/teacher/article.php?msg='.$msg.'&id='.$request['id']);
//        exit;
//    }
} else {
    if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
        $sql = 'SELECT * FROM teacher_article WHERE id='.$_REQUEST['id'];
        $request = $_ADODB->GetRow($sql);
    }
}

if ($_REQUEST['msg'] == 'insert') 
{
    $_MESSAGE = 'Информация добавлена';
}
elseif ($_REQUEST['msg'] == 'update') 
{
    $_MESSAGE = 'Изменения сохранены';
}
elseif ($_REQUEST['msg'] == 'delete') 
{
    $_MESSAGE = 'Информация удалена';
}

$sql = 'SELECT forum_id,forum_name FROM phpbb_forums';
$request['forum_options'] = $_ADODB->GetAssoc($sql);

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('teacher/article.tpl');
?>