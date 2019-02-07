<?php
require_once '../set_env.inc.php';
require_once INCLUDE_DIR.'/dbtree/xdbtree.php';
$_ADODB->debug = true;

$DBTREE = new XDBTree($_ADODB, "dic_rubr", "id", array("left" => "lft", "right" => "rgt", "level" => "level", "parent" => "pid"));

function level($str) {
    return substr_count(rtrim($str), "\t");
}

$strings = file('rubr.txt'); 
$parents = array();
$level = 0;
for ($i = 0; $i < count($strings); $i++) {
    if (level($strings[$i]) > 0)
        $id = $DBTREE->insert($parents[count($parents) - 1], array('name' => trim($strings[$i])));
    else
        $id = 1;
    if ($i < count($strings) - 1) {
        if (level($strings[$i+1]) > $level) {
            array_push($parents, $id);
            $level++;
        } elseif (level($strings[$i+1]) < $level) {
            while (level($strings[$i+1]) < $level) {
                array_pop($parents);
                $level--;
            }
        }
    }
}

?>
