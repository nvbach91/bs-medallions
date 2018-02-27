<?php

require_once '../../../wp-load.php';

if (
        null !== filter_input(INPUT_POST, "id") 
        && null !== filter_input(INPUT_POST, "auth") 
        && null !== filter_input(INPUT_POST, "name") 
        && null !== filter_input(INPUT_POST, "pos") 
        && null !== filter_input(INPUT_POST, "en") 
        && null !== filter_input(INPUT_POST, "cs")
        && null !== filter_input(INPUT_POST, "pic")
        && null !== filter_input(INPUT_POST, "nm")
) {
    $id = filter_input(INPUT_POST, "id");
    $auth = filter_input(INPUT_POST, "auth");
    $name = filter_input(INPUT_POST, "name");
    $pos = filter_input(INPUT_POST, "pos");
    $en = filter_input(INPUT_POST, "en");
    $cs = filter_input(INPUT_POST, "cs");
    $pic = filter_input(INPUT_POST, "pic");
    $nm = filter_input(INPUT_POST, "nm");
    echo bschange($id, $auth, $name, $pos, $en, $cs, $pic, $nm);
}

function bschange($id, $auth, $name, $pos, $en, $cs, $pic, $nm) {
    global $wpdb;
    $q = 'SELECT * FROM bs WHERE id=' . $id . ' AND auth=' . $auth . ';';
    $wpdb->get_results($q);
    $num = $wpdb->num_rows;
    if ($num !== 1) {
        return 'not saved';
    }
    $d = 'DELETE FROM bs WHERE id='.$id.';';
    $wpdb->query($d);
    $r = 'INSERT INTO bs (name,position,en,cs) VALUES ('
            . '\''.escape($name).'\', '
            . '\''.$pos.'\', '
            . '\''.escape($en).'\', '
            . '\''.escape($cs).'\');';
    $wpdb->query($r);
    $dir = "../../../members/";
    $picPath = $dir . $pic;
    if(file_exists($picPath)){
        rename($picPath, $dir.$pos.($nm+1).substr($pic,strlen($pic)-4,4));
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
    return 'saved';
}
function escape($string){  
    //return mysqli_real_escape_string($string); // done at client ... very dangerous but whatever
    return $string;
}

?>