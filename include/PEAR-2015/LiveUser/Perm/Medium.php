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
 * @version CVS: $Id: Medium.php,v 1.8 2005/02/21 23:11:54 dufuz Exp $
 * @link http://pear.php.net/LiveUser
 */

/**

 *
 * @package  LiveUser
 * @category authentication
 */

/**
 * Require parent class definition.
 */
require_once 'LiveUser/Perm/Simple.php';

/**
 * Medium container for permission handling
 *
 * Medium permission complexity driver for LiveUser.
 *
 * @category authentication
 * @package  LiveUser
 * @author   Arnaud Limbourg
 * @copyright 2002-2005 Markus Wolff
 * @license http://www.gnu.org/licenses/lgpl.txt
 * @version Release: @package_version@
 * @link http://pear.php.net/LiveUser
 */
class LiveUser_Perm_Medium extends LiveUser_Perm_Simple
{
    /**
     * One-dimensional array containing all the groups
     * ids for the actual user.
     *
     * Format: "RightId" => "Level"
     *
     * @var array
     * @access public
     */
    var $groupIds = array();

    /**
     * One-dimensional array containing only the group
     * rights for the actual user.
     *
     * Format: "RightId" => "Level"
     *
     * @var array
     * @access public
     */
    var $groupRights = array();

    /**
     * Reads all rights of current user into an
     * associative array.
     * Group rights and invididual rights are being merged
     * in the process.
     *
     * @return void
     *
     * @access private
     */
    function readRights()
    {
        $this->rights = array();

        $result = $this->readUserRights($this->permUserId);
        if ($result === false) {
            return false;
        }

        if ($this->userType == LIVEUSER_AREAADMIN_TYPE_ID) {
            $result = $this->readAreaAdminAreas($this->permUserId);
            if ($result === false) {
               return false;
            }

            if (is_array($this->areaAdminAreas)) {
                if (is_array($this->userRights)) {
                    $this->userRights = $this->areaAdminAreas + $this->userRights;
                } else {
                    $this->userRights = $this->areaAdminAreas;
                }
            }
        }

        $result = $this->readGroups($this->permUserId);
        if ($result === false) {
            return false;
        }

        $result = $this->readGroupRights($this->groupIds);
        if ($result === false) {
            return false;
        }

        $tmpRights = $this->groupRights;

        // Check if user has individual rights...
        if (is_array($this->userRights)) {
            // Overwrite values from temporary array with values from userrights
            foreach ($this->userRights as $right => $level) {
                if (isset($tmpRights[$right])) {
                    if ($level < 0) {
                        // Revoking rights: A negative value indicates that the
                        // right level is lowered or the right is even revoked
                        // despite the group memberships of this user
                        $tmpRights[$right] = $tmpRights[$right] + $level;
                    } else {
                        $tmpRights[$right] = max($tmpRights[$right], $level);
                    }
                } else {
                    $tmpRights[$right] = $level;
                }
            }
        }

        // Strip values from array if level is not greater than zero
        if (is_array($tmpRights)) {
            foreach ($tmpRights as $right => $level) {
               if ($level > 0) {
                   $this->rights[$right] = $level;
               }
            }
        }

        return $this->rights;
    } // end func readRights

    /**
     *
     *
     * @param int $permUserId
     * @return mixed array or false on failure
     *
     * @access public
     */
    function readGroups($permUserId)
    {
        $this->groupIds = array();

        $result = $this->_storage->readGroups($permUserId);
        if ($result === false) {
            return false;
        }

        $this->groupIds = $result;
        return $this->groupIds;
    }

    /**
     *
     *
     * @param array $groupIds
     * @return mixed array or false on failure
     *
     * @access public
     */
    function readGroupRights($groupIds)
    {
        $this->groupRights = array();

        if (!is_array($groupIds) || !count($groupIds)) {
            return null;
        }

        $result = $this->_storage->readGroupRights($groupIds);
        if ($result === false) {
            return false;
        }

        $this->groupRights = $result;
        return $this->groupRights;
    }

    /**
     * Checks if the current user is a member of a certain group
     * If $this->ondemand and $ondemand is true, the groups will be loaded on
     * the fly.
     *
     * @param   integer $group_id  Id of the group to check for.
     * @param   boolean $ondemand  allow ondemand reading of groups
     * @return  boolean. If groupIds isn't populated then false, 
                         if the group_id exists in groupIds then true else false.
     *
     * @access  public
     */
    function checkGroup($group_id)
    {
        if (is_array($this->groupIds)) {
            return in_array($group_id, $this->groupIds);
        }
        return false;
    } // end func checkGroup
} // end class LiveUser_Perm_Container_MDB2_Medium
?>