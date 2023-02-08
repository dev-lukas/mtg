<?php
/*
    Backend-API for Player Javascript-GET Requests.
    Takes the whole player data, cuts sensitive information and transforms it into a json blob
*/
require_once(__DIR__.'/../mysql_bridge.php');

$player_data = getUserData();
$json = [];
$i = 0;
foreach ($player_data as $player) {
    $json[$i]['id'] = $player[0]; 
    $json[$i]['name'] = $player[1];
    $json[$i]['points'] = $player[3];
    $i += 1;
}
print json_encode($json);
?>