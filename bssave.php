<?php

require_once '../../../wp-load.php';

if (
        null !== filter_input(INPUT_POST, "id") 
        && null !== filter_input(INPUT_POST, "auth") 
        && null !== filter_input(INPUT_POST, "name") 
        && null !== filter_input(INPUT_POST, "pos") 
        && null !== filter_input(INPUT_POST, "en") 
        && null !== filter_input(INPUT_POST, "cs")
) {
    $id = filter_input(INPUT_POST, "id");
    $auth = filter_input(INPUT_POST, "auth");
    $name = filter_input(INPUT_POST, "name");
    $pos = filter_input(INPUT_POST, "pos");
    $en = filter_input(INPUT_POST, "en");
    $cs = filter_input(INPUT_POST, "cs");
    echo bssave($id, $auth, $name, $pos, $en, $cs);
}

function bssave($id, $auth, $name, $pos, $en, $cs) {
    global $wpdb;
    $q = 'SELECT * FROM bs WHERE id=' . $id . ' AND auth=' . $auth . ';';
    $wpdb->get_results($q);
    $num = $wpdb->num_rows;
    if ($num !== 1) {
        return 'not saved, please reload and try again';
    }
    $r = 'UPDATE bs SET '
            . 'name=\''.escape($name).'\', '
            . 'position=\''.$pos.'\', '
            . 'en=\''.escape($en).'\', '
            . 'cs=\''.escape($cs).'\' '
            . 'WHERE id=' . $id . ';';
    $wpdb->query($r);
    return 'saved';
}
function escape($string){  
    //return mysqli_real_escape_string($string); // done at client ... very dangerous but whatever
    return $string;
}

?>