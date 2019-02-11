<?php
require_once '../set_env.inc.php';
require_once 'courses.inc.php';

$_SMARTY->assign('courses', $courses);
$_SMARTY->display('teacher/course_picker.tpl');
?>
