<?php
require_once '../set_env.inc.php';
//$_ADODB->debug=true;
//print_r($_POST);

if (!empty($_POST['person_delete'])) 
{
    $request = process_post_input();
    if (is_array($_POST['person_to_delete'])) 
    {
        $request['person'] = array_diff($request['person'], $_POST['person_to_delete']);
    }
} 
elseif (!empty ($_REQUEST['person_to_insert'])) 
{
    $request = process_post_input();
    $ids = explode(' ', ltrim($_REQUEST['person_to_insert']));
    if (is_array($ids))
    {
        $request['person'] = array_merge($request['person'], $ids);
    }
}
elseif ($_POST['story']) 
{
    $request = process_post_input();
	if (empty($request['title'])) 
    {
		$_ERROR_MESSAGE[] = 'Не введено название очерка';
    }
	if (empty($request['text'])) {
		$_ERROR_MESSAGE[] = 'Не введен текст очерка';
    }
    
	if (!empty($_POST['save']) && count($_ERROR_MESSAGE) == 0) 
    { 
		if (!empty($request['id'])) 
        {
            $sql = 'SELECT * FROM h_story WHERE id='.$request['id'];
            $rs = $_ADODB->Execute($sql);
            if ($sql = $_ADODB->GetUpdateSQL($rs, $request, true)) 
            {
                if (!$_ADODB->Execute($sql)) 
                {
                    $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg(); 
                }
            } 
            else 
            {
                $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg(); 
            }

            $sql = 'DELETE FROM h_s2p WHERE story='.$request['id'];
            $_ADODB->Execute($sql);
            while (list (, $v) = @ each($_POST['person'])) {
                $sql = 'INSERT h_s2p (story,person) VALUES ('.$request['id'].','.$v.')';
                $_ADODB->Execute($sql);
            }
            $msg = 'update';
	    } 
        else 
        {
            $sql = 'SELECT * FROM h_story WHERE id=-1';
            $rs = $_ADODB->Execute($sql);
            if ($sql = $_ADODB->GetInsertSQL($rs, $request)) 
            {
                if ($_ADODB->Execute($sql)) 
                {
                    $request['id'] = $_ADODB->Insert_ID();
                } 
                else 
                {
                    $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
                }
            } 
            else 
            {
                $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
            }

//            while(list( , $v) = @each($_POST[personID])) {
//                $sql = "INSERT h_s2p (story, person) VALUES (".$id.", ".$v.")";
//                $_ADODB->Execute($sql);
//            }
			$msg = 'insert';
	    }
	  	
	} 
    elseif(!empty($_POST['delete']) && !empty($request['id'])) 
    {
        $sql = 'DELETE FROM h_story WHERE id='.$request['id'];
        $_ADODB->Execute($sql);
        $sql = 'DELETE FROM h_s2p WHERE person='.$request['id'];
        $_ADODB->Execute($sql);
        unset($request);
        $msg = 'delete';
    }
} 
else 
{
	if (!empty($_REQUEST['id']) && is_numeric($_REQUEST['id'])) 
    {
		$sql = 'SELECT * FROM h_story WHERE id='.$_REQUEST['id'];
		$request = $_ADODB->GetRow($sql);

        $sql = 'SELECT person,1 FROM h_s2p WHERE story='.$_REQUEST['id'];
        $request['person'] = @ array_keys($_ADODB->GetAssoc($sql));
	} 
}

if ($msg == "insert") 
{
    $_MESSAGE = "Информация добавлена";
}
elseif ($msg == "update") 
{
    $_MESSAGE = "Изменения сохранены";
}
elseif ($msg == "delete") 
{
    $_MESSAGE = "Информация удалена";
}

$request['person_columns'] = array(
array('name' => 'name', 'title' => 'ФИО', 'ref' => 1),
);
if (is_array($request['person']) && count($request['person'])) {
    $sql = 'SELECT id,CONCAT(lname,\' \',fname,\' \',sname) AS name FROM h_person WHERE id IN ('.implode(',', $request['person']).')';
    $request['person_list'] = $_ADODB->GetAll($sql);
}

$_SMARTY->assign($request);
$_SMARTY->assign('error_message', $_ERROR_MESSAGE);
$_SMARTY->assign('message', $_MESSAGE);
$_SMARTY->assign('page', $page);
$_SMARTY->assign('o_by', $o_by);
$_SMARTY->assign('o', $o);
$_SMARTY->assign('n', $n);
if ($_REQUEST['short']) 
{
    $_SMARTY->assign($_GET);
    $_SMARTY->display('history/story_short.tpl');
}
else
{
    $_SMARTY->display('history/story.tpl');
}
?>