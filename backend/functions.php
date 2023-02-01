<?php
include_once 'mysql_bridge.php';

function getHash($id) {
    return query("SELECT `registerhash` FROM `user` WHERE id='$id'");
}

function getPassword($id) {
    return query("SELECT `password` FROM `user` WHERE id='$id'");
}

function setPassword($id, $password) {
    return query_void("UPDATE `user` SET `password`='$password' WHERE `id`='$id'");
}

?>