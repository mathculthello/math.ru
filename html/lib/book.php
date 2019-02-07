<?php
require_once '../set_env.inc.php';

//$_ADODB->debug=TRUE;
//echo "<!--";
//var_dump($_SERVER);
//echo "-->";

$id = 0;
if (!empty($_REQUEST['path']))
{
//    $p = addslashes(rawurldecode($_REQUEST['path']));
//    TODO: workaround (& в именах файлов)
    if (strpos($_SERVER['REDIRECT_URL'], '.html'))
        $p = addslashes(substr($_SERVER['REDIRECT_URL'], 10, strlen($_SERVER['REDIRECT_URL'])-15)); //"/lib/book/... .html"
    else
        $p = addslashes(substr($_SERVER['QUERY_STRING'], 5)); // "path="
    $sql = 'SELECT id FROM lib_book WHERE djvu_file=\''.$p.'\' OR pdf_file=\''.$p.'\' OR ps_file=\''.$p.'\' OR tex_file=\''.$p.'\' OR html_file=\''.$p.'\' OR id=\''.$p.'\'';
    $id = $_ADODB->GetOne($sql);
}
elseif (!empty($_REQUEST['ser']) && !empty($_REQUEST['num']) && is_numeric($_REQUEST['num']))
{
    $sql = 'SELECT b.id FROM lib_book b,lib_series s WHERE s.path=\''.addslashes($_REQUEST['ser']).'\' AND b.series=s.id AND b.num=\''.addslashes($_REQUEST['num']).'\'';
    $id = $_ADODB->GetOne($sql);
}
elseif (!empty($_REQUEST['id']))
{
    $id = addslashes($_REQUEST['id']);
}

if(!empty($id) && is_numeric($id)) {
    $sql = "SELECT c1.id as num,c2.path,c2.name,c2.id FROM lib_catalog c1, lib_catalog c2, lib_b2c b2c WHERE b2c.book=".$id." AND c1.id=b2c.subject AND c1.lft BETWEEN c2.lft AND c2.rgt AND c2.pid!=0 ORDER BY num,c2.lft";
    $path = $_ADODB->GetAll($sql);
    $sql = 'SELECT lib_book.id,lib_series.path AS spath,lib_series.name AS sname,year,pages,copies,ISBN,series,num,title,subtitle,publ,anno,contents,biblio,djvu,pdf,ps,html,tex,djvu_file,pdf_file,ps_file,html_file,tex_file FROM lib_book LEFT JOIN lib_series ON lib_series.id=lib_book.series WHERE lib_book.id='.$id;
    $book = $_ADODB->GetRow($sql);
    $sql = 'SELECT a.id,a.path,IFNULL(s.lname,a.lname) AS lname,IFNULL(s.fname,a.fname) AS fname,IFNULL(s.sname,a.sname) AS sname,a.show_in_history FROM lib_b2a b2a INNER JOIN h_person a ON a.id=b2a.author LEFT JOIN h_person_spelling s ON b2a.spelling=s.id WHERE b2a.book='.$book['id'].' ORDER BY a.letter,a.lname';
    $book['authors'] = $_ADODB->GetAll($sql);
    $book['anno'] = replace_tex($book[anno], "/lib/img/imga_".$id."_");
//  $book[anno] = nl2br($book[anno]);
    $book['djvu'] = round($book[djvu]/1024/1024, 2);
    $book['pdf'] = round($book[pdf]/1024/1024, 2);
    $book['ps'] = round($book[ps]/1024/1024, 2);
    $book['html'] = round($book[html]/1024/1024, 2);
    $book['tex'] = round($book[tex]/1024/1024, 2);
//    $book[contents] = nl2br($book[contents]);
    $book['contents'] = replace_tex($book[contents], "/lib/img/imgc_".$id."_");
//    $book['contents'] = str_replace("@@href@@", "/lib/files/".$book[djvu_file]."?djvuopts&page=", $book[contents]);

} else {

//    echo '<!--';
//    var_dump($_SERVER);
//    echo '-->';
//    header("Location:/lib");
}


$nav_bar = array(
    array('url' => '/', 'name' => 'MATH.RU'),
    array('url' => '/lib', 'name' => 'Библиотека'),
    array('url' => '/lib/catalog.php', 'name' => 'Список книг'),
);

require 'navigation.inc.php';
$_SMARTY->assign($navigation);
$_SMARTY->assign('path', $path);
$_SMARTY->assign('nav_bar', $nav_bar);
$_SMARTY->assign('book', $book);
$_SMARTY->assign('djvu_file', $book['djvu_file']);
$_SMARTY->display('lib/book.tpl');
?>