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
 * @version CVS: $Id: Storage.php,v 1.6 2005/02/21 23:11:54 dufuz Exp $
 * @link http://pear.php.net/LiveUser
 */

/**
 * Abstraction class for all the storage containers
 *
 * @category authentication
 * @package  LiveUser
 * @author  Lukas Smith <smith@backendmedia.com>
 * @author  Bjoern Kraus <krausbn@php.net>
 * @copyright 2002-2005 Markus Wolff
 * @license http://www.gnu.org/licenses/lgpl.txt
 * @version Release: @package_version@
 * @link http://pear.php.net/LiveUser
 */
class LiveUser_Perm_Storage
{
    /**
     * Constructor
     *
     * @access protected
     * @param  mixed      configuration array
     * @return void
     */
    function LiveUser_Perm_Storage()
    {
        $this->_stack = &PEAR_ErrorStack::singleton('LiveUser');
    }

    /**
     *
     *
     *
     * @param array &$storageConf Array with the storage configuration
     * @return boolean true on success, false on failure.
     *
     * @access public
     */
    function init(&$storageConf)
    {
        if (is_array($storageConf)) {
            $keys = array_keys($storageConf);
            foreach ($keys as $key) {
                if (isset($this->$key)) {
                    $this->$key =& $storageConf[$key];
                }
            }
        }

        return true;
    }

    /**
     *
     *
     * @param int $authUserId
     * @param string $containerName
     * @return mixed array or false on failure
     *
     * @access public
     */
    function mapUser($authUserId, $containerName)
    {
    }

    /**
     * Reads all rights of current user into a
     * two-dimensional associative array, having the
     * area names as the key of the 1st dimension.
     * Group rights and invididual rights are being merged
     * in the process.
     *
     * @param int $permUserId
     * @return mixed array of false on failure
     *
     * @access public
     */
    function readUserRights($permUserId)
    {
    }

    /**
     *
     *
     * @param int $permUserId
     * @return mixed array or false on failure
     *
     * @access public
     */
    function readAreaAdminAreas($permUserId)
    {
    }

    /**
     * Reads all the group ids in that the user is also a member of
     * (all groups that are subgroups of these are also added recursively)
     *
     * @param int $permUserId
     * @return void
     *
     * @see    readRights()
     * @access private
     */
    function readGroups($permUserId)
    {
    } // end func readGroups

    /**
     * Reads the group rights
     * and put them in the array
     *
     * right => 1
     *
     * @param array $groupIds
     * @return  mixed   MDB2_Error on failure or nothing
     *
     * @access  public
     */
    function readGroupRights($groupIds)
    {
    } // end func readGroupRights

    /**
     *
     *
     * @param array $groupIds
     * @param array $newGroupIds
     * @return mixed array or false on failure
     *
     * @access public
     */
    function readSubGroups($groupIds, $newGroupIds)
    {
    }

    /**
     * store all properties in an array
     *
     * @param string $sessionName name of the session in use.
     * @param array $propertyValues
     * @return  array containing the property values
     *
     * @access  public
     */
    function freeze($sessionName, $propertyValues)
    {
        $_SESSION[$sessionName]['perm'] = $propertyValues;
        return $propertyValues;
    } // end func freeze

    /**
     * Reinitializes properties
     *
     * @param   array  $propertyValues
     * @return array
     *
     * @access  public
     */
    function unfreeze($sessionName)
    {
        return (isset($_SESSION[$sessionName]['perm']))
            ? $_SESSION[$sessionName]['perm'] : array();
    } // end func unfreeze

    /**
     * properly disconnect from resources
     *
     * @return void
     *
     * @access  public
     */
    function disconnect()
    {
    }
}
?>