<?php
$r_letters = array('А','Б','В','Г','Д','Е','Ж','З','И','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я');
while(list($k,$v) = each($r_letters))
    $rus_letters[ord($v)] = $v;
$l_letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
while(list($k,$v) = each($l_letters))
    $lat_letters[ord($v)+1000] = $v;
$_SMARTY->assign('rus_letters', $rus_letters);
$_SMARTY->assign('lat_letters', $lat_letters);
?>