<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
require_once INCLUDE_DIR.'/dbtree/database.php';
require_once INCLUDE_DIR.'/dbtree/dbtree.php';
//$_ADODB->debug = true;
//var_dump($_POST);

if (!isset($n)) $n = 10;
if (empty($o_by)) {
    $o_by = 'lname';
    $o = 1;
}
$paginator = new Paginator($page, array(0 => 'все', 10 => 10, 20 => 20, 50 => 50), $n, 15, $o, $o_by);
$paginator->itemsMessage = 'Всего';

if (isset($_POST['delete']) && is_array($_POST['selected']) && count($_POST['selected']) > 0) {
    $sql = 'DELETE FROM h_tree_new WHERE id IN('.implode($_POST['selected'], ',').')';
    $_ADODB->Execute($sql);
}

$sql = 'SELECT COUNT(*) FROM h_tree_new p WHERE p.tree_id IS NULL OR p.tree_id=0';
$paginator->setItemsNumber($_ADODB->GetOne($sql));
$sql = 'SELECT p.id,p.pid,p.lname,p.fname,p.sname,p1.lname AS plname,p1.fname AS pfname,p1.sname AS psname FROM h_tree_new p,h_person p1 WHERE (p.tree_id IS NULL OR p.tree_id=0) AND p1.id=p.pid '.
' ORDER BY '.$o_by.($o?'':' DESC').$paginator->limit;
$person_list = $_ADODB->GetAll($sql);

$_columns = array (
    array('name' => 'lname', 'title' => 'Фамилия', 'ordered' => 1, 'order' => ($o_by=='lname' && $o? 0 : 1), 'ref' => '1', 'width' => 100),
    array('name' => 'fname', 'title' => 'Имя', 'ordered' => 0, 'ref' => 1),
    array('name' => 'sname', 'title' => 'Отчество', 'ordered' => 0, 'ref' => 1),
    array('name' => 'plname', 'title' => 'Учитель', 'ordered' => 1, 'order' => ($o_by=='plname' && $o? 0 : 1)),
);
$_SMARTY->assign('_columns', $_columns);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('person_list', $person_list);
$_SMARTY->display('history/tree_new.tpl');


/*
 elseif (isset($_POST['publish']) && is_array($_POST['selected']) && count($_POST['selected']) > 0) {
        while (list( ,$id) = @each($_POST['selected'])) {
            $DB = new CDatabase($dbname, $dbserver, $dbuser, $dbpassword);
            $DBTREE = new CDBTree($DB, 'h_tree', 'id', array('left' => 'lft', 'right' => 'rgt', 'level' => 'level', 'parent' => 'pid'));
            $sql = 'SELECT pid,lname,fname,sname,area,shortbio,source,letter,portrait,portrait_width,portrait_height FROM h_tree_new WHERE id='.$id;
            $data = $_ADODB->GetRow($sql);
            $sql = 'SELECT * FROM h_person WHERE id = -1';
            $rs = $_ADODB->Execute($sql);
            $sql = $_ADODB->GetInsertSql($rs, $data);
            if ($_ADODB->Execute($sql)) {
                $new_id = $_ADODB->Insert_ID();
                $DBTREE->insert($data['pid'], array('id' => $new_id));
                if ($data['portrait']) {
                    rename($_SERVER['DOCUMENT_ROOT'].'/history/tree/new_portrait/'.$id.'.'.$data['portrait'], $_SERVER['DOCUMENT_ROOT'].'/history/people/portrait/'.$new_id.'.'.$data['portrait']);
                }
                $sql = 'DELETE FROM h_tree_new WHERE id='.$id;
                $_ADODB->Execute($sql);
            }
        }
    }
}

*/
?>