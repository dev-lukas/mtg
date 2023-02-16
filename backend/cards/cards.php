<?php
/*
    Backend-API for Player Javascript-GET Requests.
    Takes the whole player data, cuts sensitive information and transforms it into a json blob
*/
require_once(__DIR__.'/../mysql_bridge.php');

$card_data = getCardData();
$json = [];
$i = 0;
foreach ($card_data as $card) {
    $json[$i]['id'] = $card[0]; 
    $json[$i]['owner'] = $card[1];
    $json[$i]['artlink'] = $card[2];
    $json[$i]['points'] = $card[3];
    $i += 1;
}
print json_encode($json);
?>