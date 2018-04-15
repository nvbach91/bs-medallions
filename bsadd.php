<?php

require_once '../../../wp-load.php';
global $wpdb;



if (null !== filter_input(INPUT_POST, "auth") && null !== filter_input(INPUT_POST, "name") && null !== filter_input(INPUT_POST, "pos")) {
    $name = filter_input(INPUT_POST, "name");
    $auth = filter_input(INPUT_POST, "auth");
    $pos = filter_input(INPUT_POST, "pos");
    echo bsadd($auth, $name, $pos);
}

function bsadd($auth, $name, $pos) {
    global $wpdb;

    $qx = 'SELECT * FROM bs WHERE position=\'' . $pos . '\';';
    $wpdb->query($qx);
    $numx = $wpdb->num_rows;
    if ($pos !== 'president' && $pos !== 'vicepresident' && $pos !== 'treasurer') {
        if ($numx > 98) {
            return 'not added! max 99 members per process, sorry';
        }
    } else {
        if ($numx > 0) {
            return 'not added! max 1 member per leader position!';
        }
    }
    $q = 'SELECT * FROM bs WHERE auth=' . $auth . ' LIMIT 1;';
    $wpdb->query($q);
    $num = $wpdb->num_rows;
    if ($num !== 1) {
        return 'not added';
    }
    $r = 'INSERT INTO bs (name,position) VALUES (\'' . $name . '\',\'' . $pos . '\');';
    $wpdb->query($r);
    return 'added';
}

?>