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
 * @version CVS: $Id: Cache.php,v 1.8 2005/03/24 08:52:03 lsmith Exp $
 * @link http://pear.php.net/LiveUser
 */

/**
 * Require parent class definition.
 */
require_once 'LiveUser/Perm/Storage.php';

/**
 * Cache container for permission handling
 *
 * This is a Cache backend driver for the LiveUser class.
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
class LiveUser_Perm_Storage_Cache extends LiveUser_Perm_Storage
{
    /**
     *
     *
     *
     * @param array &$storageConf Array with the storage configuration
     * @return boolean true on success, false on failure.
     *
     * @access public
     */
    function init(&$storageConf, &$confArray)
    {
        parent::init($storageConf);

        $this->_storage = LiveUser::storageFactory($confArray);
        if ($this->_storage === false) {
            $this->_stack->push(LIVEUSER_ERROR, 'exception',
                array('msg' => 'Could not instanciate storage container'));
            return false;
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
        if (in_cache) {
            return cache;
        }
        $result = $this->_storage->mapUser($authUserId, $containerName);
        if ($result === false) {
            return false;
        }
        write_into_cache
        return $result;
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
        if (in_cache) {
            return cache;
        }
        $result = $this->_storage->readUserRights($permUserId);
        if ($result === false) {
            return false;
        }
        write_into_cache
        return $result;
    }

    function readAreaAdminAreas($permUserId)
    {
        if (in_cache) {
            return cache;
        }
        $result = $this->_storage->readAreaAdminAreas($permUserId);
        if ($result === false) {
            return false;
        }
        write_into_cache
        return $result;
    }

    /**
     * Reads all the group ids in that the user is also a member of
     * (all groups that are subgroups of these are also added recursively)
     *
     * @param int $permUserId
     * @return void
     *
     * @access private
     * @see    readRights()
     */
    function readGroups($permUserId)
    {
        if (in_cache) {
            return cache;
        }
        $result = $this->_storage->readGroups($permUserId);
        if ($result === false) {
            return false;
        }
        write_into_cache
        return $result;
    } // end func readGroups

    /**
     * Reads the group rights
     * and put them in the array
     *
     * right => 1
     *
     * @param array $groupRights
     * @return  boolean
     *
     * @access  public
     */
    function readGroupRights($groupIds)
    {
        if (in_cache) {
            return cache;
        }
        $result = $this->_storage->readGroupRights($groupIds);
        if ($result === false) {
            return false;
        }
        write_into_cache
        return $result;
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
        if (in_cache) {
            return cache;
        }
        $result = $this->_storage->readSubGroups($groupIds, $newGroupIds);
        if ($result === false) {
            return false;
        }
        write_into_cache
        return $result;
    }

    function readImplyingRights($rightIds, $table)
    {
        if (in_cache) {
            return cache;
        }
        $result = $this->_storage->readImplyingRights($rightIds, $table);
        if ($result === false) {
            return false;
        }
        write_into_cache
        return $result;
    }

    function readImpliedRights($currentRights, $currentLevel)
    {
        if (in_cache) {
            return cache;
        }
        $result = $this->_storage->readImpliedRights($currentRights, $currentLevel);
        if ($result === false) {
            return false;
        }
        write_into_cache
        return $result;
    }

    /**
     * properly disconnect from resources
     *
     * @return void
     *
     * @access  public
     */
    function disconnect()
    {
        $this->_storage->disconnect();
    }
}
?>