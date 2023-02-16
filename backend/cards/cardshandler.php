<?php
/*
    Challange Handler handles editor request to create or delete card upgrades
*/
require_once (__DIR__.'/../mysql_bridge.php');
require_once (__DIR__.'/../auth/google_auth.php');

$link = 'http://localhost/mtg/upgrade.php?mode=message';

if(isset($_SESSION['id']) && isset($_POST) && isset($_GET)) {
    if($_GET['mode'] == 'add') {
        $cardname = $_POST['cardname'];
        $points = $_POST['points'];
        if(!is_numeric($points)) {
            $_SESSION['title'] = 'Fehler';
            $_SESSION['content'] = 'Hier ist wohl etwas schiefgelaufen!'; 
            header('Location: '.$link);
            exit();
        }
        $query_search = urlencode($cardname);
        $scryfall_result = file_get_contents('https://api.scryfall.com/cards/search?q='.$query_search);
        $response = json_decode($scryfall_result, true);
        if(!isset($response['data'][0]['image_uris']['png'])) {
            $_SESSION['title'] = 'Fehler';
            $_SESSION['content'] = 'Scryfall hat deine Karte nicht gefunden! Hast du sie richtig eingegeben?'; 
            header('Location: '.$link);
            exit();
        }
        $artlink = '';
        foreach($response['data'] as $card) {
            if($card['name'] == $cardname && $card['legalities']['commander'] == 'legal') {
                $artlink = $card['image_uris']['png'];
            }
        }
        if($artlink == '') {
            $artlink = $response['data'][0]['image_uris']['png'];
        }
        if(addCard($_SESSION['id'], $artlink, $points)) {
            $_SESSION['title'] = 'Erfolg';
            $_SESSION['content'] = 'Upgrade wurde hinzugefügt!'; 
            header('Location: '.$link);
            exit();
        }
        $_SESSION['title'] = 'Fehler';
        $_SESSION['content'] = 'Hier ist wohl etwas schiefgelaufen!'; 
        header('Location: '.$link);
        exit();
    } else if($_GET['mode'] == 'delete') {
        $cardid = $_POST['id'];
        if(!is_numeric($cardid)) {
            $_SESSION['title'] = 'Fehler';
            $_SESSION['content'] = 'Hier ist wohl etwas schiefgelaufen!'; 
            header('Location: '.$link);
            exit();
        }
        $card_data = getCardData();
        foreach ($card_data as $card) {
            if($card['id'] == $cardid) {
                if($card['owner'] != $_SESSION['id']) {
                    $_SESSION['title'] = 'Fehler';
                    $_SESSION['content'] = 'Du kannst nicht die Karten von anderen entfernen!'; 
                    header('Location: '.$link);
                    exit();
                }
            }
        }
        deleteCard($cardid);
        $_SESSION['title'] = 'Erfolg';
        $_SESSION['content'] = 'Karte erfolgreich entfernt!'; 
        header('Location: '.$link);
        exit();
    } else {
        $_SESSION['title'] = 'Fehler';
        $_SESSION['content'] = 'Hier ist wohl etwas schiefgelaufen!'; 
        header('Location: '.$link);
        exit();
    }
}
?>