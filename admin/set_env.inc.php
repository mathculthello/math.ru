<?php

$page = isset($_GET['page'])?$_GET['page']:null;
$o_by = isset($_GET['o_by'])?$_GET['o_by']:null;
$n = isset($_GET['n'])?$_GET['n']:null;
$o = isset($_GET['o'])?$_GET['o']:null;

$app_root = '/home/http/math';
define('INCLUDE_DIR', $app_root.'/include/');
define('SMARTY_DIR', '/usr/local/share/smarty/');
define('ADODB_DIR', INCLUDE_DIR.'/adodb');
ini_set('display_errors', 'On');
ini_set('include_path', INCLUDE_DIR.'PEAR' . PATH_SEPARATOR . INCLUDE_DIR.'PEAR-2015'. PATH_SEPARATOR . ini_get('include_path'));

require_once SMARTY_DIR.'Smarty.class.php';
require_once ADODB_DIR.'/adodb.inc.php';
require_once INCLUDE_DIR.'/User.class.php';
require_once 'global.inc.php';
require_once 'LiveUser.php';

setlocale (LC_ALL, array('ru_RU.CP1251', 'rus_RUS.1251'));


/*
 * Загружаем эти переменные из файла настроек
$dbserver = '';
$dbname = '';
$dbuser = '';
$dbpassword = '';
 */
require_once '/usr/local/etc/mathru/admin.conf.php';

$dbdriver = 'mysqli';
$db_usertable = 'user'; // user information table name
$_ADODB = ADONewConnection($dbdriver);
//$_ADODB->debug = true;
$_ADODB->Connect($dbserver, $dbuser, $dbpassword, $dbname);
$_ADODB->SetFetchMode(ADODB_FETCH_ASSOC);
//$_ADODB->Execute('SET NAMES cp1251');
$_ADODB->Execute('SET NAMES utf8');
//$_ADODB->Execute("SET collation_connection='utf8_general_ci'");
//$_ADODB->Execute("SET character_set_results='utf8'");
$ADODB_FORCE_TYPE = ADODB_FORCE_VALUE;
//$ADODB_FORCE_TYPE = ADODB_FORCE_NULL;

$_SMARTY = new Smarty;
$_SMARTY->template_dir = $app_root.'/templates/admin';
$_SMARTY->compile_dir = $app_root.'/compile/admin';
$_SMARTY->cache_dir = $app_root.'/cache/admin';
$_SMARTY->debugging_ctrl = 'URL';

//session_start();
//$_USER = new User($_ADODB, $db_usertable);
//if(isset($_REQUEST['logout'])) {
////    $_USER->logout();
//    unset($_SERVER['PHP_AUTH_USER']);
//}
/*
if(!empty($_POST['login']) && !empty($_POST['password']))
    $_USER->login($_POST[login], $_POST[password]);
*/

//if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER']!='root' || $_SERVER['PHP_AUTH_PW']!='flvby') {
//if (!isset($_SERVER['PHP_AUTH_USER']) || !$_USER->login($_SERVER['PHP_AUTH_USER'], md5($_SERVER['PHP_AUTH_PW']))) {
//        header("WWW-Authenticate: Basic realm=\"math.ru\"");
//        header("HTTP/1.0 401 Unauthorized");
//        exit;
//}

$liveuserConfig = array(
    'authContainers' => array(
            0 => array(
               'type'              => 'PHPBB2',
               'connection' => $_ADODB,
               'authTable'     => 'user',
               'authTableCols' => array(
                    'required' => array(
                        'auth_user_id' => array('type' => 'text', 'name' => 'id'),
                        'handle'       => array('type' => 'text', 'name' => 'login'),
                        'passwd'       => array('type' => 'text', 'name' => 'password'),
                    ),
                    'custom' => array(
                        'email'       => array('type' => 'text', 'name' => 'email'),
                        'fullname'       => array('type' => 'text', 'name' => 'fullname'),
                        'city'       => array('type' => 'text', 'name' => 'city'),
                        'country'       => array('type' => 'text', 'name' => 'country'),
                        'region'       => array('type' => 'text', 'name' => 'region'),
                        'profile'       => array('type' => 'text', 'name' => 'profile'),
                        'status'       => array('type' => 'text', 'name' => 'status'),
                        'form'       => array('type' => 'text', 'name' => 'form'),
                        'school'       => array('type' => 'text', 'name' => 'school'),
                        'form_profile'       => array('type' => 'text', 'name' => 'form_profile'),
                        'school_profile'       => array('type' => 'text', 'name' => 'school_profile'),
                        'district'       => array('type' => 'text', 'name' => 'district'),
                        'subj'       => array('type' => 'text', 'name' => 'subj')
                    ),
                ),
                'passwordEncryptionMode' => 'MD5',

            )
    )
);

