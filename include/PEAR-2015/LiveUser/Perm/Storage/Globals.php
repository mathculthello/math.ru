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
 * @version CVS: $Id: Globals.php,v 1.7 2005/03/11 11:07:35 lsmith Exp $
 * @link http://pear.php.net/LiveUser
 */


/**
 * This file holds all our default table/fields name/types/relations,
 * if they should be checked and more which are needed by both 
 * LiveUser and LiveUser_Admin
 *
 * You can add to those table or modify options via our table/field
 * options in the config.
 */

$GLOBALS['_LiveUser']['perm']['tables'] = array(
    'perm_users' => array(
        'fields' => array(
            'perm_user_id' => 'seq',
            'auth_user_id' => true,
            'auth_container_name' => true,
            'perm_type' => false,
         ),
        'joins' => array(
            'userrights' => 'perm_user_id',
            'groupusers' => 'perm_user_id',
            'area_admin_areas' => 'perm_user_id',
        ),
        'ids' => array(
            'perm_user_id'
        ),
    ),
    'userrights' => array(
        'fields' => array(
            'perm_user_id' => true,
            'right_id' => true,
            'right_level' => false,
        ),
        'joins' => array(
            'perm_users' => 'perm_user_id',
            'rights' => 'right_id',
        ),
    ),
    'rights' => array(
        'fields' => array(
            'right_id' => 'seq',
            'area_id' => false,
            'right_define_name' => false,
            'has_implied' => false,
        ),
        'joins' => array(
            'areas' => 'area_id',
            'userrights' => 'right_id',
            'grouprights' => 'right_id',
            'right_implied' => array(
                'right_id' => 'right_id',
                'right_id' => 'implied_right_id',
            ),
            'translations' => array(
                'right_id' => 'section_id',
                LIVEUSER_SECTION_RIGHT => 'section_type',
            ),
        ),
        'ids' => array(
            'right_id'
        ),
    ),
    'right_implied' => array(
        'fields' => array(
            'right_id' => true,
            'implied_right_id' => true,
        ),
        'joins' => array(
            'rights' => array(
                'right_id' => 'right_id',
                'implied_right_id' => 'right_id',
            ),
        ),
    ),
    'translations' => array(
        'fields' => array(
            'translation_id' => 'seq',
            'section_id' => true,
            'section_type' => true,
            'language_id' => true,
            'name' => false,
            'description' => false,
        ),
        'joins' => array(
            'rights' => array(
                'section_id' => 'right_id',
                'section_type' => LIVEUSER_SECTION_RIGHT,
            ),
            'areas' => array(
                'section_id' => 'area_id',
                'section_type' => LIVEUSER_SECTION_AREA,
            ),
            'applications' => array(
                 'section_id' => 'application_id',
                 'section_type' => LIVEUSER_SECTION_APPLICATION,
            ),
            'groups' => array(
                'section_id' => 'group_id',
                'section_type' => LIVEUSER_SECTION_GROUP,
            ),
        ),
        'ids' => array(
            'translation_id',
            'section_id',
            'section_type',
            'language_id',
        ),
    ),
    'areas' => array(
        'fields' => array(
            'area_id' => 'seq',
            'application_id' => false,
            'area_define_name' => false,
        ),
        'joins' => array(
            'rights' => 'area_id',
            'applications' => 'application_id',
            'translations' => array(
                'area_id' => 'section_id',
                LIVEUSER_SECTION_AREA => 'section_type',
            ),
            'area_admin_areas' => 'area_id',
        ),
        'ids' => array(
            'area_id',
        ),
    ),
    'area_admin_areas' => array(
        'fields' => array(
            'area_id' => true,
            'perm_user_id' => true,
        ),
        'joins' => array(
            'perm_users' => 'perm_user_id',
            'areas' => 'area_id',
        )
    ),
    'applications' => array(
        'fields' => array(
            'application_id' => 'seq',
            'application_define_name' => false,
        ),
        'joins' => array(
            'areas' => 'application_id',
            'translations' => array(
                'application_id' => 'section_id',
                LIVEUSER_SECTION_APPLICATION => 'section_type',
            ),
        ),
        'ids' => array(
            'application_id',
        ),
    ),
    'groups' => array(
        'fields' => array(
            'group_id' => 'seq',
            'group_type' => false,
            'group_define_name' => false,
            'is_active' => false,
            'owner_user_id' => false,
            'owner_group_id' => false,
        ),
        'joins' => array(
            'groupusers' => 'group_id',
            'grouprights' => 'group_id',
            'group_subgroups' => 'group_id',
            'translations' => array(
                'group_id' => 'section_id',
                LIVEUSER_SECTION_GROUP => 'section_type',
            ),
        ),
        'ids' => array(
            'group_id',
        ),
    ),
    'groupusers' => array(
        'fields' => array(
            'perm_user_id' => true,
            'group_id' => true,
        ),
        'joins' => array(
            'groups' => 'group_id',
            'perm_users' => 'perm_user_id',
        ),
    ),
    'grouprights' => array(
        'fields' => array(
            'group_id' => true,
            'right_id' => true,
            'right_level' => false,
        ),
        'joins' => array(
            'rights' => 'right_id',
            'groups' => 'group_id',
        ),
    ),
    'group_subgroups' => array(
        'fields' => array(
            'group_id' => true,
            'subgroup_id' => true,
        ),
        'joins' => array(
            'groups' => 'group_id',
        ),
    ),
);

$GLOBALS['_LiveUser']['perm']['fields'] = array(
    'perm_user_id' => 'integer',
    'auth_user_id' => 'text',
    'auth_container_name' => 'text',
    'perm_type' => 'integer',
    'right_id' => 'integer',
    'right_level' => 'integer',
    'area_id' => 'integer',
    'application_id' => 'integer',
    'right_define_name' => 'text',
    'area_define_name' => 'text',
    'application_define_name' => 'text',
    'translation_id' => 'integer',
    'section_id' => 'integer',
    'section_type' => 'integer',
    'name' => 'text',
    'description' => 'text',
    'language_id' => 'text',
    'group_id' => 'integer',
    'group_type' => 'integer',
    'group_define_name' => 'text',
    'is_active' => 'boolean',
    'owner_user_id' => 'integer',
    'owner_group_id' => 'integer',
    'has_implied' => 'boolean',
    'implied_right_id' => 'integer',
    'subgroup_id' => 'integer'
);

$GLOBALS['_LiveUser']['perm']['alias'] = array(
    'perm_user_id' => 'perm_user_id',
    'auth_user_id' => 'auth_user_id',
    'auth_container_name' => 'auth_container_name',
    'perm_type' => 'perm_type',
    'right_id' => 'right_id',
    'right_level' => 'right_level',
    'area_id' => 'area_id',
    'application_id' => 'application_id',
    'right_define_name' => 'right_define_name',
    'area_define_name' => 'area_define_name',
    'application_define_name' => 'application_define_name',
    'translation_id' => 'translation_id',
    'section_id' => 'section_id',
    'section_type' => 'section_type',
    'name' => 'name',
    'description' => 'description',
    'language_id' => 'language_id',
    'group_id' => 'group_id',
    'group_type' => 'group_type',
    'group_define_name' => 'group_define_name',
    'is_active' => 'is_active',
    'owner_user_id' => 'owner_user_id',
    'owner_group_id' => 'owner_group_id',
    'has_implied' => 'has_implied',
    'implied_right_id' => 'implied_right_id',
    'subgroup_id' => 'subgroup_id',
);

?>