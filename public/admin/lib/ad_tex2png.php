<?php
require_once '../set_env.inc.php';

if(empty($_GET['id']) || !is_numeric($_GET['id']))
    exit;
$id = $_GET['id'];

function process_tex($tex, $img_names_base = "img") {
    global $app_root, $_TMP_DIR, $id;
$_tmp = $app_root.'/html/admin/tex2png/temp';
    if(preg_match_all("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", $tex, $matches)) {
//print_r($matches);
        $h = fopen($_tmp.'/_tmp_latex_ad'.$id.'.tex', 'w');
        fwrite($h, $tex);
        fclose($h);
//echo `pwd`;
//$app_root."/html/admin/tex2png/tex2png.pl ".$_tmp."/_tmp_latex.tex  ".$img_names_base.'<br>';
echo $app_root.'/html/admin/tex2png/tex2png.pl '.$_tmp.'/_tmp_latex_ad'.$id.'.tex  '.$img_names_base;
exec($app_root.'/html/admin/tex2png/tex2png.pl '.$_tmp.'/_tmp_latex_ad'.$id.'.tex  '.$img_names_base, $out);
    }
}


$sql = 'SELECT txt FROM lib_ad WHERE id='.$id;
$ad = $_ADODB->GetRow($sql);
process_tex($ad['txt'], $_SERVER['DOCUMENT_ROOT']."/lib/ad/img/img_".$id."_");
$ad['txt'] = replace_tex($ad['txt'], "/lib/ad/img/img_".$id."_");
$ad['txt'] = nl2br($ad['txt']);
$_SMARTY->assign($ad);
$_SMARTY->display('lib/ad_tex2png.tpl');
?>