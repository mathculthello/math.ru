<?php
require_once '../../set_env.inc.php';
require_once '../menu.inc.php';
require_once 'q.inc.php';

$mail_to = 'ask@mccme.ru';
$mail_subject = '[KPM-math.ru] %s';
$mail_body = '
Для того, чтобы ответить на вопрос, пройдите по ссылке <a href="%s">%s</a>
<pre>
********************************************

Название: %s
Автор: %s
Текст:
%s
</pre>
';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=cp1251' . "\r\n";

if ($_POST['q']) {

    if (!$_LU->isLoggedIn()) {
        $_ERROR_MESSAGE[] = 'Вопросы могут отправлять только авторизованные пользователи';
    } else {
    	$_POST['user'] = $_user_id;
    }
    
    if (empty($_POST['title'])) {
   		$_ERROR_MESSAGE[] = 'Не заполнено обязательное поле "Название вопроса"';
   	}
    if (empty($_POST['question'])) {
   		$_ERROR_MESSAGE[] = 'Не заполнено обязательное поле "Вопрос"';
   	}
    if ($_POST['show_author'] == '-1') {
   		$_ERROR_MESSAGE[] = 'Необходимо выбрать указывать ли автора вопроса на форуме';
   	}
    
    if (count($_ERROR_MESSAGE) == 0)
    {
		$sql = 'SELECT * FROM teacher_question WHERE id=-1';
		$rs = $_ADODB->Execute($sql);
		$_POST['dt'] = date('Y-m-d H:i');
		if ($sql = $_ADODB->GetInsertSQL($rs, $_POST)) {
			if ($_ADODB->Execute($sql)) {
				$id = $_ADODB->Insert_ID();
				$mail_sent = mail(
					$mail_to, 
					sprintf($mail_subject, $forums_translit[$_POST['forum']]), 
					sprintf($mail_body, 'http://math.ru/admin/teacher/question.php?id=' . $id, 'http://math.ru/admin/teacher/question.php?id=' . $id, $_POST['title'], $_user_fullname, $_POST['question']), 
					$headers
				);
				if ($mail_sent) {
					$_MESSAGE = 'Спасибо. Ваш вопрос принят.
			Ответ на него будет Вам выслан в течение недели.
			Ответы на другие вопросы по сходной теме <a href="/forum/viewforum.php?f=' . $_POST['forum'] . '">смотрите тут</a>';
				} else {
					$_ERROR_MESSAGE[] = 'Произошла ошибка при отправке вопроса. Пожалуйста, попробуйете позже.';
				}
			} else {
				$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
			}
		} else {
			$_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
		}
    }
}

$_SMARTY->assign($_POST);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->display('teacher/metod/q.tpl');
?>
