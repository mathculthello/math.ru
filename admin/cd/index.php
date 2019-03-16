<?php
/*
 * Created on 18.07.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once '../set_env.inc.php';
define('GET_URL', 'http://www.math.ru/');
define('PUT_URL', '/home/http/math/html/cd/');

function file_write ($path, $contents, $base)
{
//flush();
    if (strpos($path, '/') === false)
    {
        $parts = array();
        $nest_level = 0;
    }
    else
    {
        $parts = explode('/', dirname($path));
        $nest_level = count($parts);
    }
    $curr_path = $base;
    while (list(, $v) = each($parts))
    {
        $curr_path .= $v.'/';
        if (!is_dir($curr_path))
        {
            mkdir($curr_path);
//echo 'mkdir '.$base.$curr_path.'<br>';
        }
    }
    $f = fopen($base.$path, 'w');
    $up_str = $nest_level ? substr(str_repeat('../', $nest_level), 0, -1) : '.';
//echo 'write '.$path.$nest_level.$up_str.'<br>';
    $search = array('open(\'/','open("/', 'location=/','location=\'/','location="/', 'href="/', 'href=/', 'src="/', 'src=/', 'url("/', 'url(\'/', 'PARAM NAME=movie VALUE="/', 'background="/');
    $replace = array('open(\''.$up_str.'/','open("'.$up_str.'/','location='.$up_str.'/','location=\''.$up_str.'/','location="'.$up_str.'/','href="'.$up_str.'/', 'href='.$up_str.'/', 'src="'.$up_str.'/', 'src='.$up_str.'/', 'url("'.$up_str.'/', 'url(\''.$up_str.'/', 'PARAM NAME=movie VALUE="'.$up_str.'/', 'background="'.$up_str.'/');
    fwrite($f, str_replace($search, $replace, $contents));
    fclose($f);
}

function disp ($str)
{
    echo $str;
    ob_flush();
    flush();
}

$_num_options = array(0, 20, 50);
$_order_options = array('author', 'title', 'year', 'pages');
$sql = 'SELECT COUNT(*) FROM lib_book';
$num = $_ADODB->GetOne($sql);
$_pages = array (
    array('title' => 'Главная страница', 'url' => 'lib/index.html', 'type' => 'single'),
    array('title' => 'Таблица стилей', 'url' => 'style_nn.css', 'type' => 'single', 'nest_level' => 0),
    array('title' => 'О форматах и правах', 'url' => 'lib/formats.html', 'type' => 'single', 'nest_level' => 1),
    array('title' => 'Благодарности', 'url' => 'lib/thanks.html', 'type' => 'single', 'nest_level' => 1),
);

// Тематический каталог
if ($_POST['all'] || $_POST['cat'])
{
    exec('rm -r '.PUT_URL.'lib/cat/*');
    $_pages[] = array('title' => 'Полный список', 'url' => 'lib/cat/', 'type' => 'paged', 'num' => $num, 'nest_level' => 5);
    $sql = 'SELECT c.*,COUNT(b2c.book) AS num FROM lib_catalog c,lib_b2c b2c WHERE b2c.subject=c.id GROUP BY c.id';
    $cat_list = $_ADODB->GetAll($sql);
    while (list($k, $v) = each($cat_list))
    {
        $_pages[] = array('title' => $v['name'], 'url' => 'lib/cat/'.$v['path'].'/', 'type' => 'paged', 'num' => $v['num'], 'nest_level' => 6);
    }
}

// Рубрикатор 
if ($_POST['all'] || $_POST['rubr'])
{
exec('rm -r '.PUT_URL.'lib/rubr/*');
$sql = 'SELECT c.*,COUNT(b2r.book) AS num FROM lib_rubr c,lib_b2r b2r WHERE b2r.rubr=c.id GROUP BY c.id';
$cat_list = $_ADODB->GetAll($sql);
while (list($k, $v) = each($cat_list))
{
    $_pages[] = array('title' => $v['name'], 'url' => 'lib/rubr/'.$v['path'].'/', 'type' => 'paged', 'num' => $v['num'], 'nest_level' => 6);
}
}

// Серии
if ($_POST['all'] || $_POST['ser'])
{
    exec('rm -r '.PUT_URL.'lib/ser/*');
    $sql = 'SELECT s.*,COUNT(b.id) AS num FROM lib_series s,lib_book b WHERE b.series=s.id GROUP BY s.id';
    $cat_list = $_ADODB->GetAll($sql);
    while (list($k, $v) = each($cat_list))
    {
        $_pages[] = array('title' => $v['name'], 'url' => 'lib/ser/'.$v['path'].'/', 'type' => 'paged', 'num' => $v['num'], 'nest_level' => 6, '_o_by' => array('num', 'author', 'title', 'year', 'pages'));
    }
}

// Алфавитный каталог
if ($_POST['all'] || $_POST['alph'])
{
    exec('rm -r '.PUT_URL.'lib/alph/*');
    $sql = 'SELECT DISTINCT p.letter FROM h_person p,lib_b2a a WHERE a.author=p.id ORDER BY p.letter';
    $cat_list = $_ADODB->GetAll($sql);
    while (list($k, $v) = each($cat_list))
    {
        $_pages[] = array('title' => chr($v['letter'] < 1000 ? $v['letter'] : $v['letter'] - 1000), 'url' => 'lib/alph/'.($v['letter'] > 1000 ? chr($v['letter']-1000) : $v['letter']).'/', 'type' => 'ordered', 'nest_level' => 4);
    }
}


// Страницы авторов
if ($_POST['all'] || $_POST['author'])
{
exec('rm -r '.PUT_URL.'lib/author/*');
$sql = 'SELECT DISTINCT p.id,CONCAT(p.lname, \' \', p.fname, \' \', p.sname) AS fullname, p.path FROM h_person p,lib_b2a a WHERE a.author=p.id ORDER BY fullname';
$cat_list = $_ADODB->GetAll($sql);
while (list($k, $v) = each($cat_list))
{
    $_pages[] = array('title' => $v['fullname'],'url' => 'lib/author/'.$v['path'].'/', 'type' => 'ordered', 'nest_level' => 4);
}
}

// Страницы книг
if ($_POST['all'] || $_POST['books'])
{
exec('rm -r '.PUT_URL.'lib/books/*');
$sql = 'SELECT CONCAT((CASE WHEN b.djvu_file!=\'\' THEN b.djvu_file WHEN b.pdf_file!=\'\' THEN b.pdf_file WHEN b.ps_file!=\'\' THEN b.ps_file WHEN b.tex_file!=\'\' THEN b.tex_file WHEN b.html_file!=\'\' THEN b.html_file ELSE b.id END), \'.html\') AS path FROM lib_book b';
$refs = $_ADODB->GetCol($sql);
$_pages[] = array('title' => 'Книги','url' => 'lib/book/', 'type' => 'group', 'refs' => $refs);
}


// Поиск
if ($_POST['all'] || $_POST['search'])
{
	exec('rm '.PUT_URL.'lib/search.html');
	exec('rm '.PUT_URL.'lib/index.js');
    $_pages[] = array('title' => 'Страница поиска', 'url' => 'lib/search.html', 'type' => 'single');
//    $_pages[] = array('title' => 'Поиск:скрипт', 'url' => 'lib/search.js', 'type' => 'single');
    $_pages[] = array('title' => 'Поиск:индекс', 'url' => 'lib/index.js', 'type' => 'single');
}

if ($_POST['generate'])
{
//echo file_get_contents('http://www.math.ru');
    reset($_pages);
    while (list($k, $v) = each($_pages))
    {
        disp($v['title'].'...');
        if ($v['_o_by'])
            $_o_by = $v['_o_by'];
        else
            $_o_by = $_order_options;
        switch ($v['type'])
        {
            case 'paged':
                reset($_num_options);
                while (list(, $n) = each($_num_options))
                {
                    $pages_num = ($n) ? ceil($v['num']/$n) : 1;
                    for ($i = 1; $i <= $pages_num; $i++)
                    {
                        reset($_o_by);
                        while (list(, $o_by) = each($_o_by))
                        {
                            $path = $v['url'].$n.'/'.$o_by.'/0/'.$i.'.html';
                            $contents = file_get_contents(GET_URL.$path.'?cd=1');
                            file_write($path, $contents, PUT_URL);
                            disp('.');
                            $path = $v['url'].$n.'/'.$o_by.'/1/'.$i.'.html';
                            $contents = file_get_contents(GET_URL.$path.'?cd=1');
                            file_write($path, $contents, PUT_URL);
                            disp('.');
    //                    echo $path.'<br>';
                        }
                    }
                }
            break;
            
            case 'single':
                $contents = file_get_contents(GET_URL.$v['url'].'?cd=1');
                file_write($v['url'], $contents, PUT_URL);
            break;
            
            case 'ordered':
                 reset($_o_by);
                 while (list(, $o_by) = each($_o_by))
                 {
                    $path = $v['url'].$o_by.'/0.html';
                    $contents = file_get_contents(GET_URL.$path.'?cd=1');
                    file_write($path, $contents, PUT_URL);
                    disp('.');
                    $path = $v['url'].$o_by.'/1.html';
                    $contents = file_get_contents(GET_URL.$path.'?cd=1');
                    file_write($path, $contents, PUT_URL);
                    disp('.');
    //                    echo $path.'<br>';
                }
            break;
            
            case 'group':
                while (list($k, $v1) = each($v['refs']))
                {
                    $path = $v['url'].$v1;
                    $contents = file_get_contents(GET_URL.$path.'?cd=1');
                    file_write($path, $contents, PUT_URL);
                    disp('.');
                }
            break;
        }
        disp('OK<br/>');
     }
}
else
{
$_SMARTY->display('cd/index.tpl');
}
?>
