<?php
require_once '../set_env.inc.php';
require_once 'tex.inc.php';

$terms = $_ADODB->GetAll("SELECT t.*,tt.* FROM dic_term t LEFT JOIN dic_term_text tt ON tt.term=t.id order by title");

echo "<pre>";

foreach ($terms as $term) {
    echo $term['title'] . "\n";
    if (strpos($term['title'], '$') !== FALSE) {
        $ret = process_tex($term['title'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$term['id']."t_");
        if ($ret) {
            printf("%10s...error\n", 'title');
        } else {
            printf("%10s...ok\n", 'title');
        }
    }
    if (strpos($term['entry'], '$') !== FALSE) {
        $ret = process_tex($term['entry'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$term['id']."e_");
        if ($ret) {
            printf("%10s...error\n", 'entry');
        } else {
            printf("%10s...ok\n", 'entry');
        }
    }
    if (strpos($term['formula'], '$') !== FALSE) {
        $ret = process_tex($term['formula'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$term['id']."f_");
        if ($ret) {
            printf("%10s...error\n", 'formula');
        } else {
            printf("%10s...ok\n", 'formula');
        }
    }
    if (strpos($term['illustration'], '$') !== FALSE) {
        $ret = process_tex($term['illustration'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$term['id']."i_");
        if ($ret) {
            printf("%10s...error\n", 'illustration');
        } else {
            printf("%10s...ok\n", 'illustration');
        }
    }
    if (strpos($term['comment'], '$') !== FALSE) {
        $ret = process_tex($term['comment'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$term['id']."c_");
        if ($ret) {
            printf("%10s...error\n", 'comment');
        } else {
            printf("%10s...ok\n", 'comment');
        }
    }
    if (strpos($term['history'], '$') !== FALSE) {
        $ret = process_tex($term['history'], $_SERVER['DOCUMENT_ROOT']."/dic/img/".$term['id']."h_");
        if ($ret) {
            printf("%10s...error\n", 'history');
        } else {
            printf("%10s...ok\n", 'history');
        }
    }
    ob_flush();
    flush();
}

echo "</pre>";
?>
