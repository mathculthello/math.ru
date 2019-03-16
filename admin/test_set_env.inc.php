<?php
$app_root = '/home/http/math';
define('INCLUDE_DIR', $app_root.'/include/');
define('SMARTY_DIR', INCLUDE_DIR.'/smarty/');
define('ADODB_DIR', INCLUDE_DIR.'/adodb');

require_once SMARTY_DIR.'Smarty.class.php';
require_once ADODB_DIR.'/adodb.inc.php';
require_once INCLUDE_DIR.'/User.class.php';
require_once 'global.inc.php';

$dbserver = 'localhost';
$dbname = 'test1';
$dbuser = 'math';
$dbpassword = 'LWkkyi4y';
$dbdriver = 'mysql';
$db_usertable = 'user'; // user information table name
$_ADODB = ADONewConnection($dbdriver);
//$_ADODB->debug = true; 
if (!$_ADODB->Connect($dbserver, $dbuser, $dbpassword, $dbname)) 
{
echo "blablabla<br>";
}
$_ADODB->SetFetchMode(ADODB_FETCH_ASSOC);
//$ADODB_FORCE_TYPE = ADODB_FORCE_NULL;

$_SMARTY = new Smarty;
$_SMARTY->template_dir = $app_root.'/templates/admin';
$_SMARTY->compile_dir = $app_root.'/compile/admin';
$_SMARTY->cache_dir = $app_root.'/cache/admin';
$_SMARTY->debugging_ctrl = 'URL';

session_start();
/*
$_USER = new User($_ADODB, $db_usertable);
if(isset($_REQUEST['logout']))
    $_USER->logout();
if(!empty($_POST['login']) && !empty($_POST['password']))
    $_USER->login($_POST[login], $_POST[password]);

//if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER']!='root' || $_SERVER['PHP_AUTH_PW']!='flvby') {
if (!isset($_SERVER['PHP_AUTH_USER']) || !$_USER->login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
        header("WWW-Authenticate: Basic realm=\"math.ru\"");
        header("HTTP/1.0 401 Unauthorized");
        exit;
} 
*/

?>