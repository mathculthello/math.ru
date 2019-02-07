<?php
function getRandomLibPicture() {
	global $_ADODB;
	$sql = "SELECT id,type,width,height,book FROM lib_pic ORDER BY RAND() LIMIT 1";
	$picture = $_ADODB->GetRow($sql);
	return $picture;
}

function replace_tex1($tex, $img_names_base = "img") {
    $html = $tex;
    if(preg_match_all("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", $tex, $matches)) {
        for($i = 0; $i < count($matches[0]); $i++) {
            $html = preg_replace("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", '<img src="'.$img_names_base.($i+1).'.png" align="middle" border="0" alt="' . $matches[0][$i] . '" />', $html, 1);
        }
    }
    return $html;

//    if(preg_match_all("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", $tex, $matches)) {
//        for($i = 0; $i < count($matches[0]); $i++) {
//            $html = preg_replace("/(\\$\\$.+?\\$\\$)|(\\$.+?\\$)/s", '<img src="'.$img_names_base.($i+1).'.png" align="middle" border="0"/>', $html, 1);
//        }
//    }
}

?>