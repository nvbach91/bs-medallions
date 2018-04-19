<?php 
/**
* Plugin Name: BS Medallions
* Plugin URI: 
* Description: This plugin allows adding shortcode to Buddy System about us page
* Author: Nguyen Viet Bach
* Author URI:
* Version: 1.1
*/
add_action('admin_menu', 'bsm_admin_actions');
function bsm_admin_actions() {
    add_options_page('BS Medallions','BS Medallions','manage_options', __FILE__,'bsm_admin');
}

function bsm_admin() {
    global $wpdb;
    $u = 'UPDATE bs SET auth='.rand(1,9999);
    $wpdb->query($u);
    $q = 'SELECT * FROM bs ORDER BY CASE '
                . 'WHEN position=\'president\' THEN \'1\' '
                . 'WHEN position=\'vicepresident\' THEN \'2\' '
                . 'WHEN position=\'treasurer\' THEN \'3\' '
                . 'WHEN position=\'ac\' THEN \'4\' '
                . 'WHEN position=\'bp\' THEN \'5\' '
                . 'WHEN position=\'ex\' THEN \'6\' '
                . 'WHEN position=\'fr\' THEN \'7\' '
                . 'WHEN position=\'hr\' THEN \'8\' '
                . 'WHEN position=\'it\' THEN \'9\' '
                . 'WHEN position=\'ir\' THEN \'a\' '
                . 'WHEN position=\'n2n\' THEN \'b\' '
                . 'WHEN position=\'ad\' THEN \'c\' '
                . 'WHEN position=\'pr\' THEN \'d\' '
                . 'WHEN position=\'lr\' THEN \'e\' '
                . 'END ASC, id ASC;';
    $res = $wpdb->get_results($q);
?>
<link href="/<?php echo explode("/", $_SERVER['REQUEST_URI'])[1]; ?>/wp-content/plugins/bs-medallions/admin.css" rel="stylesheet" type="text/css" media="all">
<div class="wrap">
  <div id="bsshow"></div>
  <div class="intro">
    <div id="mtitle">Buddy System Medallions</div>
    <p>Hey fellas! Here you can manage the BS members' medallions.</p>
    <p>Delete them, change their bio text, change their pictures, add a new member... Have fun!</p>
    <p>Note: To change the member's picture, the picture must be squared, then, just drag and drop the <strong><em>.png</em></strong> or <strong><em>.jpg (.jpeg)</em></strong> file from your desktop to the dotted box and that's it!</p>
    <hr/>
    <input id="bsrefresh" type="button" value="Magic Button" title="Fixes everything!" class="button-secondary" onclick="window.location.reload(true);"/>
    <hr/>
    <input id="bsreload" type="button" value="Reload Members" class="button-primary"/>
    <input type="button" value="Collapse All" class="button-primary" onclick="expcolall(this)"/>
  </div>  
  <div>
<?php
$lastpos = '';
$cnt = 1;
foreach ($res as $r) {
    if($lastpos!==$r->position){
        $lastpos=$r->position;
        $cnt=1;
        echo '<br/><div class="enc" id="'.$lastpos.'">'.getFullProcessName($lastpos).'</div><br/>';
    }
    
    $checked='';
    if($r->is_leader==='1'){$checked='checked';}


    $notChangeableIfLeader;
    
    if($r->position==='president'||$r->position==='vicepresident'||$r->position==='treasurer'){
        $notChangeableIfLeader = ' title="You cannot move a leader position!"';
    }
    
    echo '
        <div class="bsrow '.$lastpos.'">
            <div class="bsid">'.$r->id.'</div>
            <div class="bsauth">'.$r->auth.'</div>
            <div class="bsname"><input type="text" value="'.$r->name.'" /></div>
            <div class="bspos"'.$notChangeableIfLeader.'>'.getPosOptions($r->position).'</div>
            <div class="bspic"><input readonly type="text" value="'.$r->position.$cnt.'" /></div>
            <div class="bsen"><textarea title="English" rows="3">'.replaceQuotes($r->en).'</textarea></div>
            <div class="bscs"><textarea title="Czech" rows="3">'.replaceQuotes($r->cs).'</textarea></div>
            <div class="bsbtn"><input type="button" value="Save" class="button-primary save"/></div>';
    
    if($lastpos!=='president'&&$lastpos!=='vicepresident'&&$lastpos!=='treasurer'){
        echo '<div class="bsbtn"><input type="button" value="Remove" class="button-primary remove"/></div>';
    }
    
    echo '</div>';
    $cnt++;
}
?>
    <hr style="margin:50px 0 0 0;">
    <p style="font-size:20px;">Add a new Member</p>
    <div class="" style="margin: 0 0 50px 0;">
      <div class="bsname"><input type="text" placeholder="Type a name and choose process" size="30"/></div>
      <div class="bspos"><?php echo getPosOptions('ad');?></div>
      <div class="bsbtn"><input id="bsadd" type="button" value="Add" class="button-primary"/></div>
    </div>
  </div>
  <div class="nvbx"><em>Brought to you by <a href="github.com/nvbach91">github.com/nvbach91</a></em></div>
  <script src="/<?php echo explode("/", $_SERVER['REQUEST_URI'])[1]; ?>/wp-content/plugins/bs-medallions/bsremove.js"></script>
  <script src="/<?php echo explode("/", $_SERVER['REQUEST_URI'])[1]; ?>/wp-content/plugins/bs-medallions/bsadd.js"></script>
  <script src="/<?php echo explode("/", $_SERVER['REQUEST_URI'])[1]; ?>/wp-content/plugins/bs-medallions/bssave.js"></script>
  <script src="/<?php echo explode("/", $_SERVER['REQUEST_URI'])[1]; ?>/wp-content/plugins/bs-medallions/bsreload.js"></script>
  <script src="/<?php echo explode("/", $_SERVER['REQUEST_URI'])[1]; ?>/wp-content/plugins/bs-medallions/bssearch.js"></script>
  <script src="/<?php echo explode("/", $_SERVER['REQUEST_URI'])[1]; ?>/wp-content/plugins/bs-medallions/bsupload.js"></script>
  <script src="/<?php echo explode("/", $_SERVER['REQUEST_URI'])[1]; ?>/wp-content/plugins/bs-medallions/bsexpandncollapse.js"></script>
  <script src="/<?php echo explode("/", $_SERVER['REQUEST_URI'])[1]; ?>/wp-content/plugins/bs-medallions/navmouseshow.js"></script>
</div>
<?php
}
function getFullProcessName($pos){
    switch($pos){
    case "president":     return "President";break;
    case "vicepresident": return "Vice President";break;
    case "treasurer":     return "Treasurer";break;
    case "ac":            return "Activities";break;
    case "bp":            return "Buddy Program";break;
    case "ex":            return "Exchange+";break;
    case "fr":            return "Fundraising";break;
    case "hr":            return "Human Resources";break;
    case "it":            return "Information Technology";break;
    case "ir":            return "International Relations";break;
    case "n2n":           return "Nation 2 Nation";break;
    case "ad":            return "Administraion";break;
    case "pr":            return "Public Relations";break;
    case "lr":            return "Local Representative";break;
    }
    
    return "Unknown";
}
function replaceQuotes($string){
    return str_replace('"', '&quot;', $string);
}
function select($k){
    $st = substr($k,0,8);
    $mi = 'selected ';
    $la = substr($k,strlen($st),strlen($k)-strlen($st));
    return $st.$mi.$la;
}

