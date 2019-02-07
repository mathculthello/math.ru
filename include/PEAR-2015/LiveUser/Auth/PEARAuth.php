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
 * @version CVS: $Id: PEARAuth.php,v 1.10 2005/02/21 23:11:52 dufuz Exp $
 * @link http://pear.php.net/LiveUser
 */

/**
 * Require parent class definition and PEAR::Auth class.
 */
require_once 'LiveUser/Auth/Common.php';
require_once 'Auth/Auth.php';

/**
 * PEAR_Auth container for Authentication
 *
 * ==================== !!! WARNING !!! ========================================
 *
 *      THIS CONTAINER IS UNDER HEAVY DEVELOPMENT. IT'S STILL IN EXPERIMENTAL
 *      STAGE. USE IT AT YOUR OWN RISK.
 *
 * =============================================================================
 * This is a PEAR::Auth backend driver for the LiveUser class.
 * The general options to setup the PEAR::Auth class can be passed to the constructor.
 * To choose the right auth container, you have to add the 'pearAuthContainer' var to
 * the options array.
 *
 * Requirements:
 * - File "LiveUser.php" (contains the parent class "LiveUser")
 * - PEAR::Auth must be installed in your PEAR directory
 * - Array of setup options must be passed to the constructor.
 *
 * @category authentication
 * @package  LiveUser
 * @author  Bjoern Kraus <krausbn@php.net>
 * @copyright 2002-2005 Markus Wolff
 * @license http://www.gnu.org/licenses/lgpl.txt
 * @version Release: @package_version@
 * @link http://pear.php.net/LiveUser
 */
class LiveUser_Auth_PEARAuth extends LiveUser_Auth_Common
{
    /**
     * Contains the PEAR::Auth object.
     *
     * @var    Auth
     * @access private
     */
    var $pearAuth = null;

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

        require_once 'Auth.php';
        if (!is_object($this->pearAuth)) {
            $this->pearAuth = &new Auth(
                $conf['pearAuthContainer'],
                $conf['pearAuthOptions'],
                '',
                false
            );
            if (PEAR::isError($this->pearAuth)) {
                $this->_stack->push(LIVEUSER_ERROR_INIT_ERROR, 'error',
                    array('container' => 'could not connect: '.$this->pearAuth->getMessage()));
                return false;
            }
        }
        return true;
    }

    /**
     * Starts and verifies the PEAR::Auth login process
     *
     * @return boolean  true upon success or false on failure
     *
     * @access private
     */
    function _readUserData()
    {
        $this->pearAuth->start();
        $this->pearAuth->login();

        $success = false;

        // If a user was found, read data into class variables and set
        // return value to true
        if ($this->pearAuth->getAuth()) {
            $this->handle       = $this->pearAuth->getUsername();
            $this->passwd       = $this->encryptPW($this->pearAuth->password);
            $this->isActive     = true;
            $this->authUserId   = $this->pearAuth->getUsername();
            $this->lastLogin    = '';

            $success = true;
        }
        return $success;
    }

}
?>