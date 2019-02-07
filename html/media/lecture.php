<?php
/*
 * Created on 07.02.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once '../set_env.inc.php';

$sql = 'SELECT *,ROUND(size/1024/1024, 2) AS size FROM media_lecture WHERE id=\''.addslashes($_REQUEST['id']).'\'';
$lecture = $_ADODB->GetRow($sql);
$sql = 'SELECT * FROM media_lecture_gallery WHERE lecture='.$lecture['id'];
$lecture['screen'] = $_ADODB->GetAll($sql); 

$_SMARTY->assign($lecture);
$_menu = array(
    array('path' => '/media/cat/mmmf', 'title' => 'Лекции, прочитанные на Малом мехмате МГУ'),
    array('path' => '/media/cat/dubna', 'title' => 'Лекции летней школы "Современная математика"'),
    array('path' => 'http://etudes.ru', 'title' => 'Математические этюды'),
);
$_SMARTY->assign('_menu', $_menu);
$_SMARTY->display('media/lecture.tpl');
?>
