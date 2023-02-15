<?php
/*
    Backend-API for Match Javascript-GET Requests.
    Takes the whole challange data and transforms it into a json blob
*/
require_once(__DIR__.'/../mysql_bridge.php');

$challange_data = getChallangeData();
$json = [];
$i = 0;
foreach ($challange_data as $challange) {
    if(isset($_GET['mode']) && $_GET['mode'] == 'all') {
        $json[$i]['id'] = $challange[0]; 
        $json[$i]['name'] = $challange[1];
        $json[$i]['points'] = $challange[2];
        $json[$i]['content'] = $challange[3];
        $i += 1;
    } else {
        if($challange[4] == 0) {
            $json[$i]['id'] = $challange[0]; 
            $json[$i]['name'] = $challange[1];
            $json[$i]['points'] = $challange[2];
            $json[$i]['content'] = $challange[3];
            $i += 1;
        }
    }
}
print json_encode($json);
?>