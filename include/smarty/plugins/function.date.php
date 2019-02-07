<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.date.php
 * Type:     function
 * Name:     date
 * Purpose:  outputs  date
 * -------------------------------------------------------------
 */
function smarty_function_date($params, &$smarty)
{
    return date($params['format']);
}
?>
