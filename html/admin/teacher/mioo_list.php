<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
require_once '../../teacher/courses.inc.php';
//$_ADODB->debug = true;

if (isset($_POST['course']) || isset($_POST['sch_year'])) {
    $_SESSION['mioo_search']['course'] = $_POST['course'];
    $_SESSION['mioo_search']['sch_year'] = $_POST['sch_year'];
}

if (!isset ($n))
    $n = 50;
if (empty ($o_by)) {
    $o_by = 'lname';
    $o = 0;
}
$paginator = new Paginator($page, array (0 => 'все', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);
$paginator->itemsMessage = 'Всего зарегистрировано';

$sql_where = array("1 = 1");
if (!empty($_SESSION['mioo_search']['sch_year'])) {
	$sql_where[] .= "sch_year = '" . addslashes($_SESSION['mioo_search']['sch_year']) . "'";
}
if (!empty($_SESSION['mioo_search']['course'])) {
	$sql_where[] .= "course = '" . addslashes($_SESSION['mioo_search']['course']) . "'";
}

$sql = "SELECT COUNT(*) FROM user_mioo WHERE " . implode(" AND ", $sql_where);
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = "SELECT * FROM user_mioo WHERE " . implode(" AND ", $sql_where) . " ORDER BY " . $o_by . ($o == 1 ? ' DESC' : '').$paginator->limit;
$user = $_ADODB->GetAll($sql);

$_columns = array (
array ('name' => 'lname', 'title' => 'Фамилия', 'ordered' => 1, 'order' => ($o_by == 'lname' && $o ? 0 : 1), 'ref' => '1'), 
array ('name' => 'fname', 'title' => 'Имя', 'ordered' => 1, 'order' => ($o_by == 'fname' && $o ? 0 : 1)), 
array ('name' => 'sname', 'title' => 'Отчество', 'ordered' => 1, 'order' => ($o_by == 'sname' && $o ? 0 : 1)),  
array ('name' => 'course', 'title' => 'Курс', 'ordered' => 1, 'order' => ($o_by == 'course' && $o ? 0 : 1)),
array ('name' => 'sch_year', 'title' => 'Год', 'ordered' => 1, 'order' => ($o_by == 'sch_year' && $o ? 0 : 1))
);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('user', $user);
$_SMARTY->assign('sch_year', $_SESSION['mioo_search']['sch_year']);
$_SMARTY->assign('course', $_SESSION['mioo_search']['course']);
$_SMARTY->display('teacher/mioo_list.tpl');
?>