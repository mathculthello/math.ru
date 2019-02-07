<?php
require_once '../set_env.inc.php';
//$_ADODB->debug=true;
if (!$_LU->isLoggedIn())
{
    Header('Location:/auth/login.php?redirect=/auth/cd_key.php');
    exit;
}

$_user_cdkey = $_ADODB->GetOne("SELECT cdkey FROM user WHERE login = '" . $_user_login . "'");
if (!$_user_cdkey) {
	$_SMARTY->display('auth/cd_fillprofile.tpl');
} else {
	$_SMARTY->assign('_user_cdkey', $_user_cdkey);
	$_SMARTY->display('auth/cd_showkey.tpl');
}
?>
