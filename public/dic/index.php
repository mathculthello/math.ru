<?php
require_once '../set_env.inc.php';
require_once 'PHP/Compat.php';
require_once INCLUDE_DIR.'Paginator.class.php';
PHP_Compat::loadFunction('array_combine');
setlocale (LC_ALL, array('ru_RU.CP1251', 'rus_RUS.1251'));

$rubr=isset($_GET['rubr'])?$_GET['rubr']:null;

//$_ADODB->debug = true;
//
//var_dump($_REQUEST);
//ini_set('display_errors', 'on');
if (isset($_REQUEST['all'])) {
    unset($_SESSION['dic_search']);
}
if (isset($_REQUEST['letter'])) {
	$_SESSION['dic_search']['letter'] = $_REQUEST['letter']; 
}
if (isset($_REQUEST['rubr'])) {
    $_SESSION['dic_search']['rubr'] = $_REQUEST['rubr']; 
}
if (isset($_REQUEST['grade_from'])) {
	$_SESSION['dic_search']['grade_from'] = $_REQUEST['grade_from']; 
}
if (isset($_REQUEST['grade_to'])) {
	$_SESSION['dic_search']['grade_to'] = $_REQUEST['grade_to']; 
}
if (isset($_REQUEST['select_src'])) {
	$_SESSION['dic_search']['src'] = @implode(',', $_REQUEST['src']); 
	$_SESSION['dic_search']['src_type'] = $_REQUEST['src_type']; 
} elseif (isset($_REQUEST['cancel_src'])) {
	unset($_SESSION['dic_search']['src']);
	unset($_SESSION['dic_search']['src_type']);
}
if (isset($_REQUEST['select_type'])) {
    $_SESSION['dic_search']['type'] = $_REQUEST['type']; 
}

if (!isset($_SESSION['dic_search']['src_type'])) {
    $_SESSION['dic_search']['src_type'] = array();
}
if (!isset($_SESSION['dic_search']['type'])) {
    $_SESSION['dic_search']['type'] = array();
}
if (isset($_REQUEST['page'])) 
{ 
    $_SESSION['dic_search']['page'] = $_REQUEST['page'];
}





$paginator = new Paginator($_SESSION['dic_search']['page'], array (0 => 'все', 10 => 10, 20 => 20, 50 => 50), 25, 15, 0, 'title');

$sql = 'SELECT id,title FROM dic_term ORDER BY title';
$full_term_list = $_ADODB->GetAssoc($sql); 
function wrdcmp($a, $b)
{
	$wca = count(explode(' ', $a));
	$wcb = count(explode(' ', $b));
	if ($wca == $wcb) {
    	return 0;
	}
	
	return ($wca < $wcb) ? 1 : -1;
}
uasort($full_term_list, "wrdcmp");

//echo '<pre>';
//var_dump($full_term_list);
//echo '</pre>';

function find_terms($text, $id) {
	
	global $full_term_list;
	
    $ret = $text;
	while (list($k1, $v1) = each($full_term_list)) {
		if ($k1 != $id) {
            $regexp = "/\b(".preg_quote($v1, '/').")\b/is";
//            echo "$regexp\n";
			$ret = preg_replace($regexp, '<a href="/dic/'.$k1.'">$1</a>', $ret);
//			$ret = str_replace($v, '<a href="/dic/'.$k.'">'.$v.'</a>', $ret);
		}
   	}
   	reset($full_term_list);

    return $ret;
}

$sql_where = array("1 = 1");
if (isset($_SESSION['dic_search']['letter'])) {
    $sql_where[] = "t.title LIKE '" . chr($_SESSION['dic_search']['letter']) . "%'";
}
if (isset($_SESSION['dic_search']['rubr'])) {
    $sql_where[] = "EXISTS (
        SELECT 
            t2r.rubr 
        FROM 
            dic_t2r t2r, dic_rubr r1, dic_rubr r2
        WHERE 
            t2r.term = t.id
            AND t2r.rubr = r2.id
            AND r1.id = '" . addslashes($_SESSION['dic_search']['rubr']) . "'
            AND r2.lft BETWEEN r1.lft AND r1.rgt
        LIMIT 1
    )";
}
if (isset($_SESSION['dic_search']['type']) && !empty($_SESSION['dic_search']['type'])) {
    $sql_where[] = "t.type IN ('" . implode("','", $_SESSION['dic_search']['type']) . "')";
}

$sql = 'SELECT COUNT(*) FROM dic_term t WHERE ' . implode(" AND ", $sql_where);
$paginator->setItemsNumber($_ADODB->GetOne($sql));

