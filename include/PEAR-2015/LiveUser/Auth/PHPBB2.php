<?php
require_once 'LiveUser/Auth/Common.php';

class LiveUser_Auth_PHPBB2 extends LiveUser_Auth_Common
{
    /**
     * disconnect
     *
     * @var    boolean
     * @access private
     */
    var $disconnect = false;

    /**
     * ADODB connection object
     *
     * @var    ADODB
     * @access private
     */
    var $dbc = null;

    /**
     * Auth table
     * Table where the auth data is stored.
     * 
     * @var    string
     * @access public
     */
    var $authTable = 'liveuser_users';

    var $phpbbAuthTable = 'phpbb_users';
    var $phpbbSessionTable = 'phpbb_sessions';
    var $phpbbRootPath = '/home/http/math/html/forum/';

    /**
     * Load the storage container
     *
     * @param  mixed &$conf   Name of array containing the configuration.
     * @param string $containerName name of the container that should be used
     * @return  boolean true on success or false on failure
     *
     * @access  public
     */
    function init(&$conf, $containerName)
    {
        parent::init($conf, $containerName);

        if (is_array($conf)) {
//            if (isset($conf['connection']) &&
//                DB::isConnection($conf['connection'])
//            ) {
//                $this->dbc     = &$conf['connection'];
//            } elseif (isset($conf['dsn'])) {
//                $this->dsn = $conf['dsn'];
//                $options = null;
//                if (isset($conf['options'])) {
//                    $options = $conf['options'];
//                }
//                $options['portability'] = DB_PORTABILITY_ALL;
//                $this->dbc =& DB::connect($conf['dsn'], $options);
//                if (PEAR::isError($this->dbc)) {
//                    $this->_stack->push(LIVEUSER_ERROR_INIT_ERROR, 'error',
//                        array('container' => 'could not connect: '.$this->dbc->getMessage()));
//                    return false;
//                }
//            }
            $this->dbc = &$conf['connection'];
        }
        return true;
    }

    /**
     * Writes current values for user back to the database.
     * This method does nothing in the base class and is supposed to
     * be overridden in subclasses according to the supported backend.
     *
     * @return boolean true on success or false on failure
     *
     * @access private
     */
    function _updateUserData()
    {
        if (!isset($this->authTableCols['optional']['lastlogin'])) {
            return true;
        }

        $sql  = 'UPDATE ' . $this->authTable.'
                 SET '    . $this->authTableCols['optional']['lastlogin']['name'] . '=' .
                    $this->dbc->quoteSmart(date('Y-m-d H:i:s', $this->currentLogin)) . '
                 WHERE '  . $this->authTableCols['required']['auth_user_id']['name']   . '=' .
                    $this->dbc->quoteSmart($this->authUserId);

        $result = $this->dbc->query($sql);

        if (PEAR::isError($result)) {
            $this->_stack->push(
                LIVEUSER_ERROR, 'exception',
                array('reason' => $result->getMessage() . '-' . $result->getUserInfo())
            );
            return false;
        }

        return true;
    }

