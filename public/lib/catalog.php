<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'Paginator.class.php';
$page = $_GET['page'];
$o_by = $_GET['o_by'];
$n = $_GET['n'];
$o = $_GET['o'];
//echo "<!--";
//var_dump($_POST);
//echo '<br>';
//var_dump($_GET);
//echo '<br>';
//var_dump($_SESSION);
//ob_flush();
//flush();
//$_ADODB->debug=true;
if(!isset($n)) $n = 20;
if (empty($o_by))
{
    if (!empty($_GET['s_path']))
    { // на страницах серии по умолчанию сортировка по номеру книги в серии
        $o_by = 'num';
    } elseif (!empty($_REQUEST['search']))
    { // при поиске по умолчанию сортировка по релевантности
        $o_by = 'score';
    }
    else
    {
        $o_by = 'author';
    }
    $o = 0;
}
$paginator = new Paginator($page, array(0 => 'все', 20 => 20, 50 => 50), $n, 15, $o, $o_by);
$paginator->itemsMessage = 'Всего книг';

// список выбираемых полей
$sql_select = array();
// группировать по идентификатору книги?
// нужно в случае упорядочения по автроам (т.к. происходит объединение с таблицей lib_author)
// и в случае полнотекстового поиска (объединение с lib_pages_index)
$sql_group_by = "";

$sql_from = array("lib_book b");
$sql_where = array("1 = 1");
$sql_join = "";

if ($o_by == 'author') {
	$sql_select[] = "MIN(a1.lname) AS author, MIN(a1.letter) AS letter";
	$sql_from[] = "lib_b2a b2a1, h_person a1";
    $sql_where = array("b2a1.book = b.id AND a1.id = b2a1.author");
    $sql_group_by = "GROUP BY b.id";
}


