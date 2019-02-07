<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'/dbtree/database.php';
require_once INCLUDE_DIR.'/dbtree/dbtree.php';
//$_ADODB->debug=true;
//print_r($_POST);
$DB = new CDatabase($dbname, $dbserver, $dbuser, $dbpassword);
$DBTREE = new CDBTree($DB, "lib_catalog", "id", array("left" => "lft", "right" => "rgt", "level" => "level", "parent" => "pid"));

if ($_POST['subj']) {
    foreach($_POST as $key => $value) { 
        if(is_array($value)) {
            $request[$key] = $value;
            continue;
        }
        $value = trim($value); // убираем пробелы в начале и в конце переменной. 
        if (get_magic_quotes_gpc()) $value = stripslashes($value); //убираем слеши, если надо 
        $value = htmlspecialchars($value); //заменяем служебные символы HTML на эквиваленты 
        $_POST[$key] = $value; //все изменения записываем в массив $_POST 
        $value = addslashes($value);
        $request[$key] = $value; //и присваиваем новые значения элементам массива $request.
    } 
    //дальше проверяем поля формы
    if(empty($request[name]))
        $_ERROR_MESSAGE[] = 'Не введено название раздела';
    if(!empty($id) && ($request[pid] == $id))
        $_ERROR_MESSAGE[] = 'Неверно указан родительский раздел';

    if(!empty($_POST[save]) && count($_ERROR_MESSAGE) == 0) { 
        if(!empty($id)) {
        // редактирование
            $sql = 'UPDATE lib_catalog SET name=\''.$request['name'].'\',path=\''.$request['path'].'\' WHERE id='.$id;
            $_ADODB->Execute($sql);
            if(!empty($request[movebooks]) && !empty($request[moveto])) {
                $sql = "UPDATE lib_b2c SET subject=".$request[moveto]." WHERE subject=".$id;
                $_ADODB->Execute($sql);
            }
            $DBTREE->moveAll($id, $request['pid']);
            $msg = 'update';
        } else {
        // добавление
            $id = $DBTREE->insert($request[pid], array('name' => $request['name'], 'path' => $request['path']));
            $msg = 'add';
        }
        Header("Location: ".$_SERVER['PHP_SELF']."?msg=".$msg."&id=".$id);
        exit;
    } elseif(!empty($_POST[remove])) {
        if(!empty($request[movebooks]) && !empty($request[moveto]))
            $sql = "UPDATE lib_b2c SET subject=".$request[moveto]." WHERE subject=".$id;
        else
            $sql = "DELETE FROM lib_b2c WHERE subject=".$id;
        $_ADODB->Execute($sql);
        $DBTREE->delete($id);
        Header("Location: ".$_SERVER['PHP_SELF']."?msg=remove");
        exit;
    }
} else { // GET (редактирование или добавление)
        if(!empty($_GET['id']) && is_numeric($_GET['id'])) { // редактирование
                $sql = "SELECT id,pid,lft,rgt,level,name,path FROM lib_catalog WHERE id=".$id;
                $_POST = $_ADODB->GetRow($sql);
        $sql = "SELECT COUNT(*) FROM lib_b2c WHERE subject=".$id;
        $_POST[books_num] = $_ADODB->GetOne($sql);
            $sql = 'SELECT '.('').'b.id AS _key,b.id,b.title,b.year,b.pages,ROUND(b.djvu/1024/1024,2) AS djvu,ROUND(b.pdf/1024/1024,2) AS pdf,ROUND(b.ps/1024/1024,2) AS ps,ROUND(b.html/1024/1024,2) AS html,ROUND(b.tex/1024/1024,2) AS tex,b.djvu_file,b.pdf_file,b.ps_file,b.html_file,b.tex_file'.
                ' FROM lib_book b,lib_b2c b2c WHERE b.id=b2c.book AND b2c.subject='.$_GET['id'].' ORDER BY b.title';
            $books = $_ADODB->GetAssoc($sql);
            if(!empty($books)) {
                $sql = 'SELECT b2a.book,a.id,LEFT(a.fname,1) AS fname,LEFT(a.sname,1) AS sname,a.lname,a.letter FROM lib_b2a b2a,h_person a WHERE b2a.book IN('.implode(',', array_keys($books)).') AND a.id=b2a.author ORDER BY a.letter';
                $_authors = $_ADODB->GetAll($sql);
                while(list(,$v) = each($_authors))
                    $books[$v['book']]['authors'][] = $v;
            }
        } elseif (!empty($_GET['pid']) && is_numeric($_GET['pid'])) {
            $_POST['pid'] = $_GET['pid'];
        }
        if($msg == "add")
                $_MESSAGE = "Раздел добавлен";
        elseif($msg == "update")
                $_MESSAGE = "Изменения сохранены";
    elseif($msg == "remove")
        $_MESSAGE = "Раздел удален";
}

$sql = "SELECT id,lft,rgt,pid,level,name,path FROM lib_catalog ORDER BY lft";
$rs = $_ADODB->Execute($sql);
$_POST[catalog] = $rs->GetAssoc();

$_SMARTY->assign($_POST);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->assign('books', $books);
$_SMARTY->display('lib/catalog.tpl');
?>