    /**
     * Reads auth_user_id, passwd, is_active flag
     * lastlogin timestamp from the database
     * If only $handle is given, it will read the data
     * from the first user with that handle and return
     * true on success.
     * If $handle and $passwd are given, it will try to
     * find the first user with both handle and password
     * matching and return true on success (this allows
     * multiple users having the same handle but different
     * passwords - yep, some people want this).
     * If no match is found, false is being returned.
     *
     * @param  string $handle  user handle
     * @param  boolean $passwd  user password
     * @return boolean  true upon success or false on failure
     *
     * @access private
     */
    function _readUserData($handle, $passwd = '')
    {
        $fields = array();
        foreach ($this->authTableCols as $value) {
            if (sizeof($value) > 0) {
                foreach ($value as $alias => $field_data) {
                    $fields[] = $field_data['name'] . ' AS ' . $alias;
                }
            }
        }

        // Setting the default sql query.
        $sql    = 'SELECT ' . implode(',', $fields) . '
                   FROM   ' . $this->authTable.'
                   WHERE  ' . $this->authTableCols['required']['handle']['name'] . '=\''
                    . addslashes($handle).'\'';
//                    . $this->dbc->quoteSmart($handle);
        if (isset($this->authTableCols['required']['passwd'])
            && $this->authTableCols['required']['passwd']
        ) {
            // If $passwd is set, try to find the first user with the given
            // handle and password.
            $sql .= ' AND   ' . $this->authTableCols['required']['passwd']['name'] . '=\''
                . addslashes($this->encryptPW($passwd)).'\'';
//                . $this->dbc->quoteSmart($this->encryptPW($passwd));
        }

        // Query database
        $result = $this->dbc->GetRow($sql);

        if ($result === false) {
        // If a user was found, read data into class variables and set
        // return value to true
            $this->_stack->push(
                LIVEUSER_ERROR, 'exception',
                array('reason' => $this->dbc->ErrorMsg())
            );
            return false;
        }

        if (!is_array($result) || count($result) == 0) {
            return false;
        }

        $this->handle       = $result['handle'];
        $this->passwd       = $this->decryptPW($result['passwd']);
        $this->authUserId   = $result['auth_user_id'];
        $this->isActive     = ((!isset($result['is_active']) || $result['is_active'] == 'Y') ? true : false);
        $this->lastLogin    = !empty($result['lastlogin']) ?
                                strtotime($result['lastlogin']) : '';
        $this->ownerUserId  = isset($result['owner_user_id']) ? $result['owner_user_id'] : null;
        $this->ownerGroupid = isset($result['owner_group_id']) ? $result['owner_group_id'] : null;
        if (isset($this->authTableCols['custom'])) {
            foreach ($this->authTableCols['custom'] as $alias => $value) {
                $alias = strtolower($alias);
                $this->propertyValues['custom'][$alias] = $result[$alias];
            }
        }

        return true;
    }

    /**
     * Properly disconnect from database
     *
     * @return void
     *
     * @access public
     */
    function disconnect()
    {
        if ($this->disconnect) {
//            $result = $this->dbc->disconnect();
//            if (PEAR::isError($result)) {
//                $this->_stack->push(
//                    LIVEUSER_ERROR, 'exception',
//                    array('reason' => $result->getMessage() . '-' . $result->getUserInfo())
//                );
//                return false;
//            }
//            $this->dbc = null;
        }
        return true;
    }
    
    function login($handle, $passwd, $remember = false)
    {

        $success = parent::login($handle, $passwd);
        
        if ($success)
        {
            global $db, $board_config;
            global $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $SID;
            global $theme, $images;
            global $template, $lang, $phpEx, $phpbb_root_path;
            global $nav_links;
            
            define("IN_LOGIN", true);

            define('IN_PHPBB', true);
            $phpbb_root_path = $this->phpbbRootPath;
            include($phpbb_root_path . 'extension.inc');
            include($phpbb_root_path . 'common.'.$phpEx);
            $userdata = session_pagestart($user_ip, PAGE_LOGIN);
            init_userprefs($userdata);
            
            if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
            {
                $sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
            }
            else
            {
                $sid = '';
            }
 
            $session_id = session_begin($this->authUserId, $user_ip, PAGE_INDEX, FALSE, $remember);
        }
    }
    
    function logout()
    {
            
            global $db, $board_config;
            global $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $SID;
            global $theme, $images;
            global $template, $lang, $phpEx, $phpbb_root_path;
            global $nav_links;
            
            define("IN_LOGIN", true);

            define('IN_PHPBB', true);
            $phpbb_root_path = $this->phpbbRootPath;
            include($phpbb_root_path . 'extension.inc');
            include($phpbb_root_path . 'common.'.$phpEx);
            $userdata = session_pagestart($user_ip, PAGE_LOGIN);
            init_userprefs($userdata);
            
            if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
            {
                $sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
            }
            else
            {
                $sid = '';
            }
            session_end($userdata['session_id'], $userdata['user_id']);
    }
}
?>