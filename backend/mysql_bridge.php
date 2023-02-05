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
?>