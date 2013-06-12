<?php

include_once('simple_html_dom.php');

$selector = "table.general[width=98%] tr td[class*=etat]";
$url = "http://www.free-reseau.fr/";
$check_time_max = 48;
$idx_day_max = 1;
//$code = "se167-1";

$code = $_GET['code'];
scraping($code);

function scraping($code) {
    global $selector, $url, $check_time_max, $idx_day_max;

    $html = file_get_html($url.$code);
    
    $check_time = 0;
    $idx_day = 0;
    
    $day = array();
    
    foreach($html->find($selector) as $article) {
    
        //check class attr value
        if($article->class == "etatok") {
            $value = "OK";
        }
        else if($article->class == "etatnonfait") {
             $value = "?";
        }
        else if($article->class == "etatpartielnok") {
             $value = "WARNING";
        }
        else if($article->class == "etatnok") {
             $value = "ERROR";
        }
        else {
             $value = "!";
        }
        
        $day["".$check_time/2] = $value;
        $check_time++;

        if($check_time == $check_time_max) {
            $state[$idx_day] = $day;
            $day = array();
            $check_time = 0;
            $idx_day++;
            
            if($idx_day == $idx_day_max) {
                $json = array($code => $state);
                $html->clear();
                unset($html);
                echo json_encode($json);
                exit;
            }
        }
    }
}

?>
