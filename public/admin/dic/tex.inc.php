<?php
function process_tex($tex, $img_names_base = "img") {
    global $app_root, $_TMP_DIR, $id, $_user_id;
    
    $_tmp = $app_root.'/html/admin/tex2png/temp';
    $_tmp_tex = $_tmp.'/_tmp_latex_term'.$_user_id.'.tex';
    
    if(preg_match_all("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", $tex, $matches)) {
        $h = fopen($_tmp_tex, 'w');
        fwrite($h, $tex);
        fclose($h);
        exec($app_root.'/html/admin/tex2png/tex2png.pl '. $_tmp_tex .' '. $img_names_base.' '. $_user_id, $out, $ret);
        if ($ret > 0) {
            return $out;
        } else {
            return false;
        }
    }
}
?>
