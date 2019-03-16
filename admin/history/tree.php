<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'/dbtree/xdbtree.php';
//$_ADODB->debug = true;
//var_dump($_REQUEST);
$DBTREE = new XDBTree($_ADODB, 'h_tree', 'id', array('left' => 'lft', 'right' => 'rgt', 'level' => 'level', 'parent' => 'pid'));

$sql = 'SELECT id FROM h_tree WHERE level=0';
$root_id = $_ADODB->GetOne($sql);

if (!empty($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
} elseif (!empty($_REQUEST['search_string'])) {
    $sql = 'SELECT p.id,p.fname,p.sname,p.lname,p.path,p.birth_date,p.death_date FROM h_person p,h_tree t WHERE t.id=p.id AND p.lname LIKE \''.addslashes($_REQUEST['search_string']).'%\'';
    $search_results = $_ADODB->GetAll($sql);
    $search = true;
} elseif (!empty($_REQUEST['letter'])) {
    $sql = 'SELECT p.id,p.fname,p.sname,p.lname,p.path,p.birth_date,p.death_date FROM h_person p,h_tree t WHERE t.id=p.id AND p.letter=\''.(is_numeric($_REQUEST['letter'])?$_REQUEST['letter']:ord($_REQUEST['letter'])+1000).'\'';
    $search_results = $_ADODB->GetAll($sql);
    $search = true;
} else {
    $id = $root_id;
}

if (!empty($_REQUEST['person_to_insert'])) 
{
    $ids = explode(' ', ltrim($_REQUEST['person_to_insert']));
    if (is_array($ids))
    {
        while (list($k, $v) = each($ids))
        {
            $sql = 'SELECT t.id '.
            'FROM h_tree t, h_person p1, h_person p2 '.
            'WHERE t.pid='.$id.' AND p1.id='.$v.' AND p2.id=t.id AND p2.lname>p1.lname '.
            'ORDER BY p2.lname ';
            if ($before_id = $_ADODB->GetOne($sql)) 
            {
                $DBTREE->insertBefore($before_id, array('id' => $v));
            }
            else
            {
                $DBTREE->insert($id, array('id' => $v));
            }
        }
    }
}
if (!empty($_REQUEST['person_to_delete']) && $_REQUEST['person_to_delete'] != $root_id) 
{
    $sql = 'SELECT pid FROM h_tree WHERE id='.$_REQUEST['person_to_delete'];
    if (($id = $_ADODB->GetOne($sql)) && is_numeric($id))
    {
        $DBTREE->delete($_REQUEST['person_to_delete']);
    }
}

$sql = 'SELECT t.id,t.lft,t.rgt,t.pid,t.level,CONCAT(p.lname,\' \',p.fname,\' \',p.sname) as name FROM h_tree t,h_person p WHERE p.id=t.id ORDER BY t.lft';
$tree = $_ADODB->GetAll($sql);
$sql = 'SELECT id,thumb_width,thumb_height,CONCAT(fname,\' \',sname,\' \',lname) as fullname,portrait,portrait_width,portrait_height,REPLACE(shortbio,\'@@br@@\',\'\') AS shortbio,source,area FROM h_person WHERE id='.$id;
$info = $_ADODB->GetRow($sql);
$sql = 'SELECT t.id,p.path,p.lname,p.fname,p.sname FROM h_tree t,h_tree t1,h_person p WHERE t1.id='.$id.' AND t1.lft BETWEEN t.lft AND t.rgt AND p.id=t.id ORDER BY t.lft';
$tree_path = $_ADODB->GetAll($sql);

$_SMARTY->assign($info);
$_SMARTY->assign('id', $id);
$_SMARTY->assign('tree', $tree);
$_SMARTY->assign('tree_path', $tree_path);
$_SMARTY->assign('search_string', $search_string);
$_SMARTY->assign('search_results', $search_results);
$_SMARTY->assign('search', $search);
$_SMARTY->display('history/tree.tpl');
?>