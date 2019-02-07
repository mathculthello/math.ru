<?php
require_once '../../set_env.inc.php';
require_once '../menu.inc.php';

//$_ADODB->debug=true;

if (empty($_REQUEST['letter']) && empty($_REQUEST['search_string'])) {
	$_REQUEST['letter'] = ord('А');
}

$where = '';
if ($_REQUEST['letter']) {
    $letter = is_numeric($_REQUEST['letter']) ? $_REQUEST['letter'] : ord($_REQUEST['letter']) + 1000;
    $where = " AND s.letter = " . $letter;
} elseif ($_REQUEST['search_string']) {
    $where = " AND s.lname LIKE '" . addslashes($_REQUEST['search_string']) . "%'";
}
$sql = "
(
SELECT 
	id AS k, id, lname, 
	fname, sname, path,
	letter, birth_date, death_date 
FROM 
	h_person s
WHERE
	show_in_history = '1'" . $where . " 
) UNION (
SELECT
	CONCAT(p.id, '_', s.id) AS k, p.id AS id,
	s.lname AS lname, s.fname AS fname, s.sname AS sname,
	p.path, s.letter AS letter, 
	p.birth_date, p.death_date
FROM
	h_person p, h_person_spelling s
WHERE
	s.disp = '1' AND p.id = s.person " . $where . "	
)
ORDER BY
	letter, lname
";
$person = $_ADODB->GetAssoc($sql);

$sql = "
SELECT 
	id, person, lname,
	fname, sname, letter 
FROM 
	h_person_spelling 
WHERE 
	disp = '1'";
$spelling = $_ADODB->GetAll($sql);

while (list($k, $v) = @each($spelling))
{
	if (isset($person[$v['person']])) {
    	$person[$v['person']]['spelling'][] = $v;
	} 
}

//while (list ($k, $v) = each($person)) {
//	$person_arr[] = $v;
//	if (is_array($v['spelling'])) {
//		$v2 = $v;
//		unset($v2['spelling']);
//		while (list ($k1, $v1) = each($v['spelling'])) {
//			$v2['lname'] = $v1['lname'];
//			$v2['sname'] = $v1['sname'];
//			$v2['fname'] = $v1['fname'];
//			$v2['letter'] = ord($v1['lname'] { 0 }) < ord('A') ?  ord($v1['lname'] { 0 }) : ord($v1['lname'] { 0 }) + 1000;
//			$person_arr[] = $v2;
//		}
//	}
//}

$person_arr = array_values($person);

$_SMARTY->assign('person', $person_arr);
$_SMARTY->assign('search_string', $_REQUEST['search_string']);
$_SMARTY->assign('letter', $letter);
$_SMARTY->display('history/people/index.tpl');
?>