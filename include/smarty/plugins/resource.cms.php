<?php
/*
 * Created on 02.05.2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

function smarty_resource_cms_source (string $rsrc_name, string &$source, object &$smarty) 
{
    $path = $_SERVER['REQUEST_URI'];
    $path = rtrim($path, '/');
    while ($path != '')
    {
        if (file_exists($path.'/'.$rsrc_name) && is_readable($path.'/'.$rsrc_name))
        {
            $source = file_get_contents($path.'/'.$rsrc_name);
            return true;
        }
        $pos = strrpos($path, '/');
        if ($pos !== false)
        {
            $path = substr($path, 0, $pos);
        }
    }
    return false;
}

function smarty_resource_cms_timestamp (string $rsrc_name, int &$timestamp, object &$smarty)
{
    return false;
}

function smarty_resource_cms_secure (string $rsrc_name, object &$smarty)
{
    return true;
}

function smarty_resource_cms_trusted (string $rsrc_name, object &$smarty)
{
    
}
?>