if (isset($_GET['type'])) {
    $_SESSION['lib_search']['type'] = $type;
} elseif (isset($_GET['all'])) {
    unset($_SESSION['lib_search']);
    unset($lib_search);
} elseif (isset($_POST['search'])) {
    unset($_SESSION['lib_search']);
    unset($lib_search);
    $_SESSION['lib_search'] = $_POST;
} elseif (!empty($_GET['rubr'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $_SESSION['lib_search']['rubr'] = $_GET['rubr'];
} elseif (!empty($_GET['r_path'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $sql = 'SELECT id FROM lib_rubr WHERE path=\'' . $_GET['r_path'] . '\'';
    $_SESSION['lib_search']['rubr'] = $_ADODB->GetOne($sql);;
} elseif (!empty($_GET['subj'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $_SESSION['lib_search']['subj'] = $_GET['subj'];
} elseif (!empty($_GET['c_path'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $sql = 'SELECT id FROM lib_catalog WHERE path=\''.$_GET['c_path'].'\'';
    $_SESSION['lib_search']['subj'] = $_ADODB->GetOne($sql);;
} elseif (!empty($_GET['letter'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $_SESSION['lib_search']['letter'] = $_GET['letter'];
} elseif (!empty($_GET['l'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $_SESSION['lib_search']['letter'] = (is_numeric($_GET['l'])?$_GET['l']:ord($_GET['l'])+1000);
} elseif (!empty($_GET['author'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $_SESSION['lib_search']['author'] = $_GET['author'];
} elseif (!empty($_GET['a_path'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($lib_search);
    $_SESSION['lib_search'] = array();
    $_SESSION['lib_search']['type'] = $type;
    $sql = 'SELECT id FROM h_person WHERE path=\''.$_GET['a_path'].'\'';
    $_SESSION['lib_search']['author'] = $_ADODB->GetOne($sql);
} elseif (!empty($_GET['s_path'])) {
    $type = $_SESSION['lib_search']['type'];
    unset($_SESSION['lib_search']);
    unset($lib_search);
    $_SESSION['lib_search']['type'] = $type;
    $sql = 'SELECT id FROM lib_series WHERE path=\''.$_GET['s_path'].'\'';
    $_SESSION['lib_search']['ser'] = $_ADODB->GetOne($sql);;
} elseif (!isset($_GET['search'])) {
//    $row_count = $_SESSION['lib_search']['row_count'];
    unset($_SESSION['lib_search']);
    unset($lib_search);
//    $_SESSION['lib_search']['row_count'] = $row_count;
}

if (is_array($_SESSION['lib_search'])) {
    extract($_SESSION['lib_search']);
}

if (isset($search)) {

    $_authors = explode(' ', $search_author);

    for ($i = 0; $i < count($_authors); $i++) {
        $w = trim($_authors[$i]);
        if ($w != '')
            $search_authors[] = addslashes($_authors[$i]);
    }
	// поиск по авторам
    if (is_array($search_authors)) {
        $_where = '';
        $_author_ids = array();
        $_author_groups = array();
        while (list($k, $a) = each($search_authors)) {
            $sql = 'SELECT DISTINCT p.id FROM h_person p LEFT JOIN h_person_spelling s ON s.person=p.id WHERE (p.lname LIKE \''.$a.'%\' OR s.lname LIKE \''.$a.'%\')'.(count($_author_ids)?' AND id NOT IN('.implode(',', $_author_ids).')':'');
            $_author_groups[]  = $_ADODB->GetCol($sql);
            $_author_ids = array_merge($_author_ids, $_author_groups[count($_author_groups)-1]);
        }
        if (is_array($_author_ids) && count($_author_ids) > 0) {
            switch($author_options) {
                case 'and':
                    $sql = 'SELECT t0.book FROM lib_b2a t0';
                    $_where = ' WHERE t0.author IN ('.implode(',',$_author_groups[0]).')';
                    for ($i = 1; $i < count($_author_groups); $i++) {
                        if (count($_author_groups[$i]) > 0) {
                            $sql .= ' LEFT JOIN lib_b2a t'.$i.' ON t0.book=t'.$i.'.book';
                            $_where .= ' AND t'.$i.'.author IN ('.implode(',', $_author_groups[$i]).')';
                        }
                    }
                    $sql .= $_where;
                    break;
                default:
                    $sql = 'SELECT book FROM lib_b2a WHERE author IN ('.implode(',', $_author_ids).')';
            }
            $_authors_matches = $_ADODB->GetCol($sql);
        }

        if (is_array($_authors_matches) && count($_authors_matches) > 0) {
            $sql_search_where[] = "b.id IN (" . implode(",", $_authors_matches). ")";
        } else {
            $sql_search_where[] = "1 = 0";
        }
    }
	// поиск по ключевым словам
   	$sql_search_select = "'' AS matched_pages, 1 AS score";
    if (!empty($search_keyword)) {
        if ($search_in == 'all') {
	        $sql_search_where[] = "MATCH(b.title, b.anno, b.contents) AGAINST('" . $search_keyword . "' IN BOOLEAN MODE)";
        } elseif ($search_in == 'fulltext') {
        	$_ADODB->Execute("SET SESSION group_concat_max_len = 1024");
	        $sql_search_where[] = "MATCH(p.txt) AGAINST('" . $search_keyword . "' IN BOOLEAN MODE)";
	    	$sql_search_join = " LEFT JOIN lib_pages_index p ON p.book = b.id";
			$sql_search_select = "GROUP_CONCAT(DISTINCT p.page ORDER BY p.page SEPARATOR ', ') AS matched_pages, SUM(MATCH(p.txt) AGAINST('" . $search_keyword . "' IN BOOLEAN MODE)) As score";
	    	$sql_search_group_by = "GROUP BY b.id";
        } else {
	        $sql_search_where[] = "MATCH(b.title) AGAINST('" . $search_keyword . "' IN BOOLEAN MODE)";
        }
    }
    // поиск по году издания
    if (!empty($search_fromyear)) {
        $sql_search_where[] = "b.year >= '" . $search_fromyear . "'";
    }
    if (!empty($search_toyear)) {
        $sql_search_where[] = "b.year <= '" . $search_toyear . "'";
    }

	if (!empty($search_again)) {
		// поиск в найденном
		// выбрать результаты прошлого поиска
		$sql = "SELECT book FROM lib_search WHERE id = '" . addslashes($search_again) . "'";
		$search_books = $_ADODB->GetCol($sql);
		$sql_search_where[] = "b.id IN (" . implode(",", $search_books) . ")";
		$search_id = md5(implode(" AND ", $sql_search_where));
		// выполнить новый поиск
		$sql = "
			INSERT
				lib_search (id, ts, book, pages, score)
			SELECT
				'" . $search_id . "', NOW(), b.id, " . $sql_search_select . "
			FROM
				lib_book b
				" . $sql_search_join . "
			WHERE
				" . implode(" AND ", $sql_search_where) . "
				" . $sql_search_group_by
		;
		$_ADODB->Execute($sql);
	} elseif (!empty($search_id)) {
		// листалка
	} else {
		// новый поиск
		$search_id = md5(implode(" AND ", $sql_search_where));
		// посмотреть в базе результат для аналогичного запроса
		$sql = "SELECT ts FROM lib_search WHERE id = '" . $search_id . "' ORDER BY ts";
		$ts = $_ADODB->GetOne($sql);
		if (!$ts || strtotime($ts) < strtotime('-1 day')) {
			// нет сохраненных результатов или они устарели
			if ($ts) {
				// результат устарел, удаляем его
				$sql = "DELETE FROM lib_search WHERE id = '" . $search_id . "'";
				$_ADODB->Execute($sql);
			}
			// выполняем поиск и запоминаем результат
			$sql = "
				INSERT
					lib_search (id, ts, book, pages, score)
				SELECT
					'" . $search_id . "', NOW(), b.id, " . $sql_search_select . "
				FROM
					lib_book b
					" . $sql_search_join . "
				WHERE
					" . implode(" AND ", $sql_search_where) . "
					" . $sql_search_group_by
			;
			$_ADODB->Execute($sql);
		}
	}

	$sql_from[] = 'lib_search ls';
    $sql_where[] = "ls.id = '" . addslashes($search_id) . "' AND b.id = ls.book";
    $sql_select[] = "ls.score, ls.pages AS matched_pages";

    $search_mode = 'search';

} elseif (!empty($subj) && is_numeric($subj)) {
    $sql = 'SELECT c2.id FROM lib_catalog c1, lib_catalog c2 WHERE c1.id='.$subj.' AND c2.lft BETWEEN c1.lft AND c1.rgt';
    $children = $_ADODB->GetCol($sql);

    $sql_from[] = "lib_b2c b2c";
    $sql_where[] = "b.id = b2c.book AND b2c.subject IN (" . implode(",", $children) . ")";

    $search_mode = 'subj';
    $sql = 'SELECT path FROM lib_catalog WHERE id = ' . $subj;
    $search_path = $_ADODB->GetOne($sql);
} elseif(!empty($author) && is_numeric($author)) {
    $sql_from[] = "lib_b2a b2a";
    $sql_where[] = "b.id = b2a.book AND b2a.author = " . $author;

    $sql = 'SELECT *,REPLACE(shortbio, \'@@br@@\',\'\') AS shortbio FROM h_person WHERE id='.$author;
    $person = $_ADODB->GetRow($sql);

    $search_mode = 'author';
    $search_path = $person['path'];
} elseif(!empty($letter) && is_numeric($letter)) {
    $sql_from[] = "h_person a, lib_b2a b2a";
    $sql_where[] = "a.letter = " . $letter . " AND b2a.author = a.id AND b.id = b2a.book";
    $sql_group_by = "GROUP BY b.id";

    $search_mode = 'letter';
    $search_path = $letter;
} elseif(!empty($rubr) && is_numeric($rubr)) {
    $sql_from[] = "lib_b2r b2r";
    $sql_where[] = "b.id = b2r.book AND b2r.rubr = " . $rubr;

    $search_mode = 'rubr';

    $sql = 'SELECT path FROM lib_rubr WHERE id='.$rubr;
    $search_path = $_ADODB->GetOne($sql);

} elseif (!empty($ser) && is_numeric($ser)) {
    $sql_where[] = "b.series = ". $ser;

    $sql = 'SELECT id,path,name,descr FROM lib_series WHERE id='.$ser;
    $ser_info = $_ADODB->GetRow($sql);

    $search_mode = 'ser';
    $search_path = $ser_info['path'];
} else {
    $nav_path = array();
    $search_mode = 'all';
}

if (!empty($type)) {
    $sql_where[] = "b.type = '". $type . "'";
}

if ($o_by == 'title') {
    $sql_order_by = "b.title";
} elseif ($o_by == 'year') {
    $sql_order_by = "b.year";
} elseif ($o_by == 'pages') {
    $sql_order_by = "b.pages";
} elseif ($o_by == 'num') {
    $sql_order_by = "b.num";
} elseif ($o_by == 'author') {
    $sql_order_by = "letter" . ($o == 1 ? " DESC" : "") . ", author" . ($o == 1 ? " DESC" : "") . ", b.title";
} elseif ($o_by == 'score') {
    $sql_order_by = "score DESC, b.title";
}


$sql = "
	SELECT ". (empty($_SESSION['lib_search']['row_count']) ? "SQL_CALC_FOUND_ROWS" : "") ."
		b.id AS _key, b.id, b.title,
		b.year, b.pages, b.num,
		ROUND(b.djvu/1024/1024, 2) AS djvu,
		ROUND(b.pdf/1024/1024, 2) AS pdf,
		ROUND(b.ps/1024/1024, 2) AS ps,
		ROUND(b.html/1024/1024, 2) AS html,
		ROUND(b.tex/1024/1024, 2) AS tex,
		b.djvu_file, b.pdf_file, b.ps_file, b.html_file, b.tex_file,
		CASE
			WHEN b.djvu_file != '' THEN b.djvu_file
			WHEN b.pdf_file != '' THEN b.pdf_file
			WHEN b.ps_file != '' THEN b.ps_file
			WHEN b.tex_file != '' THEN b.tex_file
			WHEN b.html_file != '' THEN b.html_file
			ELSE b.id
		END AS path,
		b.anno,
		s.path AS series
		" . (count($sql_select) > 0 ? ", " : "") . implode(",", $sql_select) . "
	FROM
		" . implode(",", array_reverse($sql_from)) . $sql_join . "
		LEFT JOIN lib_series s ON s.id = b.series
	WHERE
		" . implode(" AND ", $sql_where) .
		" " . $sql_group_by . "
	ORDER BY
		" . $sql_order_by . ($o == 1 ? " DESC " : " ")
		. $paginator->limit
;

//echo "<!--\n";
//echo $sql;
//echo "\n-->\n";

$books = $_ADODB->GetAssoc($sql);

if (empty($_SESSION['lib_search']['row_count'])) {
	$_SESSION['lib_search']['row_count'] = $_ADODB->GetOne("SELECT FOUND_ROWS()");
}
$paginator->setItemsNumber($_SESSION['lib_search']['row_count']);

if (!empty($books))
{
	if ($search_mode == 'search' && $search_in == 'fulltext') {
		reset($books);
		while (list($id, $b) = each($books)) {
			if (substr($books[$id]['matched_pages'], 0, 1) == "0") {
				$books[$id]['matched_pages'] = substr($books[$id]['matched_pages'], 1);
			}
			$books[$id]['matched_pages'] = preg_replace('/([0-9]+)/', '<a href="/lib/files/' . $b['djvu_file'] . '?djvuopts&page=$1' . '" target="_new">$1</a>', $b['matched_pages']);
		}
		reset($books);
	}
    $sql = "
		SELECT
			b2a.book, a.id, a.path,
			IFNULL(s.fname, a.fname) AS fname,
			IFNULL(s.sname, a.sname) AS sname,
			IFNULL(s.lname, a.lname) AS lname,
			a.letter, a.show_in_history
		FROM
			h_person a,
			lib_b2a b2a
			LEFT JOIN h_person_spelling s ON s.id = b2a.spelling
		WHERE
			b2a.book IN (" . implode(",", array_keys($books)) . ")
			AND a.id = b2a.author
		ORDER BY
			a.letter, a.lname
	";
    $_authors = $_ADODB->GetAll($sql);
    while (list( , $v) = each($_authors)) {
        $books[$v['book']]['authors'][] = $v;
    }
}

require 'navigation.inc.php';
//ob_flush();
//flush();
//echo "-->";
//ob_flush();
//flush();
$_SMARTY->assign($navigation);
$_SMARTY->assign($_SESSION['lib_search']);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign(array('a_o' => ($o_by == 'author' && $o ? 0 : 1), 't_o' => ($o_by == 'title' && $o ? 0 : 1), 'y_o' => ($o_by == 'year' && $o ? 0 : 1), 'p_o' => ($o_by == 'pages' && $o ? 0 : 1), 'n_o' => ($o_by == 'num' ? ($o == 1 ? 0 : 1) : 0)));
$_SMARTY->assign('search_mode', $search_mode);
$_SMARTY->assign('search_id', $search_id);
$_SMARTY->assign('search_path', $search_path);
$_SMARTY->assign('books', $books);
$_SMARTY->assign('person', $person);
$_SMARTY->assign('ser_info', $ser_info);
$_SMARTY->display('lib/catalog.tpl');
?>
