<?php
/*
    Backend-API for Match Javascript-GET Requests.
    Takes the whole match data and transforms it into a json blob
*/
require_once(__DIR__.'/../mysql_bridge.php');

$matchData = getMatchData();
$userData = getUserData();
$json = [];

function getUserName($id, $userData) {
    if($id != 0) {
        return $userData[$id - 1][1];
    } else {
        return 0;
    }
}

$i = 0;
foreach ($matchData as $match) {
    $json[$i]['id'] = $match[0];
    $json[$i]['date'] = date( 'd.m.Y', strtotime($match[1]));
    $json[$i]['player_1'] = getUserName($match[2], $userData);
    $json[$i]['player_2'] = getUserName($match[3], $userData);
    $json[$i]['player_3'] = getUserName($match[4], $userData);
    $json[$i]['player_4'] = getUserName($match[5], $userData);
    $json[$i]['player_5'] = getUserName($match[6], $userData);
    $json[$i]['challange_1'] = $match[7];
    $json[$i]['challange_2'] = $match[8];
    $json[$i]['challange_3'] = $match[9];
    $json[$i]['achieved_1'] = $match[10];
    $json[$i]['achieved_2'] = $match[11];
    $json[$i]['achieved_3'] = $match[12];
    $json[$i]['achieved_4'] = $match[13];
    $json[$i]['winner'] = $match[14];
    $i += 1;
}
print json_encode($json);
?>