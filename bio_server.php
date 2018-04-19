<?php 
    require_once '../../../wp-load.php';

    if(isset($_POST['position']) && !empty($_POST['position'])) {
        $position = $_POST['position'];
        $lang = $_POST['lang'];
        echo(getBio($position, $lang));
    }
    
    function getBio($position, $lang) {
                $xposition = preg_replace("/[^a-zA-Z]/", "", $position );
                $biotext="Description not yet available";
        global $wpdb;
        $query = 'SELECT '.$lang.' FROM `bs` WHERE (position=\''.$xposition.'\') ORDER BY id ASC';
        $res = $wpdb->get_results($query);
                
        if($xposition==='president' || $xposition==='vicepresident' || $xposition==='treasurer'){
                        $biotext = $res[0]->$lang; 
                }else{           
            $seq = intval(preg_replace("/[^0-9]/", "", $position ));
                        
                        $biotext = $res[$seq-1]->$lang . ' ';
                        
                } 
            
        if(strlen($biotext) > 1){
          return $biotext;
        }
        return 'Description not yet available';
    }
    
    

?>