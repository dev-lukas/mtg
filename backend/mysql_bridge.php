<?php
include_once 'credentials.php';
/*
    Wrapper-Function to query any sql that does expect a return and doesn´t have input that need to be escaped
    Input: Sanitized SQL-Query String
    Return: Boolean false on Error or Return Value
*/
function query($sql) {
    global $servername, $username, $password, $dbname;
	$connection = mysqli_connect($servername, $username, $password, $dbname);
	if(!$connection) {
		return false;
	}
	if (($result = mysqli_query($connection, $sql)) == false) {
		return false;
	}
	$results = mysqli_fetch_all($result);
	mysqli_close($connection);
	return $results;
}

/*
    Wrapper-Function to query any sql that doesn´t expect a return and doesn´t have input that need to be escaped
    Input: Sanitized SQL-Query String
    Return: Boolean of Success
*/
function query_void($sql) {
    global $servername, $username, $password, $dbname;
    $connection = mysqli_connect($servername, $username, $password, $dbname);
	if(!$connection) {
		return false;
    }
	if (mysqli_query($connection, $sql) == false) {
		return false;
	}
	mysqli_close($connection);
	return true;
}

/*
	Returns all User-Data
	Return: MYSQL Table Array Object 
*/
function getUserData() {
    return query("SELECT * FROM `user`");
}
/*
	Returns all Card-Data
	Return: MYSQL Table Array Object 
*/
function getCardData() {
    return query("SELECT * FROM `cards`");
}
/*
	Returns all Match-Data
	Return: MYSQL Table Array Object 
*/
function getMatchData() {
	return query("SELECT * FROM `matches` ORDER BY `date` DESC");
}
/*
	Returns all Challange-Data
	Return: MYSQL Table Array Object 
*/
function getChallangeData() {
	return query("SELECT * FROM `challanges`");
}
/* 
	Returns points for specific Challange
  	Return: Integer
*/
function getChallangePoints($id) { 
	$results = query("SELECT `points` FROM `challanges` WHERE `id`='$id'");
	foreach($results as $result) {
		return $result[0];	
	}
}

/* 
	Return highest Challange ID
	Return: Integer
*/
function getHighestChallangeID() {
	$results = query("SELECT `id` FROM `challanges` ORDER BY `id` DESC LIMIT 1");
	foreach($results as $result) {
		return $result[0];	
	}
}
/* 
	Return highest Player ID
	Return: Integer
*/
function getHighestPlayerID() {
	$results = query("SELECT `id` FROM `user` ORDER BY `id` DESC LIMIT 1");
	foreach($results as $result) {
		return $result[0];	
	}
}

/*
	Adds match to match-history
	Return: Success Boolean
*/
function addMatch($date, $winner, $player_1, $player_2, $player_3, $player_4, $player_5, $player_1_points, $player_2_points, $player_3_points, $player_4_points, $player_5_points, $challange_1, $challange_2, $challange_3, $achieved_1, $achieved_2, $achieved_3, $achieved_4) {
	return query_void("INSERT INTO `matches`(`date`, `winner`, `player_1`, `player_2`, `player_3`, `player_4`, `player_5`, `player_1_points`, `player_2_points`, `player_3_points`, `player_4_points`, `player_5_points`, `challange_1`, `challange_2`, `challange_3`, `achieved_1`, `achieved_2`, `achieved_3`, `achieved_4`) VALUES ('$date','$winner','$player_1','$player_2','$player_3','$player_4','$player_5','$player_1_points','$player_2_points','$player_3_points','$player_4_points','$player_5_points','$challange_1','$challange_2','$challange_3','$achieved_1','$achieved_2','$achieved_3','$achieved_4')");
}
/*
	Deletes Match from Match History
	Return: Success Boolean
*/
function deleteMatch($id) {
	return query_void("DELETE FROM `matches` WHERE `id` = '$id'");
}
/*
	Attributes Points to all players
*/
function attributePoints($player_1, $player_2, $player_3, $player_4, $player_5, $player_1_points, $player_2_points, $player_3_points, $player_4_points, $player_5_points) {
	query_void("UPDATE `user` SET `points` = `points` + 2 WHERE `id` != '$player_1' AND `id` != '$player_2' AND `id` != '$player_3' AND `id` != '$player_4' AND `id` != '$player_5'");
	for($i = 1; $i < 6; $i++) {
		if(${'player_'.$i} != 0) {
			$player = ${'player_'.$i};
			$player_points = ${'player_'.$i.'_points'};
			query_void("UPDATE `user` SET `points` = `points` + $player_points WHERE `id` = '$player'");
		}
	}
}
/*
	Removes points from all players
*/
function removePoints($player_1, $player_2, $player_3, $player_4, $player_5, $player_1_points, $player_2_points, $player_3_points, $player_4_points, $player_5_points) {
	query_void("UPDATE `user` SET `points` = `points` - 2 WHERE `id` != '$player_1' AND `id` != '$player_2' AND `id` != '$player_3' AND `id` != '$player_4' AND `id` != '$player_5'");
	for($i = 1; $i < 6; $i++) {
		if(${'player_'.$i} != 0) {
			$player = ${'player_'.$i};
			$player_points = ${'player_'.$i.'_points'};
			query_void("UPDATE `user` SET `points` = `points` - $player_points WHERE `id` = '$player'");
		}
	}
}
/*
	Inserts a new Challange into the database
	Return: Success boolean
*/
function addChallange($title, $content, $points) {
	$disabled = 0;
	global $servername, $username, $password, $dbname;
    $connection = mysqli_connect($servername, $username, $password, $dbname);
	if(!$connection) {
		return false;
    }
	$query = mysqli_prepare($connection, 'INSERT INTO `challanges`(`name`, `points`, `content`, `disabled`) VALUES (?, ?, ?, ?)');
	mysqli_stmt_bind_param($query, 'sisi', $title, $points, $content, $disabled);
	mysqli_stmt_execute($query);
	mysqli_close($connection);
	return true;
}
/* 
	Set Challange to disabled
*/
function setChallangeDisabled($id) {
	return query_void("UPDATE `challanges` SET `disabled` = 1 WHERE `id` = $id");
}
/*
	Delete Challange
*/
function deleteChallange($id) {
	return query_void("DELETE FROM `challanges` WHERE `id` = $id");
}
/*
	Add a card upgrade
*/
function addCard($player, $cardname, $points) {
	global $servername, $username, $password, $dbname;
    $connection = mysqli_connect($servername, $username, $password, $dbname);
	if(!$connection) {
		return false;
    }
	$query = mysqli_prepare($connection, 'INSERT INTO `cards` (`owner`, `artlink`, `points`) VALUES (?, ?, ?)');
	mysqli_stmt_bind_param($query, 'ssi', $player, $cardname, $points);
	mysqli_stmt_execute($query);
	mysqli_close($connection);
	return true;
}
/*
	Delete Card
*/
function deleteCard($id) {
	return query_void("DELETE FROM `cards` WHERE `id` = $id");
}
?>