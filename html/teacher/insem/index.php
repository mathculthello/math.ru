<?php
require_once '../../set_env.inc.php';
require_once '../menu.inc.php';
include_once 'Poll.class.php';
//$_ADODB->debug = true;

if (isset($_POST['send']) && isset($_POST['id']) && is_array($_POST['q'])) {
	if ($_user_loggedin || Poll::getVotesNum('opros_teorver', 'ip', $_SERVER['REMOTE_ADDR']) < 3) {
		Poll::saveAnswers('opros_teorver', $_POST['q'], $_user_id, $_SERVER['REMOTE_ADDR']);
	}
	$_SMARTY->assign('just_voted', 1);
}

$opros_teorver = Poll::getQuestions('opros_teorver');
$opros_teorver['result'] = Poll::getResults('opros_teorver');
$opros_teorver['votes_num'] = Poll::getVotesNum('opros_teorver', 'all');
$opros_teorver['id'] = 1;

if ($_user_loggedin) {
	$is_voted = Poll::getVotesNum('opros_teorver', 'user', $_user_id);
	$opros_teorver['user_result'] = Poll::getResults('opros_teorver', 'user', $_user_id);
} elseif (!$_user_loggedin) {
	$is_voted = Poll::getVotesNum('opros_teorver', 'ip', $_SERVER['REMOTE_ADDR']);
	$_SMARTY->assign('votes_left', 3 - $is_voted);
	$_SMARTY->assign('ip', $_SERVER['REMOTE_ADDR']);
}

$_SMARTY->assign('opros_teorver', $opros_teorver);
$_SMARTY->assign('is_voted', $is_voted);
$_SMARTY->display('teacher/insem/index.tpl');
?>