$sql = 'SELECT t.id,t.title,t.type FROM dic_term t WHERE ' . implode(" AND ", $sql_where);
$sql .= ' ORDER BY t.title ' . $paginator->limit;

$words = $_ADODB->GetAll($sql);
while (list($k, $v) = each($words)) {
	$words[$k]['title'] = replace_tex($words[$k]['title'], '/dic/img/'.$v['id'].'t_');
}

if (!empty($_REQUEST['term'])) {
	$letter = ord($_REQUEST['term']);
	
	$sql = 'SELECT ref,title FROM dic_term WHERE id=\''.addslashes($_REQUEST['term']) .'\'';
	$ref = $_ADODB->GetRow($sql);
	if ($ref['ref'] > 0) {
		$sql = 'SELECT t.*, tt.*, ' .
			'IF(s1.type=\'person\',\'Редактор\',CONCAT(s1.author,\'. \', IF(s1.type=\'person\', \'\', s1.title))) AS src_entry_name, ' .
			'IF(s2.type=\'person\',\'Редактор\',CONCAT(s2.author,\'. \', IF(s2.type=\'person\', \'\', s2.title))) AS src_formula_name, ' .
			'IF(s3.type=\'person\',\'Редактор\',CONCAT(s3.author,\'. \', IF(s3.type=\'person\', \'\', s3.title))) AS src_comment_name, ' .
			'IF(s4.type=\'person\',\'Редактор\',CONCAT(s4.author,\'. \', IF(s4.type=\'person\', \'\', s4.title))) AS src_illustration_name, ' .
			'IF(s5.type=\'person\',\'Редактор\',CONCAT(s5.author,\'. \', IF(s5.type=\'person\', \'\', s5.title))) AS src_history_name, ' .
			'IF(s1.type=\'person\',\'Редактор\',s1.code) AS src_entry_code, ' .
			'IF(s2.type=\'person\',\'Редактор\',s2.code) AS src_formula_code, ' .
			'IF(s3.type=\'person\',\'Редактор\',s3.code) AS src_comment_code, ' .
			'IF(s4.type=\'person\',\'Редактор\',s4.code) AS src_illustration_code, ' .
			'IF(s5.type=\'person\',\'Редактор\',s5.code) AS src_history_code ' .
			'FROM dic_term t, dic_term_text tt ' .
			'LEFT JOIN dic_src s1 ON s1.id=t.src_entry ' .
			'LEFT JOIN dic_src s2 ON s2.id=t.src_formula ' .
			'LEFT JOIN dic_src s3 ON s3.id=t.src_comment ' .
			'LEFT JOIN dic_src s4 ON s4.id=t.src_illustration ' .
			'LEFT JOIN dic_src s5 ON s5.id=t.src_history ' .
			'WHERE t.id=\''. $ref['ref'] .'\' AND tt.term=t.id';
		$term_info = $_ADODB->GetRow($sql);
	} else {
		$sql = 'SELECT t.*, tt.*, ' .
			'IF(s1.type=\'person\',\'Редактор\',CONCAT(s1.author,\'. \', IF(s1.type=\'person\', \'\', s1.title))) AS src_entry_name, ' .
			'IF(s2.type=\'person\',\'Редактор\',CONCAT(s2.author,\'. \', IF(s2.type=\'person\', \'\', s2.title))) AS src_formula_name, ' .
			'IF(s3.type=\'person\',\'Редактор\',CONCAT(s3.author,\'. \', IF(s3.type=\'person\', \'\', s3.title))) AS src_comment_name, ' .
			'IF(s4.type=\'person\',\'Редактор\',CONCAT(s4.author,\'. \', IF(s4.type=\'person\', \'\', s4.title))) AS src_illustration_name, ' .
			'IF(s5.type=\'person\',\'Редактор\',CONCAT(s5.author,\'. \', IF(s5.type=\'person\', \'\', s5.title))) AS src_history_name, ' .
			'IF(s1.type=\'person\',\'Редактор\',s1.code) AS src_entry_code, ' .
			'IF(s2.type=\'person\',\'Редактор\',s2.code) AS src_formula_code, ' .
			'IF(s3.type=\'person\',\'Редактор\',s3.code) AS src_comment_code, ' .
			'IF(s4.type=\'person\',\'Редактор\',s4.code) AS src_illustration_code, ' .
			'IF(s5.type=\'person\',\'Редактор\',s5.code) AS src_history_code ' .
			'FROM dic_term t, dic_term_text tt ' .
			'LEFT JOIN dic_src s1 ON s1.id=t.src_entry ' .
			'LEFT JOIN dic_src s2 ON s2.id=t.src_formula ' .
			'LEFT JOIN dic_src s3 ON s3.id=t.src_comment ' .
			'LEFT JOIN dic_src s4 ON s4.id=t.src_illustration ' .
			'LEFT JOIN dic_src s5 ON s5.id=t.src_history ' .
			'WHERE t.id=\''. addslashes($_REQUEST['term']) .'\' AND tt.term=t.id';
		$term_info = $_ADODB->GetRow($sql);
	}
	$sql = 'SELECT d.*,IF(s.type=\'person\',\'Редактор\',s.code) AS src_code,s.title AS src_title,s.author AS src_authors,s.type AS src_type FROM dic_wording d LEFT JOIN dic_src s ON s.id=d.src WHERE d.term='.$term_info['id'];
	if (isset($_SESSION['dic_search']['src_type']) && !empty($_SESSION['dic_search']['src_type'])) {
		$sql .= ' AND s.type IN (\''.implode('\',\'', $_SESSION['dic_search']['src_type']).'\')';
	}
	if (isset($_SESSION['dic_search']['src']) && !empty($_SESSION['dic_search']['src'])) {
		$sql .= ' AND s.id IN ('.$_SESSION['dic_search']['src'].')';
	}
	if (isset($_SESSION['dic_search']['grade_from']) && !empty($_SESSION['dic_search']['grade_from'])) {
		$sql .= ' AND ('.$_SESSION['dic_search']['grade_from'].' BETWEEN s.grade_from AND s.grade_to OR '.$_SESSION['dic_search']['grade_to'].' BETWEEN s.grade_from AND s.grade_to OR s.grade_to BETWEEN '.$_SESSION['dic_search']['grade_from'].' AND '.$_SESSION['dic_search']['grade_to'].') ';
	}
	$term_info['def'] = $_ADODB->GetAll($sql);
	$sql = 'SELECT * FROM dic_comp WHERE term='.$term_info['id'];
	$term_info['cmp'] = $_ADODB->GetAll($sql);
	while (list($k, $v) = each($term_info['cmp'])) {
		$sql = 'SELECT s.id,IF(s.type=\'person\',\'Редактор\',s.code) AS code,s.author,s.title,s.type FROM dic_comp_src cs, dic_src s WHERE s.id=cs.src AND cs.comp='.$v['id'];
		$term_info['cmp'][$k]['src'] = $_ADODB->GetAll($sql);
		$term_info['cmp'][$k]['comp'] = find_terms(replace_tex($term_info['cmp'][$k]['comp'], '/dic/img/c'.$term_info['cmp'][$k]['id'].'_'), $term_info['id']);
	}

    if ($term_info['type'] == 'formula') {
        $sql = 'SELECT * FROM dic_formula WHERE term='.$term_info['id'];
        $term_info['other_formula'] = $_ADODB->GetAll($sql);
        while (list($k, $v) = each($term_info['other_formula'])) {
            $term_info['other_formula'][$k]['formula'] = find_terms(replace_tex($term_info['other_formula'][$k]['formula'], '/dic/img/formula'.$term_info['other_formula'][$k]['id'].'_'), $term_info['id']);
        }
    }

	while (list($k, $v) = each($term_info['def'])) {
		$term_info['def'][$k]['wording'] = find_terms(replace_tex($term_info['def'][$k]['wording'], '/dic/img/w'.$term_info['def'][$k]['id'].'w_'), $term_info['id']);
		$term_info['def'][$k]['comment'] = find_terms(replace_tex($term_info['def'][$k]['comment'], '/dic/img/w'.$term_info['def'][$k]['id'].'c_'), $term_info['id']);
	}
	$term_info['title'] = replace_tex($term_info['title'], '/dic/img/'.$term_info['id'].'t_'); 
	$term_info['entry'] = find_terms(replace_tex($term_info['entry'], '/dic/img/'.$term_info['id'].'e_'), $term_info['id']); 
	$term_info['formula'] = find_terms(replace_tex($term_info['formula'], '/dic/img/'.$term_info['id'].'f_'), $term_info['id']); 
	$term_info['comment'] = find_terms(replace_tex($term_info['comment'], '/dic/img/'.$term_info['id'].'c_'), $term_info['id']); 
	$term_info['illustration'] = find_terms(replace_tex($term_info['illustration'], '/dic/img/'.$term_info['id'].'i_'), $term_info['id']); 
	$term_info['history'] = find_terms(replace_tex($term_info['history'], '/dic/img/'.$term_info['id'].'h_'), $term_info['id']); 

    $sql = 'SELECT t.id,t.title FROM dic_ref r,dic_term t WHERE r.term1='.$term_info['id'] . ' AND t.id = r.term2';
    $term_info['references'] = $_ADODB->GetAll($sql);

	if ($ref['ref'] > 0) {
		$term_info['id'] = $_REQUEST['term'];
		$term_info['title'] = $ref['title'];
	}
} else {
	$letter = $_REQUEST['letter'];
}

