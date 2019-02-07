<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
//$_ADODB->debug=true;
//$_SMARTY->debugging = 1;
if(isset($_REQUEST['all'])) 
{
    unset($_SESSION['h_person_search']);
    unset($_SESSION['h_person_pager']);
}
if (isset($_REQUEST['letter'])) 
{
    unset($_SESSION['h_person_search']);
    unset($_SESSION['h_person_pager']);
    $_where = ' WHERE letter='.$_REQUEST['letter'];
    $_SESSION['h_person_search']['letter'] = $_REQUEST['letter'];
} 
if (isset($_REQUEST['lname'])) 
{
    unset($_SESSION['h_person_search']);
    unset($_SESSION['h_person_pager']);
    $_SESSION['h_person_search']['lname'] = $_REQUEST['lname'];
}

if (!empty($_SESSION['h_person_search']['lname'])) 
{
    $_where = ' WHERE lname LIKE \''.addslashes($_SESSION['h_person_search']['lname']).'%\'';
}
if (!empty($_SESSION['h_person_search']['letter'])) 
{
    $_where = ' WHERE letter = \''.addslashes($_SESSION['h_person_search']['letter']).'\'';
}


if (isset($_REQUEST['page'])) 
{ 
    $_SESSION['h_person_pager']['page'] = $_REQUEST['page'];
}
if (isset($_REQUEST['n'])) 
{ 
    $_SESSION['h_person_pager']['n'] = $_REQUEST['n'];
}
if (isset($_REQUEST['o'])) 
{ 
    $_SESSION['h_person_pager']['o'] = $_REQUEST['o'];
}
if (isset($_REQUEST['o_by'])) 
{ 
    $_SESSION['h_person_pager']['o_by'] = $_REQUEST['o_by'];
}
if (!isset($_SESSION['h_person_pager']['n'])) 
{ 
    $_SESSION['h_person_pager']['n'] = 20;
}
if (empty($_SESSION['h_person_pager']['o_by'])) 
{
    $_SESSION['h_person_pager']['o_by'] = 'lname';
    $_SESSION['h_person_pager']['o'] = 0;
}
$paginator = new Paginator($_SESSION['h_person_pager']['page'], array(0 => 'все', 10 => 10, 20 => 20, 50 => 50), $_SESSION['h_person_pager']['n'], 15, $_SESSION['h_person_pager']['o'], $_SESSION['h_person_pager']['o_by']);
$paginator->itemsMessage = 'Всего';


$sql = 'SELECT COUNT(*) FROM h_person'.$_where;
$paginator->setItemsNumber($_ADODB->GetOne($sql));

$sql = 'SELECT p.id,p.path,p.letter,p.fname,p.sname,p.lname FROM h_person p'.$_where;
$sql .= ' ORDER BY letter'.($paginator->order == 1 ? ' DESC' : '').',lname'.($paginator->order == 1 ? ' DESC' : '');
$sql .=  $paginator->limit;
$person = $_ADODB->GetAll($sql);

$_columns = array(
    array('name' => 'lname', 'title' => 'Фамилия', 'ordered' => 1, 'order' => ($paginator->orderBy=='lname' && $paginator->order ? 0 : 1), 'ref' => 1),
    array('name' => 'fname', 'title' => 'Имя', 'ordered' => 0),
    array('name' => 'sname', 'title' => 'Отчество', 'ordered' => 0),
    array('name' => 'path', 'title' => 'Путь', 'ordered' => 0),
);

require_once '../letters.inc.php';
$_SMARTY->assign('person', $person);
$_SMARTY->assign('lname', $_REQUEST['lname']);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->display('history/person_list.tpl');
?>