<?php

define('APP_ROOT', dirname(__DIR__));
define('INCLUDE_DIR', APP_ROOT.'/include/');
set_include_path(
	APP_ROOT . PATH_SEPARATOR . 
	INCLUDE_DIR . PATH_SEPARATOR . 
	INCLUDE_DIR.'PEAR' . PATH_SEPARATOR .
	INCLUDE_DIR.'PEAR-2015' . PATH_SEPARATOR .
	'/usr/local/share/adodb'. PATH_SEPARATOR .
	'/usr/local/share/smarty' . PATH_SEPARATOR .
	get_include_path());

require_once 'vendor/autoload.php';
require_once 'Smarty.class.php';
require_once 'admin/global.inc.php'; 
require_once 'adodb.inc.php';

/*
 * DOTENV
 * LOAD PARAMETERS
 */
use Symfony\Component\Dotenv\Dotenv;

$dotenv=new Dotenv();
$dotenv->load(APP_ROOT.'/.env');

/* 
 * DEBUG
 */
if(getenv('DEBUG')=='TRUE')
	ini_set('display_errors', 'on');

/*
 * PDO
 * CONNECT TO DATABASE
 */
$dbserver = getenv('DB_SERVER');
$dbname = getenv('DB_NAME');
$dbuser = getenv('DB_USER');
$dbpassword = getenv('DB_PASS');
$_PDO = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpassword);
$_PDO->exec('SET NAMES utf8');


/*
 * ADODB
 * CONNECT TO DATABASE
 * COMPATIBILITY MODE
 */
$dbdriver = 'mysqli';
$_ADODB = ADONewConnection($dbdriver);
$_ADODB->Connect($dbserver, $dbuser, $dbpassword, $dbname);
$_ADODB->SetFetchMode(ADODB_FETCH_ASSOC);
$_ADODB->Execute('SET NAMES utf8');
$ADODB_FORCE_TYPE = ADODB_FORCE_VALUE;

/*
 * SMARTY
 * BOOTSTRAP TEMPLATE ENGINE
 */
$_SMARTY = new Smarty;
$_SMARTY->template_dir = APP_ROOT.'/templates';
$_SMARTY->compile_dir = APP_ROOT.'/compile';

// FIX PLUGINS
$_SMARTY->plugins_dir=array(
	'plugins',
	INCLUDE_DIR.'/smarty/plugins'
);

$_SMARTY->cache_dir = APP_ROOT.'/cache';
$_SMARTY->debugging_ctrl = 'URL';

/* 
 * LOAD NEWS
 */
$sql = 'SELECT * FROM news ORDER BY ord LIMIT 5';
$sth = $_PDO->query($sql);
$news_titles = $sth->fetchAll();
$_SMARTY->assign('news_titles', $news_titles);

?>
