<?php

/*
 * Created on 11.07.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once '../set_env.inc.php';

$mccme_base = '/home/http/math/html/lib/files/';
//$mccme_base = 'http://ilib.mirror0.mccme.ru/';
//$sql = 'SELECT id,djvu_file FROM lib_book WHERE (djvu_file!=\'\' AND djvu_file IS NOT NULL AND (contents=\'\' OR contents IS NULL)) OR updated_contents=\'1\'';
//echo count($books).'<br/>';
//readfile($mccme_base);
//$contents = implode('', file($mccme_base));
//$contents = file_get_contents($mccme_base);
//echo $contents;
//echo file_get_contents($mccme_base.str_replace(array('.djvu','.djv'),array('.htm','.htm'),$books[0]['djvu_file']));
$start_str[] = '<h3 align="center">СОДЕРЖАНИЕ</H3>';
$start_str[] = 'СОДЕРЖАНИЕ</H3>';
$start_str[] = 'СОДЕРЖАНИЕ.</H3>';
$start_str[] = 'СОДЕРЖАНИЕ </H3>';
$start_str[] = 'СОДЕРЖАНИЕ. </H3>';
$end_str = '<hr>';

if (is_array($_POST['checked']) && count($_POST['checked']) > 0)
{
    
if ($_POST['update_mathru'])
{
    while (list($k,$v) = each($_POST['checked']))
    {
        $sql = 'SELECT * FROM lib_book WHERE id='.$v;
        $rs = $_ADODB->Execute($sql);
        $row = $rs->FetchRow();

        if ($row['djvu_file'] && file_exists($mccme_base.str_replace(array ('.djvu', '.djv'), array ('.htm', '.htm'), $row['djvu_file'])))
        {
            $row['ilib_file'] = $mccme_base.str_replace(array ('.djvu', '.djv'), array ('.htm', '.htm'), $row['djvu_file']);
        }
        elseif ($row['pdf_file'] && file_exists($mccme_base.str_replace('.pdf', '.htm', $row['pdf_file'])))
        {
            $row['ilib_file'] = $mccme_base.str_replace('.pdf', '.htm', $row['pdf_file']);
        }
        if ($row['ilib_file'])
        {
            $contents = file_get_contents($row['ilib_file']);
        }
        if ($contents && strpos(strtolower($contents), 'содержание') !== false) 
        {
        
            $start_pos = false;
            $start_match = -1;
            for ($i = 0; $i < count($start_str) && $start_pos === false; $i++)
            {
                $start_pos = strpos(strtolower($contents), strtolower($start_str[$i]));
                $start_match = $i;
            }
            if ( $start_pos !== false)
            {
                $row['ilib_contents'] = substr($contents, $start_pos + strlen($start_str[$start_match]));
            }
        
            $row['ilib_contents'] = substr($row['ilib_contents'], 0, strpos(strtolower($row['ilib_contents']), strtolower($end_str)) - strlen($row['ilib_contents']));
            $row['ilib_contents'] = preg_replace('/=\s?("?).+?\.(?:djv|djvu)\?djvuopts&page=(\d+)/i', '=\1@@href@@\2', $row['ilib_contents']);
        }
        if ($row['ilib_contents'])
        {
            $row['contents'] = $row['ilib_contents'];

            if ($sql = $_ADODB->GetUpdateSQL($rs, $row, true)) 
            {
                if (!$_ADODB->Execute($sql)) 
                {
                    $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
                } 
                else 
                {
                }
            } 
            else 
            {
                $_ERROR_MESSAGE[] = $_ADODB->ErrorMsg();
            }
        }
    }
}
elseif ($_POST['update_ilib'])
{
    while (list($k,$v) = each($_POST['checked']))
    {
        $sql = 'SELECT * FROM lib_book WHERE id='.$v;
        $row = $_ADODB->GetRow($sql);
        if ($row['djvu_file'])
        {
            $row['ilib_file'] = $mccme_base.str_replace(array ('.djvu', '.djv'), array ('.htm', '.htm'), $row['djvu_file']);
            $row['ilib_path'] = basename($row['djvu_file']);
        }
        elseif ($row['pdf_file'])
        {
            $row['ilib_file'] = $mccme_base.str_replace('.pdf', '.htm', $row['pdf_file']);
            $row['ilib_path'] = basename($row['pdf_file']);
        }
        $row['contents'] = preg_replace('/@@href@@([0-9]*)/', $row['ilib_path'].'?djvuopts&page=\1', $row['contents']);
        if ($row['contents'] && $row['ilib_file'])
        {
            
            if (file_exists($row['ilib_file']))
            {
                $contents = file_get_contents($row['ilib_file']);
                copy($row['ilib_file'], str_replace(array('.htm','.html'),array('.ilib','.ilib'),$row['ilib_file']));
                $start_pos = false;
                for ($i = 0; $i < count($start_str) && $start_pos === false; $i++)
                {
                    $start_pos = strpos(strtolower($contents), strtolower($start_str[$i]));
                    $start_match = $i;
                }
                if ( $start_pos !== false )
                {
                    $contents = preg_replace('/^(.*'.$start_str[$start_match].').*?('.$end_str.'.*)$/i', '\1'.$row['contents'].'\2', $contents);
                }
                elseif (strpos($contents, $end_str) !== false)
                {
echo "after hr";

                    $contents = substr_replace($contents, $end_str.$start_str[0].$row['contents'].$end_str, strpos($contents, $end_str), strlen($end_str));
echo $contents;
                }
                else
                {
                    $contents .= $start_str[0].$row['contents'].$end_str;
                }
            }
            else
            {
                $contents = $start_str[0].$row['contents'].$end_str;
            }
            $f = fopen($row['ilib_file'], 'w');
            fwrite($f, $contents);
            fclose($f);
        }
    }
}

}


$sql = 'SELECT * FROM lib_book WHERE djvu_file!=\'\' AND djvu_file IS NOT NULL';
$books = $_ADODB->GetAll($sql);

$f = 0;
while (list ($k, $v) = each($books)) 
{
    $contents = '';
    $books[$k]['contents'] = strtolower($books[$k]['contents']);
    if ($v['djvu_file'] && file_exists($mccme_base.str_replace(array ('.djvu', '.djv'), array ('.htm', '.htm'), $v['djvu_file'])))
    {
        $books[$k]['ilib_path'] = str_replace(array ('.djvu', '.djv'), array ('.htm', '.htm'), $v['djvu_file']);
        $books[$k]['ilib_file'] = $mccme_base.str_replace(array ('.djvu', '.djv'), array ('.htm', '.htm'), $v['djvu_file']);
    }
    elseif ($v['pdf_file'] && file_exists($mccme_base.str_replace('.pdf', '.htm', $v['pdf_file'])))
    {
        $books[$k]['ilib_path'] = str_replace('.pdf', '.htm', $v['pdf_file']);
        $books[$k]['ilib_file'] = $mccme_base.str_replace('.pdf', '.htm', $v['pdf_file']);
    }
    if ($books[$k]['ilib_file'])
    {
        $contents = strtolower(file_get_contents($books[$k]['ilib_file']));
    }
    
    
    if ($contents && strpos($contents, 'содержание') !== false) 
    {
//        $search = array('@^.*<h3 align="center">СОДЕРЖАНИЕ</H3>(.*?)<hr>.*$@');
//        $replace = array('\1');
//      $v['contents'] = preg_replace($search, $replace, $contents);
        
        $start_pos = false;
        $start_match = -1;
        for ($i = 0; $i < count($start_str) && $start_pos === false; $i++)
        {
            $start_pos = strpos($contents, strtolower($start_str[$i]));
            $start_match = $i;
        }
        if ( $start_pos === false)
        {
            echo '<!--'.$books[$k]['id'].'-->';
        }
        else
        {
            $books[$k]['ilib_contents'] = substr($contents, $start_pos + strlen($start_str[$start_match]));
        }
        
        $books[$k]['ilib_contents'] = substr($books[$k]['ilib_contents'], 0, strpos($books[$k]['ilib_contents'], strtolower($end_str)) - strlen($books[$k]['ilib_contents']));
        $books[$k]['ilib_contents'] = preg_replace('/=\s?("?).+?\.(?:djv|djvu)\?djvuopts&page=(\d+)/i', '=\1@@href@@\2', $books[$k]['ilib_contents']);
    } 
    else 
    {
//      echo $v['id'].' - empty<br/>';
    }
    $books[$k]['contents'] = trim($books[$k]['contents']);
    $books[$k]['ilib_contents'] = trim($books[$k]['ilib_contents']);

//if (!$f && $books[$k]['contents'] != $books[$k]['ilib_contents'])
//{
//$pos = 0;
//$last_pos = 0;
//for ($i = 0; $i < strlen($books[$k]['contents']); $i++)
//{
//    if ($books[$k]['contents']{$i} != $books[$k]['ilib_contents']{$i})
//    {
//        echo $books[$k]['contents']{$i}.$books[$k]['contents']{$i+1}.'-'.$books[$k]['ilib_contents']{$i}.$books[$k]['ilib_contents']{$i+1};
//        $pos = $i;
//        break;
//    }
//    $last_pos = $i;
//}
//echo "<!--";
//echo $pos;
//echo $last_pos;
//echo $books[$k]['ilib_contents'];
//
//echo $books[$k]['contents'];
//
//echo "-->";
//$f = 1;
//}
    if ($books[$k]['contents'] && $books[$k]['ilib_contents'] && strtolower(str_replace(array(" ","\n","\t","\r"), array("","","",""), $books[$k]['contents'])) == strtolower(str_replace(array(" ","\n","\t","\r"), array("","","",""), $books[$k]['ilib_contents'])))
    {
        unset($books[$k]);
    }
}

$_SMARTY->assign('books', $books);
$_SMARTY->assign('books_num', count($books));
$_SMARTY->display('lib/ilib_contents.tpl');
?>

