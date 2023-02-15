<?php
/*
    Challange Handler handles editor request to create or delete challanges
*/
require_once (__DIR__.'/../mysql_bridge.php');
require_once (__DIR__.'/../auth/google_auth.php');

$link = 'http://localhost/mtg/editor.php?mode=message';

if(isset($_SESSION['id']) && isset($_POST) && isset($_GET)) {
    if($_GET['mode'] == 'add') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $points = $_POST['points'];
        if(!is_numeric($points)) {
            $_SESSION['title'] = 'Fehler';
            $_SESSION['content'] = 'Hier ist wohl etwas schiefgelaufen!'; 
            header('Location: '.$link);
            exit();
        }
        $challange_data = getChallangeData();
        foreach ($challange_data as $challange) {
            if($challange[1] == $title && $challange[4] == 0) {
                $_SESSION['title'] = 'Fehler';
                $_SESSION['content'] = 'Eine Challange mit diesem Namen existiert bereits!'; 
                header('Location: '.$link);
                exit();
            }
        }
        if(addChallange($title, $content, $points)) {
            $_SESSION['title'] = 'Erfolg';
            $_SESSION['content'] = 'Die Challange wurde erfolgreich hinzugefügt!'; 
            header('Location: '.$link);
            exit();
        }
        $_SESSION['title'] = 'Fehler';
        $_SESSION['content'] = 'Hier ist wohl etwas schiefgelaufen!'; 
        header('Location: '.$link);
        exit();
    } else if($_GET['mode'] == 'delete') {
        $id = $_POST['challange'];
        if(!is_numeric($id)) {
            $_SESSION['title'] = 'Fehler';
            $_SESSION['content'] = 'Hier ist wohl etwas schiefgelaufen!'; 
            header('Location: '.$link);
            exit();
        }
        $matchData = getMatchData();
        $isInMatch = false;
        foreach ($matchData as $match) {
            if($match[13] == $id || $match[14] == $id || $match[15] == $id) {
                $isInMatch = true;
            }
        }
        if ($isInMatch == true) {
            setChallangeDisabled($id);
            $_SESSION['title'] = 'Erfolg';
            $_SESSION['content'] = 'Die Challange wurde erfolgreich gelöscht!'; 
            header('Location: '.$link);
            exit();
        } else {
            deleteChallange($id);
            $_SESSION['title'] = 'Erfolg';
            $_SESSION['content'] = 'Die Challange wurde erfolgreich gelöscht!'; 
            header('Location: '.$link);
            exit();
        }
    } else {
        $_SESSION['title'] = 'Fehler';
        $_SESSION['content'] = 'Hier ist wohl etwas schiefgelaufen!'; 
        header('Location: '.$link);
        exit();
    }
}
?>