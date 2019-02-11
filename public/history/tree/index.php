<?php
require_once '../../set_env.inc.php';
require_once '../menu.inc.php';
//$_ADODB->debug = true;

unset($search_results);

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
} elseif (!empty($_GET['path'])) {
    $sql = 'SELECT id FROM h_person WHERE path=\''.addslashes($_GET['path']).'\'';
    $id = $_ADODB->GetOne($sql);
    if (!$id) {
        Header('Location:/history/people/'.$_GET['path']);
        exit;
    }
} elseif (!empty($_REQUEST['search_string'])) {
    $sql = 'SELECT p.id,p.fname,p.sname,p.lname,p.path,p.birth_date,p.death_date FROM h_person p,h_tree t WHERE t.id=p.id AND p.lname LIKE \''.addslashes($_REQUEST['search_string']).'%\'';
    $search_results = $_ADODB->GetAll($sql);
    if ( is_array($search_results) && count($search_results) == 1) 
    {
        Header('Location:/history/tree/'.$search_results[0]['path']);
        exit;
    }
} elseif (!empty($_REQUEST['letter'])) {
    $letter = is_numeric($_REQUEST['letter'])?$_REQUEST['letter']:ord($_REQUEST['letter'])+1000;
    $sql = 'SELECT p.id,p.fname,p.sname,p.lname,p.path,p.birth_date,p.death_date FROM h_person p,h_tree t WHERE t.id=p.id AND p.letter=\''.$letter.'\'';
    $search_results = $_ADODB->GetAll($sql);
} else {
    $sql = 'SELECT id FROM h_tree WHERE level=0';
    $id = $_ADODB->GetOne($sql);
} 

$sql = 'SELECT p.*,REPLACE(p.shortbio,\'@@br@@\',\'\') AS shortbio,COUNT(g.id) AS photo FROM h_person p LEFT JOIN h_person_gallery g ON g.person=p.id WHERE p.id='.$id.' GROUP BY p.id';
$data = $_ADODB->GetRow($sql);

$sql = 'SELECT t.id,p.path,t.lft,t.rgt,t.pid,t.level,p.letter,t1.lft AS plft,CONCAT(p.lname,\' \',LEFT(p.fname,1),IF(p.fname!=\'\',\'.\',\'\'),LEFT(p.sname,1),IF(p.sname!=\'\',\'.\',\'\')) as name FROM h_tree t LEFT JOIN h_tree t1 ON t1.id=t.pid, h_person p WHERE p.id=t.id ORDER BY t.lft';
$data['tree'] = $_ADODB->GetAll($sql);

$sql = 'SELECT t.id,p.path,p.lname,p.fname,p.sname FROM h_tree t,h_tree t1,h_person p WHERE t1.id='.$id.' AND t1.lft BETWEEN t.lft AND t.rgt AND p.id=t.id ORDER BY t.lft';
$data['tree_path'] = $_ADODB->GetAll($sql);

$sql = 'SELECT COUNT(*) FROM h_tree';
$data['total'] = $_ADODB->GetOne($sql);

/*
if (empty($id)) {
    $sql = 'SELECT id FROM h_tree WHERE level=0';
    $root_id = $id = $_ADODB->GetOne($sql);
} else {
    $root_id = $id;
    $sql = 'SELECT t2.level, t2.pid, MAX(t1.level-t2.level) AS depth FROM h_tree t1, h_tree t2 WHERE t2.id='.$id.' AND t1.lft BETWEEN t2.lft AND t2.rgt GROUP BY t2.id';
    $subtree = $_ADODB->GetRow($sql);
    if ($subtree['depth'] < 2 && $subtree['level'] > 0) {
        $sql = 'SELECT t2.id,t2.level,t2.pid,MAX(t1.level-t2.level) AS depth FROM h_tree t1, h_tree t2 WHERE t2.id='.$subtree['pid'].' AND t1.lft BETWEEN t2.lft AND t2.rgt GROUP BY t2.id';
        $subtree = $_ADODB->GetRow($sql);
        if ($subtree['depth'] >= 2 || $subtree['pid'] == 0) {
            $root_id = $subtree['id'];
        } elseif ($subtree['pid'] != 0) {
            $root_id = $subtree['pid'];
        }
    }
}

$sql = 'SELECT t.id,t.lft,t.rgt,t.pid,t.level,CONCAT(p.lname,\' \',p.fname,\' \',p.sname) as name FROM h_tree t,h_person p WHERE p.id=t.id ORDER BY t.lft';
$tree = $_ADODB->GetAll($sql);
$sql = 'SELECT id,CONCAT(fname,\' \',sname,\' \',lname) as fullname,portrait,portrait_width,portrait_height,REPLACE(shortbio,\'@@br@@\',\'\') AS shortbio,source FROM h_person WHERE id='.$id;
$info = $_ADODB->GetRow($sql);

if ($_POST['search'] && !empty($search_lname)) {
    $sql = 'SELECT p.id,CONCAT(p.fname,\' \',p.sname,\' \',p.lname) as fullname FROM h_person p,h_tree t WHERE t.id=p.id AND p.lname LIKE \''.$search_lname.'%\'';
    $search_results = $_ADODB->GetAll($sql);
}

$nav_bar = array(
array('name' => 'MATH.RU', 'url' => '/'),
array('name' => 'История математики', 'url' => '/history'),
array('name' => 'Древо Лузина', 'url' => '')
);
$search_fields = array(
array('type' => 'text', 'name' => 'search_lname', 'title' => 'Фамилия', 'value' => $search_lname, 'width' => '', 'height' => '')

);

$_SMARTY->assign('nav_bar', $nav_bar);
$_SMARTY->assign($info);
$_SMARTY->assign('id', $id);
$_SMARTY->assign('tree', $tree);
$_SMARTY->assign('search_fields', $search_fields);
$_SMARTY->assign('search_results', $search_results);
$_SMARTY->assign('search', $_POST['search']);
*/

function tree_cmp($node1, $node2) {
    if (!$node1['plft']) return 1;
    if (!$node2['plft']) return -1;
    if ($node1['plft'] > $node2['plft']) return 1;
    if ($node1['plft'] < $node2['plft']) return -1;
    if ($node1['letter'] == $node2['letter']) return 0;
    return ($node1['letter'] < $node2['letter']) ? -1 : 1; 
}

//usort($data['tree'], tree_cmp);

if (isset($search_results)) {
    $_SMARTY->assign('search_results', $search_results);
    $_SMARTY->assign('search_string', $search_string);
    $_SMARTY->assign('letter', $letter);
    $_SMARTY->display('history/tree/search_results.tpl');
} else {
    $_SMARTY->assign($data);
    $_SMARTY->display('history/tree/index.tpl');
}
?>