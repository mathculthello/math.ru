<?php
/*
 * Created on 23.10.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once '../set_env.inc.php';
ini_set('display_errors', 'on');
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

function find_base($word, $endings)
{
    while (list(, $e) = each($endings))
    {
        if ((strlen($word) > strlen($e) + 3) && substr($word, strlen($word) - strlen($e), strlen($e)) == $e)
        {
            return substr($word, 0, strlen($word) - strlen($e));
        }
    }
    
    return $word;
}

//$_ADODB->debug = true;
$sql = 'SELECT id AS k,id,title,contents,anno FROM lib_book';
$books = $_ADODB->GetAssoc($sql);

$idx['key_index'] = array();

while (list($k, $v) = each($books))
{
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

$sql = 'DELETE FROM lib_key_index';
$_ADODB->Execute($sql);
$sql = 'DELETE FROM lib_base_index';
$_ADODB->Execute($sql);
$sql = 'SELECT ending FROM lib_ending ORDER BY LENGTH(ending) DESC';
$endings = $_ADODB->GetCol($sql); 
$idx['base_index'] = array();
while (list($k, $v) = each($idx['key_index']))
{
    $base = find_base($k, $endings);
    $sql = 'INSERT lib_key_index (word, books, base) VALUES (\''.$k.'\',\''.implode(',', $v).'\',\''.$base.'\')';
    $_ADODB->Execute($sql);
    while (list ($k1, $v1) = each($v))
    {
        if (!array_key_exists($base, $idx['base_index']) || !in_array($v1, $idx['base_index'][$base]))
        {
            $idx['base_index'][$base][] = $v1;
        }
    }
}
while (list($k, $v) = each($idx['base_index']))
{
    $sql = 'INSERT lib_base_index (base, books) VALUES (\''.$k.'\',\''.implode(',', $v).'\')';
    $_ADODB->Execute($sql);
}
?>
