<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_function_count_array($params, &$smarty)
{
    if (isset($params['array'])) {
        return count($params['array']);
    }

    return 0;
    
}

/* vim: set expandtab: */

?>
