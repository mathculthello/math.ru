<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_function_life_date_format($params, &$smarty)
{
    $ret_string = $birth = $death = '';

    if (isset($params['birth']) && !empty($params['birth'])) {
        list($y, $m, $d) = explode('-', $params['birth']);
        if ($y != '0000') {
        	$y = ltrim($y, '0');
            if ($m != '00' && $d != '00') {
                $birth = $d.'.'.$m.'.'.$y;
            } else {
                $birth = $y;
            }
        }
    }

    if (isset($params['death']) && !empty($params['death'])) {
        list($y, $m, $d) = explode('-', $params['death']);
        if ($y != '0000') {
        	$y = ltrim($y, '0');
            if ($m != '00' && $d != '00') {
                $death = $d.'.'.$m.'.'.$y;
            } else {
                $death = $y;
            }
        }
    }

    if ($birth && $death) {
        $ret_string = $birth.'&nbsp;-&nbsp;'.$death;
    } elseif ($birth) {
        if (strlen($birth) == 4)
            $ret_string = $birth.'&nbsp;г.р.';
        else
            $ret_string = 'род.&nbsp;'.$birth;
    } elseif ($death) {
        $ret_string = '-&nbsp;'.$death;
    }

    if ($params['brackets'] == 'p' && $ret_string) {
        return '('.$ret_string.')';
    }
    return $ret_string;
}

/* vim: set expandtab: */

?>
