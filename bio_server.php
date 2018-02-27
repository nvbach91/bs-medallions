<?php 
	require_once '../../../wp-load.php';

    if(isset($_POST['position']) && !empty($_POST['position'])) {
        $position = $_POST['position'];
		$lang = $_POST['lang'];
		echo(getBio($position, $lang));
    }
	
	function getBio($position, $lang) {
                $xposition = substr($position, 0, strlen($position)-1);
                $biotext="Not available yet";
		global $wpdb;
		$query = 'SELECT '.$lang.' FROM `bs` WHERE (position=\''.$xposition.'\') ORDER BY id ASC';
		$res = $wpdb->get_results($query);
                
		if($xposition==='president' || $xposition==='vicepresident' || $xposition==='treasurer'){
                        $biotext = $res[0]->$lang; 
                }else{           
			$seq = intval(substr($position,strlen($position)-1,1));
                        
                        $biotext = $res[$seq-1]->$lang . ' ';
                        
                }
        	
		if(strlen($biotext) > 1){
		  return $biotext;
		}
		return 'Not available yet';
	}
	
	

?>