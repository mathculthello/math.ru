<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty initials modifier plugin
 *
 * Type:     modifier<br>
 * Name:     initials<br>
 * Purpose:  
 * @param string
 * @return string
 */
function smarty_modifier_initials($string, $long_names = 0, $utf = 1)
{
    if (strlen($string) > 0) {
        
        return ($long_names && strlen($string) > 1 ? $string.'&nbsp;' : ($utf ? utf8_substr($string,0,1) : substr($string, 0, 1)).'.&nbsp;');
    } else {
        return '';
    }
}

/* vim: set expandtab: */

function utf8_substr($str,$from,$len){
  return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
                       '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
                       '$1',$str);
}
?>
