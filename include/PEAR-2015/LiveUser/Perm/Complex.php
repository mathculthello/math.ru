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
 * @version CVS: $Id: Complex.php,v 1.9 2005/03/17 21:15:14 lsmith Exp $
 * @link http://pear.php.net/LiveUser
 */

/**
 * Require parent class definition.
 */
require_once 'LiveUser/Perm/Medium.php';

/**
 * Complex container for permission handling
 *
 * Complex permission complexity driver for LiveUser.
 *
 * @category authentication
 * @package  LiveUser
 * @author  Lukas Smith <smith@backendmedia.com>
 * @author  Bjoern Kraus <krausbn@php.net>
 * @version $Id: Complex.php,v 1.9 2005/03/17 21:15:14 lsmith Exp $
 * @copyright 2002-2005 Markus Wolff
 * @license http://www.gnu.org/licenses/lgpl.txt
 * @version Release: @package_version@
 * @link http://pear.php.net/LiveUser
 */
class LiveUser_Perm_Complex extends LiveUser_Perm_Medium
{
    /**
     * Reads all individual implied rights of current user into
     * an array of this format:
     * RightName -> Value
     *
     * @param array $rightIds
     * @param string $table
     * @return array with rightIds as key and level as value
     *
     * @access private
     */
    function _readImpliedRights($rightIds, $table)
    {
        if (!is_array($rightIds) || !count($rightIds)) {
            return null;
        }

        $queue = array();
        $result = $this->_storage->readImplyingRights($rightIds, $table);

        if (!is_array($result) || !count($result)) {
            return false;
        }
        $queue = $result;

        while (count($queue)) {
            $currentRights = reset($queue);
            $currentLevel = key($queue);
            unset($queue[$currentLevel]);

            $result = $this->_storage->readImpliedRights($currentRights, $currentLevel);
            if (!is_array($result)) {
                return false;
            }
            foreach ($result as $val) {
                // only store the implied right if the right wasn't stored before
                // or if the level is higher
                if (!isset($rightIds[$val['right_id']]) ||
                    $rightIds[$val['right_id']] < $val['right_level'])
                {
                    $rightIds[$val['right_id']] = $val['right_level'];
                    if ($val['has_implied']) {
                        $queue[$val['right_level']][] = $val['right_id'];
                    }
                }
            }
        }
        return $rightIds;
    } // end func _readImpliedRights

    /**
     * Reads all individual rights of current user into
     * an array of this format:
     * RightName -> Value
     *
     * @param int $permUserId
     * @see    readRights()
     * @return void
     *
     * @access private
     */
    function readUserRights($permUserId)
    {
        $userRights = parent::readUserRights($permUserId);
        $result = $this->_readImpliedRights($userRights, 'user');
        if ($result) {
            $this->userRights = array_merge($this->userRights, $result);
        }
        return $this->userRights;
    } // end func readUserRights

    /**
     * Reads all the group ids in that the user is also a member of
     * (all groups that are subgroups of these are also added recursively)
     *
     * @param int $permUserId
     * @see    readRights()
     * @return void
     *
     * @access private
     */
    function readGroups($permUserId)
    {
        $result = parent::readGroups($permUserId);

        // get all subgroups recursively
        while (count($result)) {
            $result = $this->readSubGroups($this->groupIds, $result);
            if (is_array($result)) {
                $this->groupIds = array_merge($result, $this->groupIds);
            }
        }
        return $this->groupIds;
    } // end func readGroups

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
        $result = $this->_storage->readSubGroups($groupIds, $newGroupIds);
        if ($result === false) {
            return false;
        }
        return $result;
    }

    /**
     * Reads all individual rights of current user into
     * a two-dimensional array of this format:
     * "GroupName" => "RightName" -> "Level"
     *
     * @param   array $groupIds array with id's for the groups
     *                          that rights will be read from
     * @see    readRights()
     * @return void
     *
      * @access private
     */
    function readGroupRights($groupIds)
    {
        $groupRights = parent::readGroupRights($groupIds);

        $result = $this->_readImpliedRights($groupRights, 'group');
        if ($result) {
            $this->groupRights = $result;
        }
        return $this->groupRights;
    } // end func readGroupRights

    /**
     * Checks if the current user has a certain right in a
     * given area at the necessary level.
     *
     * Level 1: requires that owner_user_id matches $this->permUserId
     * Level 2: requires that the $owner_group_id matches the id one of
     *          the (sub)groups that $this->permUserId is a memember of
     *          or requires that the $owner_user_id matches a perm_user_id of
     *          a memeber of one of $this->permUserId's (sub)groups
     * Level 3: no requirements
     *
     * Important note:
     *          Every ressource MAY be owned by a user and/or by a group.
     *          Therefore, $owner_user_id and/or $owner_group_id can
     *          either be an integer or null.
     *
     * @see    checkRightLevel()
     * @param  integer  $level          Level value as returned by checkRight().
     * @param  mixed  $owner_user_id  Id or array of Ids of the owner of the
                                        ressource for which the right is requested.
     * @param  mixed  $owner_group_id Id or array of Ids of the group of the
     *                                  ressource for which the right is requested.
     * @return boolean  level if the level is sufficient to grant access else false.
     *
     * @access private
     */
    function checkLevel($level, $owner_user_id, $owner_group_id)
    {
        // level above 0
        if ($level <= 0) {
            return false;
        }
        // highest level (that is level 3) or no owner id's passed
        if ($level == LIVEUSER_MAX_LEVEL
            || (is_null($owner_user_id) && is_null($owner_group_id))
        ) {
            return $level;
        }
        // level 1 or higher
        if ((!is_array($owner_user_id) && $this->permUserId == $owner_user_id) ||
            is_array($owner_user_id) && in_array($this->permUserId, $owner_user_id))
        {
            return $level;
        // level 2 or higher
        }
        if ($level >= 2) {
            // check if the ressource is owned by a (sub)group
            // that the user is part of
            if (is_array($owner_group_id)) {
                if (count(array_intersect($owner_group_id, $this->groupIds))) {
                    return $level;
                }
            } elseif (in_array($owner_group_id, $this->groupIds)) {
                return $level;
            }
        }
        return false;
    } // end func checkLevel

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
        $this->userRights = array();

        $result = $this->_storage->readAreaAdminAreas($permUserId);
        if ($result === false) {
            return false;
        }

        $this->areaAdminAreas = $result;
        return $this->areaAdminAreas;
    }
}
?>