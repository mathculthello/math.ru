<?php
require_once '../set_env.inc.php';
//ini_set('display_errors', 'on');
require_once INCLUDE_DIR.'/PEAR/PHP/Compat/Function/str_word_count.php';

function disp ($str)
{
    echo $str;
    ob_flush();
    flush();
}

function word_count($str)
{
   $str = str_replace(array(',', '.', '!', '?', ')', '(', '-', '"', '\'', ':', "\n", '*'),
   array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ', ' '),$str);
   $str = preg_replace('/((&\w{0,6};)|[^\w\d]+)/Si', ' ', $str);
   return explode(" ", $str);
}

//$_ADODB->debug = true;
$sql = 'SELECT id AS k,id,title,contents,anno,year,' .
       'ROUND(djvu/1024/1024,2) AS djvu,ROUND(pdf/1024/1024,2) AS pdf,ROUND(ps/1024/1024,2) AS ps,ROUND(html/1024/1024,2) AS html,ROUND(tex/1024/1024,2) AS tex,'.
        '(CASE WHEN djvu_file!=\'\' THEN djvu_file WHEN pdf_file!=\'\' THEN pdf_file WHEN ps_file!=\'\' THEN ps_file WHEN tex_file!=\'\' THEN tex_file WHEN html_file!=\'\' THEN html_file ELSE id END) AS path,'.
        'djvu_file,pdf_file,ps_file,html_file,tex_file FROM lib_book';
$books = $_ADODB->GetAssoc($sql);
$sql = 'SELECT b2a.book,a.id,a.path,IFNULL(s.fname,a.fname) AS fname,IFNULL(s.sname,a.sname) AS sname,IFNULL(s.lname,a.lname) AS lname,a.letter,a.show_in_history FROM lib_b2a b2a,h_person a LEFT JOIN h_person_spelling s ON s.id=b2a.spelling WHERE a.id=b2a.author';
$authors = $_ADODB->GetAll($sql);
while (list($k, $v) = each($authors))
{
	$v['fname'] = iconv('windows-1251', 'UTF-8', $v['fname']);
	$v['sname'] = iconv('windows-1251', 'UTF-8', $v['sname']);
	$v['lname'] = iconv('windows-1251', 'UTF-8', $v['lname']);
	$v['letter'] = iconv('windows-1251', 'UTF-8', $v['letter']);
    if ($books[$v['book']])
    {
        $books[$v['book']]['author'][] = $v;
    }
}

// Для Google Desktop текст в UTF-8
while (list($k, $v) = each($books)) {
	$books[$k]['title'] = iconv('windows-1251', 'UTF-8', $v['title']);
	$books[$k]['contents'] = iconv('windows-1251', 'UTF-8', $v['contents']);
	$books[$k]['anno'] = iconv('windows-1251', 'UTF-8', $v['anno']);
} 

/*
$idx['key_index'] = array();
$idx['year_index'] = array();
$idx['author_index'] = array();
while (list($k, $v) = each($books))
{
    if ($v['year'])
    {
        $idx['year_index'][$v['year']][] = $v['id'];
    }
    while (list($k1,$v1) = each($v['author']))
    {
        $idx['author_index'][strtolower($v1['lname'])][] = $v['id'];
    }
//    $words = str_word_count(strip_tags($v['title']), 1, 'абвгдеёжзийклмнопрстуфхцчшщьыъэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯ');
    $words = word_count(strip_tags($v['title']));
//    var_dump($words);
    $words = array_merge($words, word_count(strip_tags($v['anno']), 1));
    $words = array_merge($words, word_count(strip_tags($v['contents']), 1));
    while (list($k1,$v1) = @each($words))
    {
        $v1 = trim(strtolower($v1));
        if (strlen($v1) > 3 && (!array_key_exists($v1, $idx['key_index']) || !in_array($v['id'], $idx['key_index'][$v1])))
        {
            $idx['key_index'][$v1][] = $v['id'];
        }
    }
    
}
*/

//$sql = 'DELETE FROM lib_key_index';
//$_ADODB->Execute($sql);
//while (list($k, $v) = each($idx['key_index']))
//{
//    $sql = 'INSERT lib_key_index (word, books) VALUES (\''.$k.'\',\''.implode(',', $v).'\')';
//    $_ADODB->Execute($sql);
//}
$_SMARTY->assign('books', $books);
//$_SMARTY->assign($idx);
//var_dump($idx);
$_SMARTY->display('lib/idx.tpl');
?>
