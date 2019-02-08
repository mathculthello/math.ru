<?php
$app_root = '/home/http/math';
define('APP_ROOT', '/home/http/math');
define('INCLUDE_DIR', $app_root.'/include/');
//define('SMARTY_DIR', INCLUDE_DIR.'/smarty/');
define('SMARTY_DIR', '/usr/local/share/smarty/');
define('USER_DIR', INCLUDE_DIR);
define('ADODB_DIR', INCLUDE_DIR.'/adodb/');
ini_set('include_path', INCLUDE_DIR . PATH_SEPARATOR . INCLUDE_DIR.'PEAR' . PATH_SEPARATOR . INCLUDE_DIR.'PEAR-2015' . PATH_SEPARATOR . ini_get('include_path'));
require_once SMARTY_DIR.'Smarty.class.php';
//require_once USER_DIR.'User.class.php';
require_once ADODB_DIR.'adodb.inc.php';
require_once 'admin/global.inc.php'; 
//require_once '/usr/local/share/pear/LiveUser.php';
//require_once 'LiveUser.php';

//setlocale (LC_ALL, array('ru_RU.CP1251', 'rus_RUS.1251'));

/*
 * Загружаем эти переменные из файла натсроек
$dbserver = 'localhost';
$dbname = '';
$dbuser = '';
$dbpassword = '';
$db_usertable = ''; // user information table name
 */
require_once '/usr/local/etc/mathru/ordinary.conf.php';

$dbdriver = 'mysqli';
$_ADODB = ADONewConnection($dbdriver);
//$_ADODB->debug = true; 
$_ADODB->Connect($dbserver, $dbuser, $dbpassword, $dbname);
$_ADODB->SetFetchMode(ADODB_FETCH_ASSOC);
//$_ADODB->Execute('SET NAMES cp1251');
$_ADODB->Execute('SET NAMES utf8');
//$_ADODB->Execute("SET collation_connection='cp1251_general_ci'");
//$_ADODB->Execute("SET character_set_results='cp1251'");
$ADODB_FORCE_TYPE = ADODB_FORCE_VALUE;

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
                        'fname'       => array('type' => 'text', 'name' => 'fname'),
                        'sname'       => array('type' => 'text', 'name' => 'sname'),
                        'lname'       => array('type' => 'text', 'name' => 'lname'),
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
                        'subj'       => array('type' => 'text', 'name' => 'subj'),
                        'cdkey'       => array('type' => 'text', 'name' => 'cdkey')
                    ),
                ),
                'passwordEncryptionMode' => 'MD5',
                
            )
    )
);

/* $_LU =& LiveUser::factory($liveuserConfig);
$username = isset($_REQUEST['login']) ? $_REQUEST['login'] : null;
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
$logout = isset($_REQUEST['logout']) ? $_REQUEST['logout'] : null;
$remember = isset($_REQUEST['remember']) ? $_REQUEST['remember'] : null;
$_LU->init();
if ($logout)
{
    $_LU->logout();
if (isset($_REQUEST['redirect']))
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
        Header('Location:/auth/login.php?status='.$_LU->getStatus());
    }

}
$_user_status = $_LU->getProperty('status');

// Когда не залогинен, _auth не определен
if(isset($_LU->_auth)){
$_user_login = $_LU->_auth->handle;
$_user_id = $_LU->_auth->authUserId;
} else {
$_user_login = $_user_id = null;
}

$_user_loggedin = $_LU->isLoggedIn();
$_user_email = $_LU->getProperty('email');
$_user_fullname = $_LU->getProperty('fullname');
$_user_fname = $_LU->getProperty('fname');
$_user_sname = $_LU->getProperty('sname');
$_user_lname = $_LU->getProperty('lname');
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
$_user_cdkey =  $_LU->getProperty('cdkey');
 */
//echo $_user_email . $_user_cdkey;
$_SMARTY = new Smarty;
/*
if (isset($_REQUEST['cd']))
{
    $_SESSION['cd'] = $_REQUEST['cd'];
}

if ($_SESSION['cd'])
{
    $_SMARTY->template_dir = APP_ROOT.'/templates_cd';
    $_SMARTY->compile_dir = APP_ROOT.'/compile_cd';
}
else
{
 */
    $_SMARTY->template_dir = APP_ROOT.'/templates';
    $_SMARTY->compile_dir = APP_ROOT.'/compile';
    /*
}
     */


// FIX PLUGINS
$_SMARTY->plugins_dir=array(
	'plugins',
	INCLUDE_DIR.'/smarty/plugins'
);


$_SMARTY->cache_dir = APP_ROOT.'/cache';
$_SMARTY->debugging_ctrl = 'URL';
//$_SMARTY->default_resource_type = 'cms';
/*
$_SMARTY->assign("_user_login", $_user_login);
$_SMARTY->assign("_user_loggedin", $_user_loggedin);
$_SMARTY->assign("_user_email", $_user_email);
$_SMARTY->assign("_user_fullname", $_user_fullname);
$_SMARTY->assign("_user_fname", $_user_fname);
$_SMARTY->assign("_user_sname", $_user_sname);
$_SMARTY->assign("_user_lname", $_user_lname);
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
 */

$sql = 'SELECT * FROM news ORDER BY ord LIMIT 5';
$news_titles = $_ADODB->GetAll($sql);
$_SMARTY->assign('news_titles', $news_titles);
/*
echo '<!--';
print_r($_SMARTY);
print_r($_SERVER);
print_r($_SESSION);
print_r($_REQUEST);
$path = $_SERVER['REQUEST_URI'];
        $pos = strrpos($path, '/');
        if ($pos !== false)
        {
            $path = substr($path, 0, $pos);
        }
print_r($path);
echo '\n//-->';
 */
?>
