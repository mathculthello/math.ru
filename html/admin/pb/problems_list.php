<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
//$_ADODB->debug=true;
//$_SMARTY->debugging = 1;
//var_dump($_REQUEST);

if(isset($_REQUEST['all'])) 
{
    unset($_SESSION['problems_search']);
    unset($_SESSION['problems_pager']);
}

if (isset($_REQUEST['search_id'])) 
{
    unset($_SESSION['problems_search']);
    unset($_SESSION['problems_pager']);
    $_SESSION['problems_search']['search_id'] = $_REQUEST['search_id'];
}

if (!empty($_SESSION['problems_search']['search_id'])) 
{
    $_where = 'p.problem_id='.$_SESSION['problems_search']['search_id'];
}


if (isset($_REQUEST['page'])) 
{ 
    $_SESSION['problems_pager']['page'] = $_REQUEST['page'];
}
if (isset($_REQUEST['n'])) 
{ 
    $_SESSION['problems_pager']['n'] = $_REQUEST['n'];
}
if (isset($_REQUEST['o'])) 
{ 
    $_SESSION['problems_pager']['o'] = $_REQUEST['o'];
}
if (isset($_REQUEST['o_by'])) 
{ 
    $_SESSION['problems_pager']['o_by'] = $_REQUEST['o_by'];
}
if (!isset($_SESSION['problems_pager']['n'])) 
{ 
    $_SESSION['problems_pager']['n'] = 20;
}
if (empty($_SESSION['problems_pager']['o_by'])) 
{
    $_SESSION['problems_pager']['o_by'] = 'id';
    $_SESSION['problems_pager']['o'] = 0;
}


$_ADODB->Execute('SET CHARACTER SET koi8r');
$_ADODB->Execute('USE problems');


if (!empty($_REQUEST['marker']) && !empty($_REQUEST['id']))
{
    $sql = 'SELECT COUNT(*) FROM math.pb_problems WHERE id='.$_REQUEST['id'];
    if ($_ADODB->GetOne($sql))
    {
        $sql = 'DELETE FROM math.pb_problems WHERE id='.$_REQUEST['id'];
        $_ADODB->Execute($sql);
    }
    else
    {
        $sql = 'SELECT content FROM ps_documents WHERE document_kind_id=1 AND problem_id='.$_REQUEST['id'].' ORDER BY document_id';
        $content = $_ADODB->GetOne($sql);
        $_ADODB->Execute('SET CHARACTER SET cp1251');
        $_ADODB->Execute('USE math');
        $sql = 'INSERT pb_problems (id,txt) VALUES ('.$_REQUEST['id'].',\''.mysql_escape_string(convert_cyr_string($content, 'k', 'w')).'\')';
        $_ADODB->Execute($sql);
        $_ADODB->Execute('SET CHARACTER SET koi8r');
        $_ADODB->Execute('USE problems');
    }
}

$paginator = new Paginator($_SESSION['problems_pager']['page'], array(0 => 'все', 10 => 10, 20 => 20, 50 => 50), $_SESSION['problems_pager']['n'], 15, $_SESSION['problems_pager']['o'], $_SESSION['problems_pager']['o_by']);
$paginator->itemsMessage = 'Всего';


$sql = 'SELECT COUNT(*) FROM ps_problems p'.($_where ? ' WHERE '.$_where : '');
$paginator->setItemsNumber($_ADODB->GetOne($sql));


$sql = 'SELECT p.problem_id AS id,p.difficulty,p.beauty,d.content AS text,IFNULL(pb.id,0) AS marker FROM ps_problems p,ps_documents d LEFT JOIN math.pb_problems pb ON pb.id=p.problem_id WHERE d.problem_id=p.problem_id AND d.document_kind_id=1 '.
($_where ? ' AND '.$_where.' ' : ' ').
'ORDER BY '.$paginator->orderBy.($paginator->order == 1 ? ' DESC' : '').
$paginator->limit;
$problems = $_ADODB->GetAll($sql);

while (list($k, $v) = each($problems))
{
    $problems[$k]['text'] = convert_cyr_string($problems[$k]['text'], 'k', 'w');
}

$_columns = array(
    array('name' => 'marker', 'title' => '', 'ordered' => 1, 'order' => ($paginator->orderBy=='mark' && $paginator->order ? 0 : 1), 'width' => 20, 'type' => 'marker', 'img' => '/i/checked.gif', 'img_width' => '14', 'img_height' => '14', 'img_off' => '/i/unchecked.gif', 'title' => 'Показывать на math.ru'),
    array('name' => 'id', 'title' => 'Номер', 'ordered' => 1, 'order' => ($paginator->orderBy=='id' && $paginator->order ? 0 : 1), 'width' => 100),
    array('name' => 'difficulty', 'title' => 'Сложность', 'ordered' => 1, 'order' => ($paginator->orderBy=='difficulty' && $paginator->order ? 0 : 1), 'width' => 100),
//    array('name' => 'beauty', 'title' => 'Красота', 'ordered' => 1, 'order' => ($paginator->orderBy=='difficulty' && $paginator->order ? 0 : 1), 'width' => 100),
    array('name' => 'text', 'title' => 'Условие', 'ordered' => 0, 'ref' => 1, 'width' => '*'),
);

require_once '../letters.inc.php';
$_SMARTY->assign('problems', $problems);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('search_id', $_REQUEST['search_id']);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->display('pb/problems_list.tpl');
?>