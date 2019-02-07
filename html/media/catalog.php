<?php
/*
 * Created on 07.02.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once '../set_env.inc.php';

$where = '';
if (!empty($_GET['cat_path'])) 
{
    $sql = 'SELECT * FROM media_cat WHERE path=\''.addslashes($_GET['cat_path']).'\'';
    $cat = $_ADODB->GetRow($sql);
    $where = ' WHERE l.cat='.$cat['id'];
}

$sql = 'SELECT l.*,ROUND(l.size/1024/1024, 2) AS size,g.ext AS screen,g.id AS img_id,g.width AS screen_width,g.height AS screen_height,g.thumb_width,g.thumb_height FROM media_lecture l LEFT JOIN media_lecture_gallery g ON g.lecture=l.id';
$sql .= $where.' GROUP BY l.id ORDER BY date DESC';
$lecture = $_ADODB->GetAll($sql);

$_menu = array(
    array('path' => '/media/cat/mmmf', 'title' => 'Лекции, прочитанные на Малом мехмате МГУ'),
    array('path' => '/media/cat/dubna', 'title' => 'Лекции летней школы "Современная математика"'),
    array('path' => 'http://etudes.ru', 'title' => 'Математические этюды'),
);
$_SMARTY->assign('_menu', $_menu);
$_SMARTY->assign('_path', '/media/cat/'.$cat['path']);
$_SMARTY->assign('lecture', $lecture);
$_SMARTY->assign('cat', $cat);
$_SMARTY->display('media/lecture_list.tpl');
?>
