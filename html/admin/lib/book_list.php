<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
//var_dump($_REQUEST);
//var_dump($_GET);
//var_dump($_SESSION);
//$_ADODB->debug=true;


if(isset($_GET['type'])) {
    $_SESSION['lib_search']['type'] = $type;
    unset($_SESSION['lib_book_pager']);
} elseif(isset($_GET['all'])) {
    unset($_SESSION['lib_search']);
    unset($_SESSION['lib_book_pager']);
    unset($lib_search);
} elseif(isset($_POST['search'])) {
    unset($_SESSION['lib_search']);
    unset($_SESSION['lib_book_pager']);
    unset($lib_search);
    $_SESSION['lib_search'] = $_POST;
} elseif(isset($_GET['rubr'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($_SESSION['lib_book_pager']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $_SESSION['lib_search']['rubr'] = $_GET['rubr'];
} elseif(isset($_GET['subj'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($_SESSION['lib_book_pager']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $_SESSION['lib_search']['subj'] = $_GET['subj'];
} elseif(isset($_GET['letter'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($_SESSION['lib_book_pager']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $_SESSION['lib_search']['letter'] = $_GET['letter'];
} elseif(isset($_GET['author'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($_SESSION['lib_book_pager']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $_SESSION['lib_search']['author'] = $_GET['author'];
}

if(is_array($_SESSION['lib_search']))
    extract($_SESSION['lib_search']);

if (isset($_REQUEST['page'])) 
{ 
    $_SESSION['lib_book_pager']['page'] = $_REQUEST['page'];
}
if (isset($_REQUEST['n'])) 
{ 
    $_SESSION['lib_book_pager']['n'] = $_REQUEST['n'];
}
if (isset($_REQUEST['o'])) 
{ 
    $_SESSION['lib_book_pager']['o'] = $_REQUEST['o'];
}
if (isset($_REQUEST['o_by'])) 
{ 
    $_SESSION['lib_book_pager']['o_by'] = $_REQUEST['o_by'];
}
if (!isset($_SESSION['lib_book_pager']['n'])) 
{ 
    $_SESSION['lib_book_pager']['n'] = 20;
}
if (empty($_SESSION['lib_book_pager']['o_by'])) 
{
    $_SESSION['lib_book_pager']['o_by'] = 'author';
    $_SESSION['lib_book_pager']['o'] = 0;
}
$paginator = new Paginator($_SESSION['lib_book_pager']['page'], array(0 => 'все', 10 => 10, 20 => 20, 50 => 50), $_SESSION['lib_book_pager']['n'], 15, $_SESSION['lib_book_pager']['o'], $_SESSION['lib_book_pager']['o_by']);
$paginator->itemsMessage = 'Всего книг';

$select = $from = $group = $order = $where = $count_sql = '';

if(isset($search)) {
    $_authors = explode(' ', $search_author);
    for($i = 0; $i < count($_authors); $i++) {
        $w = trim($_authors[$i]);
        if($w != '')
            $search_authors[] = addslashes($_authors[$i]);
    }
    $where_keywords = $where_authors = $where_fromyear = $where_toyear = '';
    if(is_array($search_authors)) {
        $_where = '';
        while(list($k, $a) = each($search_authors))
            $_where .= ($_where?' OR ':'').'lname LIKE \''.$a.'%\'';
        $sql = 'SELECT DISTINCT id FROM h_person WHERE '.$_where;
        $_author_ids  = $_ADODB->GetCol($sql);
        if(is_array($_author_ids) && count($_author_ids) > 0) {
            switch($author_options) {
                case 'and':
                    $_id = $_author_ids[0];
                    $sql = 'SELECT t0.book FROM lib_b2a t0';
                    $_where = ' WHERE t0.author='.$_id;
                    for($i = 1; $i < count($_author_ids); $i++) {
                        $sql .= ' LEFT JOIN lib_b2a t'.$i.' ON t0.book=t'.$i.'.book';
                        $_where .= ' AND t'.$i.'.author='.$_author_ids[$i];
                    }
                    $sql .= $_where;
                    break;
                default:
                    $sql = 'SELECT book FROM lib_b2a WHERE author IN ('.implode(',', $_author_ids).')';
            }
            $_authors_matches = $_ADODB->GetCol($sql);
            if(is_array($_authors_matches) && count($_authors_matches) > 0)
                $where_authors = 'b.id IN ('.implode(',', $_authors_matches).')';
            else
                $where_authors = '1=0';
        }
    }
    if(!empty($search_keyword)) {
        if($search_in == 'all')
            $_match = 'b.title,b.anno,b.contents';
        else 
            $_match = 'b.title';
        $where_keywords = 'MATCH('.$_match.') AGAINST(\''.$search_keyword.'\' IN BOOLEAN MODE)';
    } else {
        $where_keywords = '';
    }
    if(!empty($search_fromyear))
        $where_fromyear = 'b.year >= \''.$search_fromyear.'\'';
    if(!empty($search_toyear))
        $where_toyear = 'b.year <= \''.$search_toyear.'\'';

    if($where_authors != '')
        $where = $where_authors;
    if($where_keywords != '')
        $where .= ($where ? ' AND ' : '').$where_keywords;
    if($where_fromyear != '')
        $where .= ($where ? ' AND ' : '').$where_fromyear;
    if($where_toyear != '')
        $where .= ($where ? ' AND ' : '').$where_toyear;
    if (!empty($search_series))
    {
        $where .= ($where ? ' AND ' : '').' b.series='.$search_series;
    }
    if (!empty($search_subj))
    {
        $where .= ($where ? ' AND ' : '').' c.book=b.id AND c.subject='.$search_subj;
    }

	if($paginator->orderBy == 'author') {
		$count_sql = 'SELECT COUNT(*) FROM lib_book b';
        $count_where = $where;
        if (!empty($search_subj))
        {
            $count_sql .= ',lib_b2c c';
        }
		if(!empty($type))
		    $count_where .= ($count_where ? ' AND ':'').'b.type=\''.$type.'\'';
		$count_sql .= ($count_where?' WHERE '.$count_where:'');
		$from = 'lib_book b,lib_b2a b2a1,h_person a1';
        if (!empty($search_subj))
        {
            $from .= ',lib_b2c c';
        }
		$where .= ($where ? ' AND ' : '').'b2a1.book=b.id AND a1.id=b2a1.author';
	} else {
    	$from = 'lib_book b';
        if (!empty($search_subj))
        {
            $from .= ',lib_b2c c';
        }
	}
    $nav_path = array(array('name' => 'Результаты поиска', 'url' => ''));
    $search_mode = 'search';
} elseif(!empty($subj) && is_numeric($subj)) {
    $sql = 'SELECT c2.path,c2.name,c2.id FROM lib_catalog c1, lib_catalog c2 WHERE c1.id='.$subj.' AND c1.lft BETWEEN c2.lft AND c2.rgt AND c2.pid!=0 ORDER BY c2.lft';
    $parents = $_ADODB->GetAll($sql);
    $sql = 'SELECT c2.id FROM lib_catalog c1, lib_catalog c2 WHERE c1.id='.$subj.' AND c2.lft BETWEEN c1.lft AND c1.rgt';
    $children = $_ADODB->GetCol($sql);
	if($paginator->orderBy == 'author') {
		$from = 'lib_b2c b2c,lib_book b,lib_b2a b2a1,h_person a1';
		$where = 'b2c.subject IN ('.implode(',', $children).') AND b.id=b2c.book AND b2a1.book=b.id AND a1.id=b2a1.author';
	} else {
    	$from = 'lib_book b, lib_b2c b2c';
	    $where = 'b.id=b2c.book AND b2c.subject IN ('.implode(',', $children).')';
	}
    if(!empty($type))
    	$count_sql = 'SELECT COUNT(DISTINCT b.id) FROM lib_b2c b2c,lib_book b WHERE b2c.subject IN ('.implode(',', $children).') AND b.id=b2c.book AND b.type=\''.$type.'\'';
    else
	    $count_sql = 'SELECT COUNT(DISTINCT book) FROM lib_b2c WHERE subject IN ('.implode(',', $children).')';
    $nav_path = array();
    for($i = 0; $i < count($parents); $i++) {
        $nav_path[] = array('url' => ($i < count($parents)-1)?'/lib/catalog.php?subj='.$parents[$i]['id']:'', 'name' => $parents[$i]['name']);
    }
    $search_mode = 'subj';
} elseif(!empty($author) && is_numeric($author)) {
	if($paginator->orderBy == 'author') {
		$from = 'lib_b2a b2a,lib_book b,lib_b2a b2a1,h_person a1';
		$where = 'b2a.author='.$author.' AND b.id=b2a.book AND b2a1.book=b.id AND a1.id=b2a1.author';
	} else {
    	$from = 'lib_book b,lib_b2a b2a';
	    $where = 'b.id=b2a.book AND b2a.author='.$author;
	}
    if(!empty($type))
    	$count_sql = 'SELECT COUNT(*) FROM lib_b2a b2a,lib_book b WHERE b2a.author='.$author.' AND b.id=b2a.book AND b.type=\''.$type.'\'';
    else
    	$count_sql = 'SELECT COUNT(*) FROM lib_b2a WHERE author='.$author;
    $sql = 'SELECT a.id,CONCAT(a.fname,\' \',a.sname,\' \',a.lname) as fullname,a.portrait,a.portrait_width,a.portrait_height,SUBSTRING_INDEX(a.shortbio,\'@@br@@\',1) AS shortbio FROM h_person a WHERE a.id='.$author;
    $person = $_ADODB->GetRow($sql);
    $nav_path = array(array('name' => $person['fullname'], 'url' => ''));
    $search_mode = 'author';
} elseif(!empty($letter) && is_numeric($letter)) {
	if($paginator->orderBy == 'author') {
		$from = 'h_person a,lib_b2a b2a,lib_book b,lib_b2a b2a1,h_person a1';
		$where = 'a.letter='.$letter.' AND b2a.author=a.id AND b.id=b2a.book AND b2a1.book=b.id AND a1.id=b2a1.author';
	} else {
	    $from = 'lib_book b,h_person a,lib_b2a b2a';
    	$where = 'a.letter='.$letter.' AND b2a.author=a.id AND b.id=b2a.book';
	}
    if(!empty($type))
    	$count_sql = 'SELECT COUNT(DISTINCT b.id) FROM h_person a,lib_b2a b2a,lib_book b WHERE  a.letter='.$letter.' AND b2a.author=a.id AND b.id=b2a.book AND b.type=\''.$type.'\'';
    else
	    $count_sql = 'SELECT COUNT(DISTINCT b2a.book) FROM h_person a,lib_b2a b2a WHERE a.letter='.$letter.' AND b2a.author=a.id';
    $nav_path = array(array('name' => 'Алфавитный каталог', 'url' => ''), array('name' => chr(($letter>1000?$letter-1000:$letter)), 'url' => ''));
    $search_mode = 'letter';
} elseif(!empty($rubr) && is_numeric($rubr)) {
	if($paginator->orderBy == 'author') {
		$from = 'lib_b2r b2r,lib_book b,lib_b2a b2a1,h_person a1';
		$where = 'b2r.rubr='.$rubr.' AND b.id=b2r.book AND b2a1.book=b.id AND a1.id=b2a1.author';
	} else {
	    $from = 'lib_book b, lib_b2r b2r';
    	$where = 'b.id=b2r.book AND b2r.rubr='.$rubr;
	}
	if(!empty($type))
		$count_sql = 'SELECT COUNT(*) FROM lib_b2r b2r,lib_book b WHERE b2r.rubr='.$rubr.' AND b.id=b2r.book AND b.type=\''.$type.'\'';
    else
		$count_sql = 'SELECT COUNT(*) FROM lib_b2r WHERE rubr='.$rubr;
    $sql = 'SELECT name FROM lib_rubr WHERE id='.$rubr;
    $rubr_name = $_ADODB->GetOne($sql);
    $nav_path = array(array('name' => $rubr_name, 'url' => ''));
    $search_mode = 'rubr';
} else {
	if($paginator->orderBy == 'author') {
		if(!empty($type))
			$count_sql = 'SELECT COUNT(*) FROM lib_book b WHERE type=\''.$type.'\'';
		else
			$count_sql = 'SELECT COUNT(*) FROM lib_book b';
		$from = 'lib_book b,lib_b2a b2a1,h_person a1';
		$where = 'b2a1.book=b.id AND a1.id=b2a1.author';
	} else {
    	$from = 'lib_book b';
    	$where = '';
	}
    $nav_path = array();
    $search_mode = 'all';
}

//$sql = 'SELECT SQL_CALC_FOUND_ROWS b.id AS _key,b.id,b.title,b.year,b.pages,ROUND(b.djvu/1024/1024,2) AS djvu,ROUND(b.pdf/1024/1024,2) AS pdf,ROUND(b.ps/1024/1024,2) AS ps,ROUND(b.html/1024/1024,2) AS html,ROUND(b.tex/1024/1024,2) AS tex,b.djvu_file,b.pdf_file,b.ps_file,b.html_file,b.tex_file FROM '.$from;
//$paginator->setItemsNumber($_ADODB->GetOne('SELECT FOUND_ROWS()'));

$sql = 'SELECT '.('').'b.id AS _key,b.id,b.title,b.year,b.pages,ROUND(b.djvu/1024/1024,2) AS djvu,ROUND(b.pdf/1024/1024,2) AS pdf,ROUND(b.ps/1024/1024,2) AS ps,ROUND(b.html/1024/1024,2) AS html,ROUND(b.tex/1024/1024,2) AS tex,b.djvu_file,b.pdf_file,b.ps_file,b.html_file,b.tex_file'.
	($paginator->orderBy=='author'?',MIN(a1.lname) AS author,MIN(a1.letter) AS letter ':' ').
	'FROM '.$from;
if(!empty($type))
    $where .= ($where ? ' AND b.type=\''.$type.'\'' : 'b.type=\''.$type.'\'');
$sql .= ($where ? ' WHERE '.$where : '').
	($paginator->orderBy=='author'?' GROUP BY b.id':'');
if($paginator->orderBy == 'title')
    $sql .= ' ORDER BY b.title'.($paginator->order == 1 ? ' DESC' : '');
elseif($paginator->orderBy == 'author')
	$sql .= ' ORDER BY letter'.($paginator->order == 1 ? ' DESC' : '').',author'.($paginator->order == 1 ? ' DESC' : '').',b.title';
$sql .= $paginator->limit;
$books = $_ADODB->GetAssoc($sql);
$paginator->setItemsNumber($_ADODB->GetOne($count_sql?$count_sql:'SELECT COUNT(*) FROM '.$from.($where ? ' WHERE '.$where : '')));

/*
Сортировка по автору
'all','search':
SELECT b.id,b.title,MIN(a1.lname) AS author,MIN( a1.letter )  AS letter
FROM lib_book b, lib_b2a b2a1, h_person a1
WHERE b2a1.book = b.id AND a1.id = b2a1.author
GROUP 
BY b.id
ORDER  BY letter, author,title
'author':
SELECT b.id, b.title,MIN(a1.lname) AS author,MIN( a1.letter )  AS letter
FROM lib_b2a b2a,lib_book b, lib_b2a b2a1, h_person a1
WHERE b2a.author=5 AND b.id=b2a.book AND b2a1.book = b.id AND a1.id = b2a1.author
GROUP 
BY b.id
ORDER  BY letter, author,title
'letter':
SELECT b.id, b.title, MIN( a1.lname )  AS author, MIN( a1.letter )  AS letter
FROM h_person a, lib_b2a b2a, lib_book b, lib_b2a b2a1, h_person a1
WHERE a.letter = 216 AND b2a.author = a.id AND b.id = b2a.book AND b2a1.book = b.id AND a1.id = b2a1.author
GROUP 
BY b.id
ORDER  BY letter, author, title

'subj'
SELECT b.id, b.title, MIN( a1.lname )  AS author, MIN( a1.letter )  AS letter
FROM lib_b2c b2c, lib_book b, lib_b2a b2a1, h_person a1
WHERE b2c.subject IN (63,64,80) AND b.id = b2c.book AND b2a1.book = b.id AND a1.id = b2a1.author
GROUP 
BY b.id
ORDER  BY letter, author, title
'rubr'
SELECT b.id, b.title, MIN( a1.lname )  AS author, MIN( a1.letter )  AS letter
FROM lib_b2r b2r, lib_book b, lib_b2a b2a1, h_person a1
WHERE b2r.rubr=1 AND b.id = b2r.book AND b2a1.book = b.id AND a1.id = b2a1.author
GROUP 
BY b.id
ORDER  BY letter, author, title
*/

if(!empty($books)) {
    $sql = 'SELECT b2a.book,a.id,LEFT(a.fname,1) AS fname,LEFT(a.sname,1) AS sname,a.lname,a.letter FROM lib_b2a b2a,h_person a WHERE b2a.book IN('.implode(',', array_keys($books)).') AND a.id=b2a.author ORDER BY a.letter';
    $_authors = $_ADODB->GetAll($sql);
    while(list(,$v) = each($_authors))
        $books[$v['book']]['authors'][] = $v;
}

$navigation['nav_bar'] = array(array('url' => '/', 'name' => 'MATH.RU'));
if(!empty($nav_path)) {
    array_push($navigation['nav_bar'], array('url' => '/lib/', 'name' => 'Библиотека'));
    while(list(,$v) = each($nav_path))
        array_push($navigation['nav_bar'], $v);
} else {
    array_push($navigation['nav_bar'], array('url' => '', 'name' => 'Библиотека'));
}

if(!empty($_GET['type']))
    $_SESSION['lib_search']['type'] = $_GET['type'];
$r_letters = array('А','Б','В','Г','Д','Е','Ж','З','И','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я');
while(list($k,$v) = each($r_letters))
    $navigation['rus_letters'][ord($v)] = $v;
$l_letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
while(list($k,$v) = each($l_letters))
    $navigation['lat_letters'][ord($v)+1000] = $v;
$sql = 'SELECT c1.id, c1.pid, c1.path, c1.name, c1.lft, COUNT(*) AS level FROM lib_catalog c1, lib_catalog c2 WHERE c1.pid!=0 AND c1.lft BETWEEN c2.lft AND c2.rgt GROUP BY c1.id ORDER BY c1.lft';
$navigation['subjects'] = $_ADODB->GetAll($sql);
$sql = 'SELECT id, name FROM lib_rubr';
$navigation['rubricator'] = $_ADODB->GetAll($sql);
$navigation['types'] = array('book' => 'Книги', 'magazin' => 'Журналы', 'textbook' => 'Учебники', 'encycl' => 'Словари и энциклопедии');

$sql = 'SELECT id,name FROM lib_series ORDER BY name';
$navigation['series_options'] = $_ADODB->GetAssoc($sql);
$sql = 'SELECT id,name FROM lib_catalog WHERE pid!=0 ORDER BY lft';
$navigation['subj_options'] = $_ADODB->GetAssoc($sql);

$columns = array (
array ('name' => 'author', 'title' => 'Автор(ы)', 'width' => '150', 'ordered' => 1, 'order' => ($paginator->orderBy=='author' && $paginator->order? 0 : 1), 'type' => 'author_list'),
array ('name' => 'title', 'title' => 'Название', 'width' => '500', 'ordered' => 1, 'order' => ($paginator->orderBy=='title' && $paginator->order? 0 : 1), 'ref' => 1),
array ('name' => 'year', 'title' => 'Год', 'width' => '20'),
array ('name' => 'pages', 'title' => 'Стр.', 'width' => '20'),
array ('name' => 'djvu', 'title' => 'djvu', 'width' => '20'),
array ('name' => 'pdf', 'title' => 'pdf', 'width' => '20'),
array ('name' => 'ps', 'title' => 'ps', 'width' => '20'),
array ('name' => 'html', 'title' => 'html', 'width' => '20'),
array ('name' => 'tex', 'title' => 'tex', 'width' => '20'),
);

$_SMARTY->assign($navigation);
$_SMARTY->assign($_SESSION['lib_search']);
$_SMARTY->assign('_p', $paginator);
//$_SMARTY->assign(array('a_o'=>($paginator->orderBy=='author' && $paginator->order? 0 : 1), 't_o'=>($paginator->orderBy=='title' && $paginator->order? 0 : 1)));
$_SMARTY->assign('search_mode', $search_mode);
$_SMARTY->assign('books', $books);
$_SMARTY->assign('_columns', $columns);
$_SMARTY->assign('person', $person);
$_SMARTY->display('lib/book_list.tpl');
?>