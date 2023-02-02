<?php
session_start();
session_unset();
session_destroy();
if(isset($_GET['site'])) {
    $site = $_GET['site'];
    header("Location: http://localhost/mtg/$site");
}
?>