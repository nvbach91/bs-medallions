<?php

require_once '../../../wp-load.php';
if (null !== filter_input(INPUT_POST, "id") && null !== filter_input(INPUT_POST, "auth") && null !== filter_input(INPUT_POST, "pic")) {
    $id = filter_input(INPUT_POST, "id");
    $auth = filter_input(INPUT_POST, "auth");
    $pic = filter_input(INPUT_POST, "pic");
    echo bsremove($id, $auth, $pic);
}

function bsremove($id, $auth, $pic) {
    global $wpdb;
    $q = 'SELECT * FROM bs WHERE id=' . $id . ' AND auth=' . $auth . ';';
    $wpdb->query($q);
    $num = $wpdb->num_rows;
    if ($num !== 1) {
        return 'not removed';
    }

    $dir = "../../../members/";
    $filepath = $dir . $pic;
    if (file_exists($filepath)) {
        if (!unlink($filepath)) {
            return 'not removed, not enough permission';
        }

        $files = scandir($dir);
        $pics = array();
        $process = substr($pic,0,strlen($pic)-5);
        foreach ($files as $file) {
            if (substr($file, strlen($file) - 4, 4) === '.png'
             && substr($file,0,strlen($file)-5)===$process) {
                array_push($pics, $file);
            }
        }
        $removed_number=intval(substr($pic,strlen($pic)-5,1));
        for($i = $removed_number-1;$i<count($pics);$i++){
            $new_number = $i+1;
            rename($dir.$pics[$i], $dir.$process.$new_number.'.png');            
        }
    }

    $r = 'DELETE FROM bs WHERE id=\'' . $id . '\';';
    $wpdb->query($r);





    return 'removed';
}

?>