$sql = 'SELECT id,IF(type=\'person\',\'Редактор\',code) FROM dic_src';
if (isset($_SESSION['dic_search']['src_type']) && !empty($_SESSION['dic_search']['src_type'])) {
	$sql .= ' WHERE type IN (\''.implode('\',\'', $_SESSION['dic_search']['src_type']).'\')';
}
$sql .=  ' ORDER BY code';
$src_options = $_ADODB->GetAssoc($sql);

if (!empty($_SESSION['dic_search']['rubr'])) {
    $sql = "
        SELECT
            r2.id, r2.name, r2.level
        FROM
            dic_rubr r1,
            dic_rubr r2
        WHERE
            r1.id = '" . addslashes($_SESSION['dic_search']['rubr']) . "'
            AND r1.lft BETWEEN r2.lft AND r2.rgt
            AND r1.rgt BETWEEN r2.lft AND r2.rgt
        ORDER BY
            r2.lft
    ";
    $rubr_path = $_ADODB->GetAll($sql);
}

$sql = "SELECT id,IF(type='person','Редактор',code) AS code,type FROM dic_src ORDER BY code";
$src_list = $_ADODB->GetAll($sql);

$sql = "
    SELECT
        r2.id, r2.name, r2.level 
    FROM
        dic_rubr r1, dic_rubr r2
    WHERE
        r1.id = '" . ($_SESSION['dic_search']['rubr'] ? addslashes($_SESSION['dic_search']['rubr']) : '1') . "'
        AND r2.lft BETWEEN r1.lft AND r1.rgt
        AND r2.level > r1.level
    ORDER BY
        r2.lft";
