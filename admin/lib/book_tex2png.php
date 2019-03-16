<?php
require_once '../set_env.inc.php';

if(empty($_GET['id']) || !is_numeric($_GET['id']))
	exit;
$id = $_GET['id'];
function process_tex($tex, $img_names_base = "img") {
    global $app_root, $_TMP_DIR;
    if(preg_match_all("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", $tex, $matches)) {
//print_r($matches);
        $h = fopen($_TMP_DIR."/_tmp_latex.tex", "w");
        fwrite($h, $tex);
        fclose($h);
        exec($app_root."/perl/tex2png.pl ".$_TMP_DIR."/_tmp_latex.tex  ".$img_names_base);
    }
}
function replace_tex($tex, $img_names_base = "img") {
    $html = $tex;
    if(preg_match_all("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", $tex, $matches)) {
        for($i = 0; $i < count($matches[0]); $i++) {
            $html = preg_replace("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", "<img src=\"".$img_names_base.($i+1).".png\" align=middle>", $html, 1);
        }
    }
    return $html;
}

$sql = 'SELECT contents,anno,djvu_file FROM lib_book WHERE id='.$id;
$book = $_ADODB->GetRow($sql);
// TeX в аннотации и содержании
process_tex($book['anno'], $_SERVER['DOCUMENT_ROOT']."/lib/img/imga_".$id."_");
process_tex($book['contents'], $_SERVER['DOCUMENT_ROOT']."/lib/img/imgc_".$id."_");
$book['anno'] = replace_tex($book['anno'], "/lib/img/imga_".$id."_");
$book['anno'] = nl2br($book['anno']);
$book['contents'] = nl2br($book['contents']);
$book['contents'] = replace_tex($book['contents'], "/lib/img/imgc_".$id."_");
$book['contents'] = str_replace("@@href@@", "/lib/files/".$book['djvu_file']."?djvuopts&page=", $book['contents']);
$_SMARTY->assign($book);
$_SMARTY->display('lib/book_tex2png.tpl');
?>