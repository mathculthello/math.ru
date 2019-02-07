<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * A framework for authentication and authorization in PHP applications
 *
 * LiveUser is an authentication/permission framework designed
 * to be flexible and easily extendable.
 *
 * Since it is impossible to have a
 * "one size fits all" it takes a container
 * approach which should enable it to
 * be versatile enough to meet most needs.
 *
 * PHP version 4 and 5 
 *
 * LICENSE: This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public 
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston,
 * MA  02111-1307  USA 
 *
 *
 * @category authentication
 * @package  LiveUser_Admin
 * @author  Markus Wolff <wolff@21st.de>
 * @author Helgi Þormar Þorbjörnsson <dufuz@php.net>
 * @author  Lukas Smith <smith@backendmedia.com>
 * @author Arnaud Limbourg <arnaud@php.net>
 * @author   Pierre-Alain Joye  <pajoye@php.net>
 * @author  Bjoern Kraus <krausbn@php.net>
 * @copyright 2002-2005 Markus Wolff
 * @license http://www.gnu.org/licenses/lgpl.txt
 * @version CVS: $Id: MDB2.php,v 1.15 2005/02/21 23:11:52 dufuz Exp $
 * @link http://pear.php.net/LiveUser
 */

/**
 * Require parent class definition and PEAR::MDB2 class.
 */
require_once 'LiveUser/Auth/Common.php';
require_once 'MDB2.php';
MDB2::loadFile('Date');

/**
 * MDB2 container for Authentication
 *
 * This is a PEAR::MDB2 backend driver for the LiveUser class.
 * A PEAR::MDB2 connection object can be passed to the constructor to reuse an
 * existing connection. Alternatively, a DSN can be passed to open a new one.
 *
 * Requirements:
 * - File "LiveUser.php" (contains the parent class "LiveUser")
 * - Array of connection options or a PEAR::MDB2 connection object must be
 *   passed to the constructor.
 *   Example: array('dsn'                   => 'mysql://user:pass@host/db_name',
 *                  'connection             => &$conn, # PEAR::MDB2 connection object
 *                  'loginTimeout'          => 0,
 *                  'allowDuplicateHandles' => 1);
 *
 * @category authentication
 * @package  LiveUser
 * @author  Markus Wolff <wolff@21st.de>
 * @copyright 2002-2005 Markus Wolff
 * @license http://www.gnu.org/licenses/lgpl.txt
 * @version Release: @package_version@
 * @link http://pear.php.net/LiveUser
 */
class LiveUser_Auth_MDB2 extends LiveUser_Auth_Common
{
    /**
     * dsn to connect to
     *
     * @var    string
     * @access private
     */
    var $dsn = null;

    /**
     * disconnect
     *
     * @var    boolean
     * @access private
     */
    var $disconnect = false;

    /**
     * PEAR::MDB2 connection object
     *
     * @var    MDB2
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
            if (isset($conf['connection']) &&
                MDB2::isConnection($conf['connection'])
            ) {
                $this->dbc     = &$conf['connection'];
            } elseif (isset($conf['dsn'])) {
                $this->dsn = $conf['dsn'];
                $function = null;
                if (isset($conf['function'])) {
                    $function = $conf['function'];
                }
                $options = null;
                if (isset($conf['options'])) {
                    $options = $conf['options'];
                }
                $options['portability'] = MDB2_PORTABILITY_ALL;
                if ($function == 'singleton') {
                    $this->dbc =& MDB2::singleton($conf['dsn'], $options);
                } else {
                    $this->dbc =& MDB2::connect($conf['dsn'], $options);
                }
                if (PEAR::isError($this->dbc)) {
                    $this->_stack->push(LIVEUSER_ERROR_INIT_ERROR, 'error',
                        array('container' => 'could not connect: '.$this->dbc->getMessage()));
                    return false;
                }
            }
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
                 SET '    . $this->authTableCols['optional']['lastlogin']['name']
                    .'='  . $this->dbc->quote(MDB2_Date::unix2Mdbstamp($this->currentLogin), $this->authTableCols['optional']['lastlogin']['type']) . '
                 WHERE '  . $this->authTableCols['required']['auth_user_id']['name']
                    .'='  . $this->dbc->quote($this->authUserId, $this->authTableCols['required']['auth_user_id']['type']);

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
     * @param  boolean $passwd user password
     * @return boolean true on success or false on failure
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
                    $types[]  = $field_data['type'];
                }
            }
        }

        // Setting the default query.
        $sql    = 'SELECT ' . implode(',', $fields) . '
                   FROM '   . $this->authTable . '
                   WHERE '  . $this->authTableCols['required']['handle']['name'] . '='
                    . $this->dbc->quote($handle, $this->authTableCols['required']['handle']['type']);

        if (isset($this->authTableCols['required']['passwd'])
            && $this->authTableCols['required']['passwd']
        ) {
            // If $passwd is set, try to find the first user with the given
            // handle and password.
            $sql .= ' AND ' . $this->authTableCols['required']['passwd']['name'] . '='
                . $this->dbc->quote($this->encryptPW($passwd), $this->authTableCols['required']['passwd']['type']);
        }

        // Query database
        $result = $this->dbc->queryRow($sql, $types, MDB2_FETCHMODE_ASSOC);

        // If a user was found, read data into class variables and set
        // return value to true
        if (PEAR::isError($result)) {
            $this->_stack->push(
                LIVEUSER_ERROR, 'exception',
                array('reason' => $result->getMessage() . '-' . $result->getUserInfo())
            );
            return false;
        }

        if (!is_array($result)) {
            return false;
        }

        $this->handle       = $result['handle'];
        $this->passwd       = $this->decryptPW($result['passwd']);
        $this->authUserId   = $result['auth_user_id'];
        $this->isActive     = ((!isset($result['is_active']) || $result['is_active']) ? true : false);
        $this->lastLogin    = isset($result['lastlogin'])?
                                MDB2_Date::mdbstamp2Unix($result['lastlogin']):'';
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
     * properly disconnect from database
     *
     * @return void
     *
     * @access public
     */
    function disconnect()
    {
        if ($this->disconnect) {
            $result = $this->dbc->disconnect();
            if (PEAR::isError($result)) {
                $this->_stack->push(
                    LIVEUSER_ERROR, 'exception',
                    array('reason' => $result->getMessage() . '-' . $result->getUserInfo())
                );
                return false;
            }
            $this->dbc = null;
        }
        return true;
    }
}
?>