$rubr_list = $_ADODB->GetAssoc($sql, false, true);

$sql = "
    SELECT
        id, name, level 
    FROM
        dic_rubr
    WHERE
        level = 1
    ORDER BY
        lft";
$top_rubr = $_ADODB->GetAll($sql, false, true);

$_SMARTY->assign('grade_options', array_combine(range(1, 11), range(1, 11)));
$_SMARTY->assign('grade_from', ($_SESSION['dic_search']['grade_from'] ? $_SESSION['dic_search']['grade_from'] : 1));
$_SMARTY->assign('grade_to', ($_SESSION['dic_search']['grade_to'] ? $_SESSION['dic_search']['grade_to'] : 11));
$_SMARTY->assign('src_options', $src_options);
$_SMARTY->assign('src_list', $src_list);
$_SMARTY->assign('rubr_list', $rubr_list);
$_SMARTY->assign('top_rubr', $top_rubr);
$_SMARTY->assign('rubr_path', $rubr_path);
$_SMARTY->assign('rubr', $rubr);
$_SMARTY->assign('src_type_options', array('textbook' => 'Учебники', 'aid' => 'Учебные пособия', 'book' => 'Книги', 'person' => 'Авторы', 'inet' => 'Интернет ресурсы', 'other' => 'Другие'));
$_SMARTY->assign('type_options', array('term' => 'Понятие', 'fact' => 'Факт', 'formula' => 'Формула'));
$_SMARTY->assign('src', explode(',', $_SESSION['dic_search']['src']));
$_SMARTY->assign('src_type', count($_SESSION['dic_search']['src_type']) > 0 ? array_combine(array_values($_SESSION['dic_search']['src_type']), array_values($_SESSION['dic_search']['src_type'])) : array());
$_SMARTY->assign('type', count($_SESSION['dic_search']['type']) > 0 ? array_combine(array_values($_SESSION['dic_search']['type']), array_values($_SESSION['dic_search']['type'])) : array());
$_SMARTY->assign('words', $words);
$_SMARTY->assign('_p', $paginator);
$_SMARTY->assign('term', $_REQUEST['term']);
$_SMARTY->assign('term_info', $term_info);
$_SMARTY->assign('letter', $_SESSION['dic_search']['letter']);
$_SMARTY->display('dic/index.tpl');
?>