$_LU = LiveUser::factory($liveuserConfig);
$username = isset($_REQUEST['login']) ? $_REQUEST['login'] : null;
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
$logout = isset($_REQUEST['logout']) ? $_REQUEST['logout'] : null;
$remember = isset($_REQUEST['remember']) ? $_REQUEST['remember'] : null;
$_LU->init();
//print_r($_REQUEST);
if ($logout)
{
    $_LU->logout();
    if ($_REQUEST['redirect'])
    {
        Header('Location:'.$_REQUEST['redirect']);
    }
}
elseif ($username)
{
    $_LU->login($username, $password, $remember);
    if ($_LU->isLoggedIn() && $_REQUEST['redirect'])
    {
        Header('Location:'.$_REQUEST['redirect']);
    }
    elseif (!$_LU->isLoggedIn())
    {
        Header('Location:/auth/login.php?redirect=/admin/&status='.$_LU->getStatus());
    }

}

$_user_status = $_LU->getProperty('status');
//$_user_login = $_LU->_auth->handle;
//$_user_id = $_LU->_auth->authUserId;
$_user_loggedin = $_LU->isLoggedIn();
$_user_email = $_LU->getProperty('email');
$_user_fullname = $_LU->getProperty('fullname');
$_user_city = $_LU->getProperty('city');
$_user_country = $_LU->getProperty('country');
$_user_region = $_LU->getProperty('region');
$_user_profile =  $_LU->getProperty('profile');
$_user_district =  $_LU->getProperty('district');
$_user_school =  $_LU->getProperty('school');
$_user_school_profile =  $_LU->getProperty('school_profile');
$_user_form =  $_LU->getProperty('form');
$_user_form_profile =  $_LU->getProperty('form_profile');
$_user_subj =  $_LU->getProperty('subj');

//if (!$_user_loggedin || ($_user_status != 'admin' && $_user_status != 'editor' && $_user_status != 'dic_editor' && $_user_status != 'teacher_editor'))
//{
//var_dump($_LU->_auth);
//    Header('Location: /auth/login.php?redirect=/admin/');
//    exit;
//echo $_user_loggedin;
//echo $_user_status;
//echo $_user_email;
//}


// FIX PLUGINS
$_SMARTY->plugins_dir=array(
	'plugins',
	INCLUDE_DIR.'/smarty/plugins'
);


//$_SMARTY->assign("_user_login", $_user_login);
$_SMARTY->assign("_user_status", $_user_status);
$_SMARTY->assign("_user_loggedin", $_user_loggedin);
$_SMARTY->assign("_user_email", $_user_email);
$_SMARTY->assign("_user_fullname", $_user_fullname);
$_SMARTY->assign("_user_city", $_user_city);
$_SMARTY->assign("_user_country", $_user_country);
$_SMARTY->assign("_user_region", $_user_region);
$_SMARTY->assign("_user_profile", $_user_profile);
$_SMARTY->assign("_user_form", $_user_form);
$_SMARTY->assign("_user_school", $_user_school);
$_SMARTY->assign("_user_school_profile", $_user_school_profile);
$_SMARTY->assign("_user_form_profile", $_user_form_profile);
$_SMARTY->assign("_user_district", $_user_district);
$_SMARTY->assign("_user_subj", $_user_subj);
if(isset($_REQUEST['redirect']))
	$_SMARTY->assign('redirect', $_REQUEST['redirect']);


?>
