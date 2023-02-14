<?php
/*
    Matchhandler handles editor request to create or delete matches
*/
require_once (__DIR__.'/../mysql_bridge.php');
require_once (__DIR__.'/../auth/google_auth.php');

// Simple validate function to sanitze most of the input since we mostly expect only numbers
function validate($value) {
    if(is_numeric($value)) {
        return ceil(abs($value));
    } else {
        exit();
    }
}

if(isset($_SESSION['id']) && isset($_POST) && isset($_GET)) {
    if($_GET['mode'] == 'add') {

        $date = date( 'Y-m-d', strtotime($_POST['date']));

        $player_1 = validate($_POST['player-1']);
        $player_2 = validate($_POST['player-2']);
        $player_3 = validate($_POST['player-3']);
        $player_4 = validate($_POST['player-4']);
        $player_5 = validate($_POST['player-5']);
        $winner = validate($_POST['winner']);
        $achiever_1 = validate($_POST['achiever-1']);
        $achiever_2 = validate($_POST['achiever-2']);
        $achiever_3 = validate($_POST['achiever-3']);
        $achiever_4 = validate($_POST['achiever-4']);
        $challange_2 = validate($_POST['challange-1']);
        $challange_3 = validate($_POST['challange-2']);
        $challange_4 = validate($_POST['challange-3']);

        $highestPlayerId = getHighestPlayerID();
        if($player_1 > $highestPlayerId || $player_2 > $highestPlayerId || $player_3 > $highestPlayerId || $player_4 > $highestPlayerId || $player_5 > $highestPlayerId || $winner > $highestPlayerId || $achiever_1 > $highestPlayerId || $achiever_2 > $highestPlayerId || $achiever_3 > $highestPlayerId || $achiever_4 > $highestPlayerId) {
            exit();
        }

        if($player_1 == 0 || $player_2 == 0 || $player_3 == 0 || $player_4 == 0) {
            exit();
        }

        if($player_1 == $player_2 || $player_1 == $player_3 || $player_1 == $player_4 || $player_2 == $player_3 || $player_2 == $player_4 || $player_3 == $player_4) {
            exit();
        }

        if($player_5 != 0) {
            if($player_5 == $player_1 || $player_5 == $player_2 || $player_5 == $player_3 || $player_5 == $player_4) {
                exit();
            }
        }

        if($winner != 0) {
            if($winner != $player_1 && $winner != $player_2 && $winner != $player_3 && $winner != $player_4 && $winner != $player_5) {
                exit();
            }
        }

        for($i = 1; $i < 5; $i++) {
            if(${'achiever_'.$i} != 0) {
                if(${'achiever_'.$i} != $player_1 && ${'achiever_'.$i} != $player_2 && ${'achiever_'.$i} != $player_3 && ${'achiever_'.$i} != $player_4 && ${'achiever_'.$i} != $player_5) {
                    exit();
                }
            }
        }

        if($challange_2 == 0 || $challange_3 == 0 || $challange_4 == 0) {
            exit();
        }

        if($challange_2 == $challange_3 || $challange_2 == $challange_4 || $challange_2 == $challange_4) {
            exit();
        }

        $highestChallangeId = getHighestChallangeID();
        if($challange_2 > $highestChallangeId || $challange_3 > $highestChallangeId || $challange_4 > $highestChallangeId) {
            exit();
        }

        $player_1_points = $player_2_points = $player_3_points = $player_4_points = $player_5_points = 3;
        for($i = 1; $i < 6; $i++) {
            if(isset($_POST['player_'.$i.'_extra_point'])) {
                ${'player_'.$i.'_points'} += 1;
            }
            if(isset($_POST['player_'.$i.'_minus_point'])) {
                ${'player_'.$i.'_points'} += -1;
            }
            for($j = 1; $j < 5; $j++) {
                if(${'player_'.$i} == ${'achiever_'.$j}) {
                    if($j == 1) {
                        ${'player_'.$i.'_points'} += 1;
                    } else {
                        ${'player_'.$i.'_points'} += getChallangePoints(${'challange_'.$j});
                    }
                }
            }
        }
        if(addMatch($date, $winner, $player_1, $player_2, $player_3, $player_4, $player_5, $player_1_points, $player_2_points, $player_3_points, $player_4_points, $player_5_points, $challange_2, $challange_3, $challange_4, $achiever_1, $achiever_2, $achiever_3, $achiever_4)) {
            attributePoints($player_1, $player_2, $player_3, $player_4, $player_5, $player_1_points, $player_2_points, $player_3_points, $player_4_points, $player_5_points);
        }
    } else if($_GET['mode'] == 'delete') {
        $id = validate($_POST['date']);
        $matchData = getMatchData();
        foreach ($matchData as $match) {
            if($match[0] == $id) {
                removePoints($match[3], $match[4], $match[5], $match[6], $match[7], $match[8], $match[9], $match[10], $match[11], $match[12]);
                deleteMatch($id);
            }
        }
    } else {
        exit();
    }
} else {
    exit();
}
?>