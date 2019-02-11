<?php
require_once '../../set_env.inc.php';
require_once '../menu.inc.php';
//$_ADODB->debug=true;

if (!empty ($_GET['path'])) {
	$where = 'p.path=\''.addslashes($_GET['path']).'\'';
}
elseif (!empty ($_GET['id'])) {
	$where = 'p.id='.addslashes($_GET['id']);
} else {
	exit;
}
//$sql = 'SELECT id,fname,sname,lname,portrait,portrait_width,portrait_height,thumb_width,thumb_height,REPLACE(shortbio,\'@@br@@\',\'\') AS shortbio,source,birth_date,death_date FROM h_person WHERE '.$where;
$sql = 'SELECT p.*,REPLACE(p.shortbio,\'@@br@@\',\'\') AS shortbio,COUNT(g.id) AS photo FROM h_person p LEFT JOIN h_person_gallery g ON g.person=p.id WHERE '.$where.' GROUP BY p.id';
$person = $_ADODB->GetRow($sql);
$sql = 'SELECT id,date,title,SUBSTRING_INDEX(text,\'@@br@@\',1) AS text,source FROM h_story,h_s2p WHERE h_story.id=h_s2p.story AND h_s2p.person='.$person['id'];
$story = $_ADODB->GetAll($sql);
$sql = 'SELECT t.id,p.path,p.lname,p.fname,p.sname FROM h_tree t,h_tree t1,h_person p WHERE t1.id='.$person['id'].' AND t1.lft BETWEEN t.lft AND t.rgt AND p.id=t.id ORDER BY t.lft';
$tree_path = $_ADODB->GetAll($sql);

if ($o_by == 'author') {
	$from = 'lib_b2a b2a,lib_book b,lib_b2a b2a1,h_person a1';
	$where = 'b2a.author='.$person['id'].' AND b.id=b2a.book AND b2a1.book=b.id AND a1.id=b2a1.author';
} else {
	$from = 'lib_book b,lib_b2a b2a';
	$where = 'b.id=b2a.book AND b2a.author='.$person['id'];
}
if (!empty ($type))
	$count_sql = 'SELECT COUNT(*) FROM lib_b2a b2a,lib_book b WHERE b2a.author='.$person['id'].' AND b.id=b2a.book AND b.type=\''.$type.'\'';
else
	$count_sql = 'SELECT COUNT(*) FROM lib_b2a WHERE author='.$person['id'];
$sql = 'SELECT '. ('').'b.id AS _key,LEFT(b.anno,400) AS anno, b.id,b.title,b.year,b.pages,ROUND(b.djvu/1024/1024,2) AS djvu,ROUND(b.pdf/1024/1024,2) AS pdf,ROUND(b.ps/1024/1024,2) AS ps,ROUND(b.html/1024/1024,2) AS html,ROUND(b.tex/1024/1024,2) AS tex,b.djvu_file,b.pdf_file,b.ps_file,b.html_file,b.tex_file'.',(CASE WHEN b.djvu_file!=\'\' THEN b.djvu_file WHEN b.pdf_file!=\'\' THEN b.pdf_file WHEN b.ps_file!=\'\' THEN b.ps_file WHEN b.tex_file!=\'\' THEN b.tex_file WHEN b.html_file!=\'\' THEN b.html_file ELSE b.id END) AS path '. ($o_by == 'author' ? ',MIN(a1.lname) AS author,MIN(a1.letter) AS letter ' : ' ').'FROM '.$from;
if (!empty ($type))
	$where .= ($where ? ' AND b.type=\''.$type.'\'' : 'b.type=\''.$type.'\'');
$sql .= ($where ? ' WHERE '.$where : ''). ($o_by == 'author' ? ' GROUP BY b.id' : '');
if ($o_by == 'title')
	$sql .= ' ORDER BY b.title'. ($o == 1 ? ' DESC' : '');
elseif ($o_by == 'year') $sql .= ' ORDER BY b.year'. ($o == 1 ? ' DESC' : '');
elseif ($o_by == 'pages') $sql .= ' ORDER BY b.pages'. ($o == 1 ? ' DESC' : '');
elseif ($o_by == 'author') $sql .= ' ORDER BY letter'. ($o == 1 ? ' DESC' : '').',author'. ($o == 1 ? ' DESC' : '').',b.title';
$books = $_ADODB->GetAssoc($sql);
if (!empty ($books)) {
	$sql = 'SELECT b2a.book,a.id,a.path,a.fname,a.sname,a.lname,a.letter,a.show_in_history FROM lib_b2a b2a,h_person a WHERE b2a.book IN('.implode(',', array_keys($books)).') AND a.id=b2a.author ORDER BY a.letter';
	$_authors = $_ADODB->GetAll($sql);
	while (list (, $v) = each($_authors))
		$books[$v['book']]['authors'][] = $v;
}

$_SMARTY->assign($person);
$_SMARTY->assign('story', $story);
$_SMARTY->assign('books', $books);
$_SMARTY->assign('tree_path', $tree_path);
$_SMARTY->display('history/people/person.tpl');
?>