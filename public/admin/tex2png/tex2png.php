<?php
require_once '../set_env.inc.php';

$_TMP_DIR = $_SERVER['DOCUMENT_ROOT']."/admin/tex2png";

if(!empty($_POST['tex'])) {
    $h = fopen($_TMP_DIR."/_tmp_latex.tex", "w");
    //            print_r($matches);
    //            print $request[anno];

    fwrite($h, $latex_header);
    for($i = 0; $i < count($matches[0]); $i++) {
        fwrite($h, $matches[0][$i]);
        fwrite($h, $latex_page_sep_string);
    }
    fwrite($h, $latex_eof_string);
    fwrite($h, $_POST['tex']);
    fclose($h);

    switch($_POST['mode']) {
        case 'small':
            preg_match_all("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", $_POST['tex'], $matches);
var_dump($matches);
            exec($app_root."/perl/tex2png.pl ".$_TMP_DIR."/_tmp_latex.tex  ".$_SERVER['DOCUMENT_ROOT']."/admin/tex2png/img", $ret);
            $_POST['html'] = $_POST['tex'];
            for($i = 0; $i < count($matches[0]); $i++) {
                $_POST['html'] = preg_replace("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", "<img src=\"/admin/tex2png/img".($i+1).".png\" align=middle>", $_POST['html'], 1);
            }
            break;
        case 'all':
            exec($app_root."/perl/tex2png.pl ".$_TMP_DIR."/_tmp_latex.tex  ".$_SERVER['DOCUMENT_ROOT']."/admin/tex2png/img -a");
            $_POST['html'] = "<img src=\"/admin/tex2png/img1.png\">";
            break;
    }

}
$_SMARTY->assign($_POST);
$_SMARTY->display("tex2png.tpl");
?>
