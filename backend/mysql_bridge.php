<?php
include_once 'credentials.php';

/*
    Wrapper-Function to query any sql that doesn´t expect a return
    Input: Sanitized SQL-Query String
    Output: Boolean of Success
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
    Wrapper-Function to query any sql that does expect a return
    Input: Sanitized SQL-Query String
    Output: Boolean false on Error or Return Value
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
	$results = mysqli_fetch_assoc($result);
	mysqli_close($connection);
	return $results;
}
?>