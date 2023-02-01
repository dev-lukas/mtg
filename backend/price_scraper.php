<?php
if(isset($_POST)) {
    try {
        $i = 0;
        while($i < 2) {
            if($i == 0) {
                $cardname = $_POST['cardname'];
            } else {
                $cardname = $_POST['cardnameVariation'];
            }
            $ch = curl_init();
            $config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
            curl_setopt($ch, CURLOPT_URL, 'https://www.cardmarket.com/en/Magic/Cards/'.$cardname.'?sellerCountry=7&language=1,3&minCondition=4&isPlayset=N');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);
            curl_setopt($ch, CURLOPT_REFERER, 'https://www.cardmarket.com/');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            $start = stripos($response, '<div class="price-container d-none d-md-flex justify-content-end">');
            $end = stripos($response, '</span>', $offset = $start);
            $length = $end - $start;
            $section = substr($response, $start, $length);
            $match = [];
            $found = preg_match('/\d*,\d*\s€/', $section, $match);
            curl_close($ch);
            if($found == 1) {
                echo $match[0];
                exit;
            } else {
                $i += 1;
            }
        }
        echo '0';
        exit;
    } catch (Exception $e) {
        echo '-1';
        exit;
    }
}
?>