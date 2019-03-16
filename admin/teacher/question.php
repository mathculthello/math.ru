<?php
require_once '../set_env.inc.php';
require_once '../../teacher/metod/q.inc.php';
//$_ADODB->debug=true;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=cp1251' . "\r\n";

if ($_POST['q']) {
    $request = process_post_input();

	if (!empty ($_POST['save'])) {
		
	    if (empty ($request['title'])) 
	    {
	        $_ERROR_MESSAGE[] = 'Пустое название';
	    }
	    if (empty ($request['question'])) 
	    {
	        $_ERROR_MESSAGE[] = 'Пустой текст вопроса';
	    }
	    if (empty ($request['answer'])) 
	    {
	        $_ERROR_MESSAGE[] = 'Пустой текст ответа';
	    }
	}

    if (!empty ($_POST['save']) && count($_ERROR_MESSAGE) == 0) 
    {
        if (!empty ($request['id'])) 
        {
            $sql = 'SELECT * FROM teacher_question WHERE id = ' . $request['id'];
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
        }
        
        if (!empty ($request['id'])) 
        {// связанные ресурсы
            if ($request['delete_file']) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/teacher/metod/files/' . $request['file']);
                $request['size'] = 0;
                $request['path'] = '';
            }
            if (is_uploaded_file($_FILES['upload_file']['tmp_name'])) 
            {
                $request['file'] = $_FILES['upload_file']['name'];
                if (file_exists($_SERVER['DOCUMENT_ROOT'].'/teacher/metod/files/' . $_FILES['upload_file']['name'])) {
                    $request['file'] = $request['id'] . '_' . $request['file'];
                }
                $dest = $_SERVER['DOCUMENT_ROOT'].'/teacher/metod/files/' . $request['file'];
                move_uploaded_file($_FILES['upload_file']['tmp_name'], $dest);
                $request['size'] = filesize($dest);
            }
            $sql = 'SELECT * FROM teacher_question WHERE id='.$request['id'];
            $rs = $_ADODB->Execute($sql);
            
            if ($request['thread'])
            {
                $sql = "
					UPDATE 
						phpbb_posts 
					SET 
						poster_id = " . ($request['show_author'] ? $request['user'] : -1) . ", post_username = 'Нас спрашивают'
					WHERE 
						post_id = " . $request['post'];
                $_ADODB->Execute($sql);
                $sql = "
					UPDATE 
						phpbb_posts_text 
					SET 
						post_subject = '" . $request['title'] . "', post_text = '" . $request['question'] . "'
					WHERE
						post_id = " . $request['post'];
                $_ADODB->Execute($sql);

                $sql = "
					UPDATE 
						phpbb_posts_text 
					SET 
						post_subject = '" . $request['title'] . "', post_text = '" . $request['answer'] . ($request['file'] ? "\r\n<a href=\"/teacher/metod/files/" . $request['file'] . "\">Полный ответ</a>" : '') . "\r\n-----------------\r\nОтветил " . $request['answered_name'] . "'
					WHERE
						post_id = " . $request['post_answer'];
                $_ADODB->Execute($sql);
            }
            elseif ($request['publish'])
            {
                $sql = "
					INSERT 
						phpbb_topics (topic_title, topic_time, forum_id, topic_poster) 
					VALUES 
						('" . $request['title'] . "','" . time() . "'," . $request['forum'] . "," . ($request['show_author'] ? $request['user'] : '-1') . ")";
                $_ADODB->Execute($sql);
                $request['thread'] = $_ADODB->Insert_ID();

                $sql = "
					INSERT 
						phpbb_posts (topic_id, forum_id, poster_id, post_username, post_time) 
					VALUES 
						(" . $request['thread'] . "," . $request['forum'] . "," . ($request['show_author'] ? $request['user'] : -1) . ", 'Нас спрашивают', " . time() . ")";
                $_ADODB->Execute($sql);
                $request['post'] = $_ADODB->Insert_ID();
                $sql = "
					INSERT 
						phpbb_posts_text (post_id, post_subject, post_text) 
					VALUES 
					(" . $request['post'] . ", '" . $request['title'] . "', '" . $request['question'] . "')";
                $_ADODB->Execute($sql);

                $sql = "
					INSERT 
						phpbb_posts (topic_id, forum_id, poster_id, post_username, post_time) 
					VALUES 
						(" . $request['thread'] . "," . $request['forum'] . ", -1, 'Мы отвечаем', " . (time() + 1) . ")";
                $_ADODB->Execute($sql);
                $request['post_answer'] = $_ADODB->Insert_ID();
                $sql = "
					INSERT 
						phpbb_posts_text (post_id, post_subject, post_text) 
					VALUES 
					(" . $request['post_answer'] . ", '" . $request['title'] . "', '" . $request['answer'] . ($request['file'] ? "\r\n<a href=\"/teacher/metod/files/" . $request['file'] . "\">Полный ответ</a>" : '') . "\r\n-----------------\r\nОтветил " . $request['answered_name'] . "')";
                $_ADODB->Execute($sql);
                
                $sql = "
					UPDATE 
						phpbb_topics 
					SET 
						topic_first_post_id = " . $request['post'] . ", topic_last_post_id = " . $request['post_answer'] . " 
					WHERE 
						topic_id = " . $request['thread'];
                $_ADODB->Execute($sql);
                
                $sql = "
					UPDATE
						phpbb_forums
					SET
						forum_topics = forum_topics + 1, forum_posts = forum_posts + 2
					WHERE
						forum_id = " . $request['forum'];
                $_ADODB->Execute($sql);
                
                $sql = "SELECT email FROM user WHERE id=" . $request['user'];
                $email = $_ADODB->GetOne($sql);
                mail($email, "Re: " . $request['title'], $request['answer'] . ($request['file'] ? "\r\n<a href=\"/teacher/metod/files/" . $request['file'] . "\">Полный ответ</a>" : '') . "<br>-----------------<br>Ответил " . $request['answered_name'], $headers);
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
           $sql = 'DELETE FROM teacher_question WHERE id='.$request['id'];
           $_ADODB->Execute($sql);
           unset($request);
           $msg = 'delete';
       }
    } 
    if (count($_ERROR_MESSAGE) == 0) {
        Header('Location: /admin/teacher/question_list.php?msg='.$msg);
        exit;
    }
} else {
    if (!empty ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
        $sql = "SELECT q.*, CONCAT(u.fname, ' ', u.sname, ' ', u.lname , ' (', u.email, ')') AS user_fullname FROM teacher_question q, user u WHERE q.id = " . $_REQUEST['id'] . " AND u.id = q.user";
        $request = $_ADODB->GetRow($sql);
    }
}

if (empty($request['answered_name'])) {
	$request['answered_name'] = $_user_fullname;
}
if (empty($request['answered'])) {
	$request['answered'] = $_user_id;
}

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('teacher/question.tpl');
?>
