<?php
require_once '../set_env.inc.php';
require_once 'tex.inc.php';
//$_ADODB->debug = true;

echo "<pre>";

$wordings = $_ADODB->GetAll("SELECT w.*,t.title FROM dic_wording w, dic_term t WHERE t.id=w.term order by title");
foreach ($wordings as $w) {
    echo $w['title'] . "\n";
    if (strpos($w['wording'], '$') !== FALSE) {
        $ret = process_tex($w['wording'], $_SERVER['DOCUMENT_ROOT']."/dic/img/w".$w['id']."w_");
        if ($ret) {
            printf("%10s...error\n", 'wording');
        } else {
            printf("%10s...ok\n", 'wording');
        }
    }
    if (strpos($w['comment'], '$') !== FALSE) {
        $ret = process_tex($w['comment'], $_SERVER['DOCUMENT_ROOT']."/dic/img/w".$w['id']."c_");
        if ($ret) {
            printf("%10s...error\n", 'comment');
        } else {
            printf("%10s...ok\n", 'comment');
        }
    }

    ob_flush();
    flush();
}

$comp = $_ADODB->GetAll("SELECT w.*,t.title FROM dic_comp w, dic_term t WHERE t.id=w.term order by title");
foreach ($comp as $w) {
    echo $w['title'] . "\n";
    if (strpos($w['comp'], '$') !== FALSE) {
        $ret = process_tex($w['comp'], $_SERVER['DOCUMENT_ROOT']."/dic/img/c".$w['id']."_");
        if ($ret) {
            printf("%10s...error\n", 'comp');
        } else {
            printf("%10s...ok\n", 'comp');
        }
    }
    ob_flush();
    flush();
}

$formula = $_ADODB->GetAll("SELECT * FROM dic_formula");
foreach ($formula as $w) {
    echo $w['title'] . "\n";
    if (strpos($w['comp'], '$') !== FALSE) {
        $ret = process_tex($w['formula'], $_SERVER['DOCUMENT_ROOT']."/dic/img/formula".$w['id']."_");
        if ($ret) {
            printf("%10s...error\n", 'formula');
        } else {
            printf("%10s...ok\n", 'formula');
        }
    }
    ob_flush();
    flush();
}

echo "</pre>";
?>