function getPosOptions($pos){
    $a = array(
        '<option disabled value="president">President</option>',
        '<option disabled value="vicepresident">Vice President</option checked>',
        '<option disabled value="treasurer">Treasurer</option>',  
        '<option value="ad">Administration</option>', 
        '<option value="bp">Buddy Program</option>',
        '<option value="fr">Fundraising</option>',
        '<option value="pr">Public Relations</option>',
        '<option value="hr">Human Resources</option>',
        '<option value="it">Information Technology</option>',
        '<option value="ir">International Relations</option>',
        '<option value="ac">Activities</option>',
        '<option value="ex">Exchange+</option>',
        '<option value="n2n">Nation 2 Nation</option>',
        '<option value="lr">Local Representative</option>'
    );

    switch($pos){
        case "president":     $a[0] = select($a[0]) ;break;
        case "vicepresident": $a[1] = select($a[1]) ;break;
        case "treasurer":     $a[2] = select($a[2]) ;break;
        case "ad":            $a[3] = select($a[3]) ;break;
        case "bp":            $a[4] = select($a[4]) ;break;
        case "fr":            $a[5] = select($a[5]) ;break;
        case "pr":            $a[6] = select($a[6]) ;break;
        case "hr":            $a[7] = select($a[7]) ;break;
        case "it":            $a[8] = select($a[8]) ;break;
        case "ir":            $a[9] = select($a[9]) ;break;
        case "ac":            $a[10]= select($a[10]);break;
        case "ex":            $a[11]= select($a[11]);break;
        case "n2n":           $a[12]= select($a[12]);break;
        case "lr":            $a[13]= select($a[13]);break;
    }
    $result = '<select>';
        if($pos==="president"||$pos==="vicepresident"||$pos==="treasurer"){
            $result = '<select disabled>';
        }
        foreach ($a as $k) {
            $result .= $k;
        }
        $result.='</select>';
    return $result;
}

