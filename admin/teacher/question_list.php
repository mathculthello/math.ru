<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
//$_ADODB->debug = true;

if (!isset ($n))
    $n = 10;
if (empty ($o_by)) {
    $o_by = 'id';
    $o = 0;
}
$paginator = new Paginator($page, array (0 => 'все', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);
$paginator->itemsMessage = 'Всего вопросов';

$sql = 'SELECT COUNT(*) FROM teacher_question';
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = "
	SELECT 
		q.id, q.title, DATE_FORMAT(q.dt, '%d.%m.%Y %H:%i') AS dt,
		CONCAT(u1.fname, ' ', u1.sname, ' ', u1.lname , ' (', u1.email, ')') AS user, 
		CONCAT(u.fname, ' ', u.sname, ' ', u.lname , ' (', u.email, ')') AS answered,
		DATE_FORMAT(FROM_UNIXTIME(p.post_time), '%d.%m.%Y %H:%i') AS answer_dt 
	FROM 
		teacher_question q, user u1 
		LEFT JOIN user u ON u.id = q.answered
		LEFT JOIN phpbb_posts p ON p.post_id = q.post
	WHERE 
		u1.id = q.user 
	ORDER BY 
		" . $o_by . ($o == 1 ? ' DESC' : '') . $paginator->limit;

$doc = $_ADODB->GetAll($sql);

$_columns = array (
	array ('name' => 'id', 'title' => 'Номер', 'ordered' => 1, 'order' => ($o_by == 'id' && $o ? 0 : 1), 'width' => '100'), 
	array ('name' => 'dt', 'title' => 'Дата', 'ordered' => 1, 'order' => ($o_by == 'dt' && $o ? 0 : 1), 'width' => '100'), 
	array ('name' => 'title', 'title' => 'Название', 'ordered' => 1, 'order' => ($o_by == 'title' && $o ? 0 : 1), 'ref' => '1'), 
	array ('name' => 'user', 'title' => 'Пользователь', 'ordered' => 1, 'order' => ($o_by == 'user' && $o ? 0 : 1)),
	array ('name' => 'answer_dt', 'title' => 'Дата ответа', 'ordered' => 1, 'order' => ($o_by == 'answer_dt' && $o ? 0 : 1), 'width' => '100'), 
	array ('name' => 'answered', 'title' => 'Ответил', 'ordered' => 1, 'order' => ($o_by == 'answered' && $o ? 0 : 1)),  
);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('question', $doc);
$_SMARTY->display('teacher/question_list.tpl');
?>