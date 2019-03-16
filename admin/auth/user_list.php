<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
//$_ADODB->debug=true;
//$_SMARTY->debugging = 1;
if(isset($_REQUEST['all'])) 
{
    unset($_SESSION['user_search']);
    unset($_SESSION['user_pager']);
}
if (isset($_REQUEST['search'])) 
{
    unset($_SESSION['user_search']);
    unset($_SESSION['user_pager']);
    $_SESSION['user_search']['fullname'] = $_REQUEST['fullname'];
}

if (!empty($_SESSION['user_search']['lname'])) 
{
    $_where = ' WHERE lname LIKE \''.addslashes($_SESSION['user_search']['lname']).'%\'';
}


if (isset($_REQUEST['page'])) 
{ 
    $_SESSION['user_pager']['page'] = $_REQUEST['page'];
}
if (isset($_REQUEST['n'])) 
{ 
    $_SESSION['user_pager']['n'] = $_REQUEST['n'];
}
if (isset($_REQUEST['o'])) 
{ 
    $_SESSION['user_pager']['o'] = $_REQUEST['o'];
}
if (isset($_REQUEST['o_by'])) 
{ 
    $_SESSION['user_pager']['o_by'] = $_REQUEST['o_by'];
}
if (!isset($_SESSION['user_pager']['n'])) 
{ 
    $_SESSION['user_pager']['n'] = 20;
}
if (empty($_SESSION['user_pager']['o_by'])) 
{
    $_SESSION['user_pager']['o_by'] = 'user_regdate';
    $_SESSION['user_pager']['o'] = 1;
}
$paginator = new Paginator($_SESSION['user_pager']['page'], array(0 => 'все', 10 => 10, 20 => 20, 50 => 50), $_SESSION['user_pager']['n'], 15, $_SESSION['user_pager']['o'], $_SESSION['user_pager']['o_by']);
$paginator->itemsMessage = 'Всего';

$sql = 'SELECT COUNT(*) FROM user u'.($_where ? ' WHERE '.$_where : '');
$paginator->setItemsNumber($_ADODB->GetOne($sql));

$sql = 'SELECT u.*,p.user_regdate FROM user u,phpbb_users p WHERE p.user_id=u.id '.($_where ? ' AND '.$_where : ' ').
'ORDER BY '.$paginator->orderBy.($paginator->order == 1 ? ' DESC' : '').' '.
$paginator->limit;
$user = $_ADODB->GetAll($sql);

$_columns = array(
    array('name' => 'login', 'title' => 'login', 'ordered' => 1, 'order' => ($paginator->orderBy=='login' && $paginator->order ? 0 : 1), 'ref' => 1),
    array('name' => 'lname', 'title' => 'Фамилия', 'ordered' => 1, 'order' => ($paginator->orderBy=='lname' && $paginator->order ? 0 : 1), 'ref' => 1),
    array('name' => 'fname', 'title' => 'Имя', 'ordered' => 1, 'order' => ($paginator->orderBy=='fname' && $paginator->order ? 0 : 1), 'ref' => 1),
    array('name' => 'sname', 'title' => 'Отчество', 'ordered' => 1, 'order' => ($paginator->orderBy=='sname' && $paginator->order ? 0 : 1), 'ref' => 1),
    array('name' => 'profile', 'title' => 'Категория', 'ordered' => 1, 'order' => ($paginator->orderBy=='profile' && $paginator->order ? 0 : 1)),
    array('name' => 'status', 'title' => 'Статус', 'ordered' => 1, 'order' => ($paginator->orderBy=='status' && $paginator->order ? 0 : 1)),
    array('name' => 'user_regdate', 'title' => 'Дата регистрации', 'ordered' => 1, 'order' => ($paginator->orderBy=='user_regdate' && $paginator->order ? 0 : 1),'type' => 'date', 'date_format' => '%d.%m.%Y'),
);

$_SMARTY->assign('user', $user);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->display('auth/user_list.tpl');
?>