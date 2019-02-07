<?php
$_mime_ext = array ('image/jpeg' => 'jpg', 'image/pjpeg' => 'jpg', 'image/gif' => 'gif', 'image/png' => 'png', 'image/bmp' => 'bmp');
$_netpbm_path = '/usr/local/bin/';
$_to_pnm = array (2 => 'jpegtopnm', 1 => 'giftopnm', 3 => 'pngtopnm', 6 => 'bmptopnm',);
$_from_pnm = array (2 => 'pnmtojpeg', 1 => 'ppmquant 256 | '.$_netpbm_path.'ppmtogif', 3 => 'pnmtopng', 6 => 'ppmtobmp',);
$_TMP_DIR = $app_root."/temp";
$_THUMB_WIDTH = 200;
$_THUMB_HEIGHT = 200;


function process_post_input() {
    foreach ($_POST as $key => $value) {
        if (is_array($value)) {
            $request[$key] = $value;
            continue;
        }
        $value = trim($value);
        if (get_magic_quotes_gpc())
            $value = stripslashes($value);
        //      $value = htmlspecialchars($value);
        //      $value = addslashes($value);
        $request[$key] = $value;
    }

    return $request;
}

function resize_image($src, $dest, $max_width, $max_height) {
    global $_to_pnm, $_from_pnm, $_netpbm_path;
    $image_info = getimagesize($src);
    $pnm_scale = ($image_info[0] > $max_width || $image_info[1] > $max_height) ? ' | '.$_netpbm_path.'pnmscale -xysize '.$max_width.' '.$max_height : '' ;
    if ($pnm_scale)
    {
        echo  $_netpbm_path.$_to_pnm[$image_info[2]].' '.$src.$pnm_scale.' | '.$_netpbm_path.$_from_pnm[$image_info[2]].' > '.$dest;
        exec($_netpbm_path.$_to_pnm[$image_info[2]].' '.$src.$pnm_scale.' | '.$_netpbm_path.$_from_pnm[$image_info[2]].' > '.$dest);
    }
    else
    {
        copy($src, $dest);
    }
}
function replace_tex($tex, $img_names_base = "img") {
    $html = $tex;
    if(preg_match_all("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", $tex, $matches)) {
        for($i = 0; $i < count($matches[0]); $i++) {
            $html = preg_replace("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", '<img src="'.$img_names_base.($i+1).'.png" align="middle" border="0"/>', $html, 1);
        }
    }
    return $html;
}

//function replace_tex($tex, $img_names_base = "img") {
//    $html = $tex;
//    if(preg_match_all("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", $tex, $matches)) {
//        for($i = 0; $i < count($matches[0]); $i++) {
//            $html = preg_replace("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", '<img src="'.$img_names_base.($i+1).'.png" align="middle" border="0" alt="' . $matches[0][$i] . '" />', $html, 1);
//        }
//    }
//    return $html;
//}

?>