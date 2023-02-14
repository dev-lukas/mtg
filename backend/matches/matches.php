<?php
/*
    Backend-API for Match Javascript-GET Requests.
    Takes the whole match data and transforms it into a json blob
*/
require_once(__DIR__.'/../mysql_bridge.php');

$matchData = getMatchData();
$userData = getUserData();
$challangeData = getChallangeData();
$json = [];

function achieved($id) {
    if($id > 0) {
        return 1;
    } else {
        return 0;
    }
}

$i = 0;
foreach ($matchData as $match) {
    
    $json[$i]['id'] = $match[0];
    $json[$i]['date'] = date( 'd.m.Y', strtotime($match[1]));
    if($match[2] != 0) {
        $json[$i]['winner'] = $userData[$match[2] -1][1];
    } else {
        $json[$i]['winner'] = 0;
    }
    
    for($j = 1; $j < 6; $j++) {
        if($match[2 + $j] != 0) {
            $json[$i]['player_'.$j]['name'] = $userData[$match[2 + $j] - 1][1];
            $json[$i]['player_'.$j]['points'] = $match[7 + $j];
        }
    }

    for ($h = 1; $h < 5; $h++) {
        if($h == 1) {
            $json[$i]['challange_'.$h]['name'] = "Life Saver";
            $json[$i]['challange_'.$h]['points'] = 1;
            $json[$i]['challange_'.$h]['content'] = "Rette einen Mitspieler";
            $json[$i]['challange_'.$h]['achieved'] = achieved($match[16]);
            if($match[16] != 0) {
                $json[$i]['challange_'.$h]['achieved_from'] = $userData[$match[16] - 1][1];
            } else {
                $json[$i]['challange_'.$h]['achieved_from'] = 0;
            }
        } else {
            $json[$i]['challange_'.$h]['name'] = $challangeData[$match[11 + $h] - 1][1];
            $json[$i]['challange_'.$h]['points'] = $challangeData[$match[11 + $h] - 1][2];
            $json[$i]['challange_'.$h]['content'] = $challangeData[$match[11 + $h] - 1][3];
            $json[$i]['challange_'.$h]['achieved'] = achieved($match[15 + $h]);
            if($match[15 + $h] != 0) {
                $json[$i]['challange_'.$h]['achieved_from'] = $userData[$match[15 + $h]  - 1][1];
            } else {
                $json[$i]['challange_'.$h]['achieved_from'] = 0;
            }
        }
    }
    $i += 1;
}
print json_encode($json);
?>