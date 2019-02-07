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
 * @version CVS: $Id: SQL.php,v 1.17 2005/02/21 23:11:54 dufuz Exp $
 * @link http://pear.php.net/LiveUser
 */

/**
 * Require parent class definition.
 */
require_once 'LiveUser/Perm/Storage.php';
require_once 'LiveUser/Perm/Storage/Globals.php';

/**
 * SQL container for permission handling
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
class LiveUser_Perm_Storage_SQL extends LiveUser_Perm_Storage
{
    /**
     * dsn that was connected to
     * @var object
     * @access private
     */
    var $dsn = null;

    /**
     * PEAR::MDB2 connection object.
     *
     * @var    object
     * @access private
     */
    var $dbc = null;

    /**
     * Table prefix
     * Prefix for all db tables the container has.
     *
     * @var    string
     * @access public
     */
    var $prefix = 'liveuser_';

    /**
     *
     * @access public
     * @var    array
     */
    var $tables = array();

    /**
     *
     * @access public
     * @var    array
     */
    var $fields = array();

    /**
     *
     * @access public
     * @var    array
     */
    var $alias = array();

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
        parent::init($storageConf);

        if (empty($this->tables)) {
            $this->tables = $GLOBALS['_LiveUser']['perm']['tables'];
        } else {
            $this->tables = LiveUser::arrayMergeClobber($GLOBALS['_LiveUser']['perm']['tables'], $this->tables);
        }
        if (empty($this->fields)) {
            $this->fields = $GLOBALS['_LiveUser']['perm']['fields'];
        } else {
            $this->fields = LiveUser::arrayMergeClobber($GLOBALS['_LiveUser']['perm']['fields'], $this->fields);
        }
        if (empty($this->alias)) {
            $this->alias = $GLOBALS['_LiveUser']['perm']['alias'];
        } else {
            $this->alias = LiveUser::arrayMergeClobber($GLOBALS['_LiveUser']['perm']['alias'], $this->alias);
        }
    }
}
?>