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
 * @version CVS: $Id: MDB.php,v 1.9 2005/02/21 23:11:54 dufuz Exp $
 * @link http://pear.php.net/LiveUser
 */

/**
 * Require parent class definition.
 */
require_once 'LiveUser/Perm/Storage/SQL.php';
require_once 'MDB.php';

/**
 * MDB container for permission handling
 *
 * This is a PEAR::MDB backend driver for the LiveUser class.
 * A PEAR::MDB connection object can be passed to the constructor to reuse an
 * existing connection. Alternatively, a DSN can be passed to open a new one.
 *
 * Requirements:
 * - File "Liveuser.php" (contains the parent class "LiveUser")
 * - Array of connection options or a PEAR::MDB connection object must be
 *   passed to the constructor.
 *   Example: array('dsn' => 'mysql://user:pass@host/db_name')
 *              OR
 *            &$conn (PEAR::MDB connection object)
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
class LiveUser_Perm_Storage_MDB extends LiveUser_Perm_Storage_SQL
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
    function init($storageConf)
    {
        parent::init($storageConf);

        if (isset($storageConf['connection']) &&
            MDB::isConnection($storageConf['connection'])
        ) {
            $this->dbc = &$storageConf['connection'];
        } elseif (isset($storageConf['dsn'])) {
            $this->dsn = $storageConf['dsn'];
            $function = null;
            if (isset($storageConf['function'])) {
                $function = $storageConf['function'];
            }
            $options = null;
            if (isset($storageConf['options'])) {
                $options = $storageConf['options'];
            }
            $options['portability'] = MDB_PORTABILITY_ALL;
            if ($function == 'singleton') {
                $this->dbc =& MDB::singleton($storageConf['dsn'], $options);
            } else {
                $this->dbc =& MDB::connect($storageConf['dsn'], $options);
            }
            if (PEAR::isError($this->dbc)) {
                $this->_stack->push(LIVEUSER_ERROR_INIT_ERROR, 'error',
                    array('container' => 'could not connect: '.$this->dbc->getMessage()));
                return false;
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
        $query = '
            SELECT
                ' . $this->alias['perm_user_id'] . ' AS perm_user_id,
                ' . $this->alias['perm_type'] . '    AS perm_type
            FROM
                '.$this->prefix.'perm_users
            WHERE
                ' . $this->alias['auth_user_id'] . ' = '.
                    $this->dbc->getValue($this->fields[$this->alias['auth_user_id']], $authUserId).'
            AND
                ' . $this->alias['auth_container_name'] . ' = '.
                    $this->dbc->getValue($this->fields[$this->alias['auth_container_name']], $containerName);

        $types = array(
            $this->fields[$this->alias['perm_user_id']],
            $this->fields[$this->alias['perm_type']]
        );
        $result = $this->dbc->queryRow($query, $types, MDB_FETCHMODE_ASSOC);

        if (PEAR::isError($result)) {
            $this->_stack->push(LIVEUSER_ERROR, 'exception', array(),
                'error in query' . $result->getMessage . '-' . $result->getUserInfo());
            return false;
        }

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
        $query = '
            SELECT
                R.' . $this->alias['right_id'] . ',
                U.' . $this->alias['right_level'] . '
            FROM
                '.$this->prefix.'rights R,
                '.$this->prefix.'userrights U
            WHERE
                R.' . $this->alias['right_id'] . ' = U.' . $this->alias['right_id'] . '
            AND
                U.' . $this->alias['perm_user_id'] . ' = '.
                    $this->dbc->getValue($this->fields[$this->alias['perm_user_id']], $permUserId);

        $types = array(
            $this->fields[$this->alias['right_id']],
            $this->fields[$this->alias['right_level']]
        );
        $result = $this->dbc->queryAll($query, $types, MDB_FETCHMODE_ORDERED, true);

        if (PEAR::isError($result)) {
            $this->_stack->push(LIVEUSER_ERROR, 'exception', array(),
                'error in query' . $result->getMessage . '-' . $result->getUserInfo());
            return false;
        }

        return $result;
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
        // get all areas in which the user is area admin
        $query = '
            SELECT
                R.' . $this->alias['right_id'] . ' AS right_id,
                '.LIVEUSER_MAX_LEVEL.'             AS right_level
            FROM
                '.$this->prefix.'area_admin_areas AAA,
                '.$this->prefix.'rights R
            WHERE
                AAA.area_id = R.area_id
            AND
                AAA.' . $this->alias['perm_user_id'] . ' = '.
                    $this->dbc->getValue($this->fields[$this->alias['perm_user_id']], $permUserId);

        $types = array(
            $this->fields[$this->alias['right_id']],
            $this->fields[$this->alias['right_level']]
        );
        $result = $this->dbc->queryAll($query, $types, MDB_FETCHMODE_ORDERED, true);

        if (PEAR::isError($result)) {
            $this->_stack->push(LIVEUSER_ERROR, 'exception', array(),
                'error in query' . $result->getMessage . '-' . $result->getUserInfo());
            return false;
        }

        return $result;
    }

    /**
     * Reads all the group ids in that the user is also a member of
     * (all groups that are subgroups of these are also added recursively)
     *
    
     * @param int $permUserId
     * @return mixed array or false on failure
     *
     * @access private
     * @see    readRights()
     */
    function readGroups($permUserId)
    {
        $query = '
            SELECT
                GU.' . $this->alias['group_id'] . '
            FROM
                '.$this->prefix.'groupusers GU,
                '.$this->prefix.'groups G
            WHERE
                GU.' . $this->alias['group_id'] . ' = G. ' . $this->alias['group_id'] . '
            AND
                GU.' . $this->alias['perm_user_id'] . ' = '.
                    $this->dbc->getValue($this->fields[$this->alias['perm_user_id']], $permUserId);

        if (isset($this->tables['groups']['fields']['is_active'])) {
            $query .= ' AND
                G.' . $this->alias['is_active'] . '=' .
                    $this->dbc->getValue($this->fields[$this->alias['is_active']], true);
        }

        $result = $this->dbc->queryCol($query, $this->fields[$this->alias['group_id']]);

        if (PEAR::isError($result)) {
            $this->_stack->push(LIVEUSER_ERROR, 'exception', array(),
                'error in query' . $result->getMessage . '-' . $result->getUserInfo());
            return false;
        }

        return $result;
    } // end func readGroups

    /**
     * Reads the group rights
     * and put them in the array
     *
     * right => 1
     *
     * @param   array $groupIds array with id's for the groups
     *                          that rights will be read from
     * @return  mixed   array or false on failure
     *
     * @access  public
     */
    function readGroupRights($groupIds)
    {
        $query = '
            SELECT
                GR.' . $this->alias['right_id'] . ',
                MAX(GR.' . $this->alias['right_level'] . ')
            FROM
                '.$this->prefix.'grouprights GR
            WHERE
                GR.' . $this->alias['group_id'] . ' IN('.
                    implode(', ', $groupIds).')
            GROUP BY
                GR.' . $this->alias['right_id'] . '';

        $types = array(
            $this->fields[$this->alias['right_id']],
            $this->fields[$this->alias['right_level']]
        );
        $result = $this->dbc->queryAll($query, $types, MDB_FETCHMODE_ORDERED, true);

        if (PEAR::isError($result)) {
            $this->_stack->push(LIVEUSER_ERROR, 'exception', array(),
                'error in query' . $result->getMessage . '-' . $result->getUserInfo());
            return false;
        }

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
        $query = '
            SELECT
                DISTINCT SG.' . $this->alias['subgroup_id'] . '
            FROM
                '.$this->prefix.'groups G,
                '.$this->prefix.'group_subgroups SG
            WHERE
                SG.' . $this->alias['subgroup_id'] . ' = G.' .
                    $this->alias['group_id'] . '
            AND
                SG.' . $this->alias['group_id'] . ' IN ('.
                    implode(', ', $newGroupIds).')
            AND
                SG.' . $this->alias['subgroup_id'] . ' NOT IN ('.
                    implode(', ', $groupIds).')';

        if (isset($this->tables['groups']['fields']['is_active'])) {
            $query .= ' AND
                G.' . $this->alias['is_active'] . '=' .
                    $this->dbc->getValue($this->fields[$this->alias['is_active']], true);
        }

        $result = $this->dbc->queryCol($query, $this->fields[$this->alias['group_id']]);

        if (PEAR::isError($result)) {
            $this->_stack->push(LIVEUSER_ERROR, 'exception', array(),
                'error in query' . $result->getMessage . '-' . $result->getUserInfo());
            return false;
        }

        return $result;
    }

    /**
     *
     *
     * @param array $rightIds
     * @param string $table
     * @return mixed array or false on failure
     *
     * @access public
     */
    function readImplyingRights($rightIds, $table)
    {
        $query = '
            SELECT
            DISTINCT
                TR.' . $this->alias['right_level'] . ',
                TR.' . $this->alias['right_id'] . '
            FROM
                '.$this->prefix.'rights R,
                '.$this->prefix.$table.'rights TR
            WHERE
                TR.' . $this->alias['right_id'] . ' = R.' . $this->alias['right_id'] . '
            AND
                R.' . $this->alias['right_id'] . ' IN ('.
                    implode(', ', array_keys($rightIds)).')
            AND
                R.' . $this->alias['has_implied'] . '='.
                    $this->dbc->getValue($this->fields[$this->alias['has_implied']], true);

        $types = array(
            $this->fields[$this->alias['right_level']],
            $this->fields[$this->alias['right_id']],
        );
        $result = $this->dbc->queryAll($query, $types, MDB_FETCHMODE_ORDERED, true, false, true);

        if (PEAR::isError($result)) {
            $this->_stack->push(LIVEUSER_ERROR, 'exception', array(),
                'error in query' . $result->getMessage . '-' . $result->getUserInfo());
            return false;
        }

        return $result;
    }

    /**
    *
    *
    * @param array $currentRights
    * @param string $currentLevel
    * @return mixed array or false on failure
    *
    * @access public
    */
    function readImpliedRights($currentRights, $currentLevel)
    {
        $query = '
            SELECT
                RI.' . $this->alias['implied_right_id'] . ' AS right_id,
                '.$currentLevel.'                           AS right_level,
                R.' . $this->alias['has_implied'] . '       AS has_implied
            FROM
                '.$this->prefix.'rights R,
                '.$this->prefix.'right_implied RI
            WHERE
                RI.' . $this->alias['implied_right_id'] . ' = R.' . $this->alias['right_id'] . '
            AND
                RI.' . $this->alias['right_id'] . ' IN ('.
                    implode(', ', $currentRights).')';

        $types = array(
            $this->fields[$this->alias['right_id']],
            $this->fields[$this->alias['right_level']],
            $this->fields[$this->alias['has_implied']]
        );
        $result = $this->dbc->queryAll($query, $types, MDB_FETCHMODE_ASSOC);

        if (PEAR::isError($result)) {
            $this->_stack->push(LIVEUSER_ERROR, 'exception', array(),
                'error in query' . $result->getMessage . '-' . $result->getUserInfo());
            return false;
        }

        return $result;
    }
}
?>