add_shortcode('bs_medallions', 'add_medallions_codes');

function add_medallions_codes_cs() {
    return add_medallions_codes(true);
}

function add_medallions_codes($atts) {

    $a = shortcode_atts( 
        array('lang' => 'en'), $atts //'en' is the default value if not defined like this: [shortcode lang="cs"]
    );
    
    $isCS=false;
    if($a['lang']==='cs') {
        $isCS=true;
    }
    
    $displayProcesses = getDisplayProcesses($isCS);
    
    $navigator = getNavigator();
    return 
    '<div class="bp-wrapper">' . 
        $navigator .
        '<div id="bp-content">' . 
            $displayProcesses . 
        '</div>' .
    '</div>' .
    '<script src="/'.explode("/", $_SERVER['REQUEST_URI'])[1].'/wp-content/plugins/bs-medallions/interactions.js"></script>';
}
$processes = array(
    0  => array( 'bpname'=>'President',              'pr'=>'president' ),
    1  => array( 'bpname'=>'Vicepresident',          'pr'=>'vicepresident' ),
    2  => array( 'bpname'=>'Treasurer',              'pr'=>'treasurer' ),
    3  => array( 'bpname'=>'Activities',             'pr'=>'ac' ),
    4  => array( 'bpname'=>'Buddy Program',          'pr'=>'bp' ),
    5  => array( 'bpname'=>'Exchange+',              'pr'=>'ex' ),
    6  => array( 'bpname'=>'Fundraising',            'pr'=>'fr' ),
    7  => array( 'bpname'=>'Human Resources',        'pr'=>'hr' ),
    8  => array( 'bpname'=>'Information Technology', 'pr'=>'it' ),
    9  => array( 'bpname'=>'International Relations','pr'=>'ir' ),
    10 => array( 'bpname'=>'Nation 2 Nation',        'pr'=>'n2n'),
    11 => array( 'bpname'=>'Administration',         'pr'=>'ad' ),
    12 => array( 'bpname'=>'Public Relations',       'pr'=>'pr' ),
    13 => array( 'bpname'=>'Local Representative',   'pr'=>'lr' )
);

function getLeaderName($pos){
    global $wpdb;
    $q = 'SELECT DISTINCT position, name FROM bs WHERE position=\''.$pos.'\'';
    $res = $wpdb->get_results($q);
    
    return $res[0]->name;
}

function getMemberNames($pos){
    global $wpdb;
    $q = 'SELECT position, name FROM bs WHERE position=\''.$pos.'\'';
    $res = $wpdb->get_results($q);
    return $res;
}
function getNavigator() {
    global $processes;
    $dom = 
    '<div id="bp-navigator">';
    $processesLength = count($processes);
    for ($i = 0; $i < $processesLength; $i++){
        $active = $i == 0 ? ' active' : '';
        $p = $processes[$i];
        $dom = $dom.
        '<div class="bp-nav-item'.$active.'" pr="'.$p['pr'].'">'.$p['bpname'].'</div>';
    }

    return $dom.
    '</div>';
}


function getDisplayProcesses($isCS){
    global $processes;
    $bpname = 'notdef';
    $pr = 'notdef';
    $p = '';
    for ($i = 0; $i < 17; $i++){
        $process = $processes[$i];
        $bpname = $process['bpname'];
        $pr = $process['pr'];
        $isDisplayed = $i == 0 ? ' active' : '';
        $p = $p.
        '<div class="bprocess '.$isDisplayed.'" pr="'.$pr.'">
          <div class="bpname">'.$bpname.'</div>
          <div class="bpmembers">';
          
        $names = getMemberNames($pr);
        $k = 1;
        foreach($names as $n){
            $p = $p. 
            '<div class="bpmember">
              <div class="bpimg">' .
                '<img src="/'.explode("/", $_SERVER['REQUEST_URI'])[1].'/members/'.$pr.$k.'.png" alt="'.$pr.$k.'" />'.
              '</div>
              <div class="membercap">'.$n->name.'</div>
            </div>';
            $k++;
        }
        $p = $p.
        '</div>
          <div class="bpbio '.$pr.'"></div>
        </div>';
    }
    $p = $p. '</div>';
    return $p;
}

?>
