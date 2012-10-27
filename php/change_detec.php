<?php

set_time_limit(0);

//check page for update
$frequency = 60*20; //20 minutes
$page = "https://play.google.com/store/apps/details?id=com.rovio.BadPiggies&hl=fr";
$pattern = '/<time itemprop="datePublished">27 septembre 2012<\/time>/';

//notifications by email
$email = "---@api.pushover.net";
$title = "BadPiggies updated";

while(1)
{
    //get the page
    $content = file_get_contents($page);

    //check the regular expression
    if(preg_match($pattern,$content)) {
        echo "[*] No update :( \n";
    }
    else {
        echo "[*] Update! :)\n";
        mail($email,$title,$title);
        exit();
    }

    echo "...\n";
    sleep($frequency);
}

?>
