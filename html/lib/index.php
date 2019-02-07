<?php
require_once '../set_env.inc.php';
require_once '../function.inc.php';
$navigation['nav_bar'] = array(
    array('url' => '/', 'name' => 'MATH.RU'),
    array('url' => '', 'name' => 'Библиотека'),
);
unset($_SESSION['lib_search']);
require 'navigation.inc.php';
$_SMARTY->assign($navigation);
if ($_REQUEST['ad'])
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
$ad = $_ADODB->GetRow($sql);

$sql = 'SELECT p.fname,p.sname,p.lname FROM h_person p,lib_b2a b WHERE b.book='.$ad['book_id'].' AND p.id=b.author';
$ad['author'] = $_ADODB->GetAll($sql);

$ad['txt'] = replace_tex($ad['txt'], '/lib/ad/img/img_'.$ad['id'].'_');

$_SMARTY->assign('ad', $ad);
$_SMARTY->assign($_SESSION['lib_search']);
$_SMARTY->display('lib/index.tpl');
?>