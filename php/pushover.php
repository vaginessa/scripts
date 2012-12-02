<?php

 /**
  * Send a notification
  * curl -s -F "token=APP_TOKEN" -F "user=USER_KEY" -F "message=hello world" https://api.pushover.net/1/messages.json
  * @param string $priority priority of push message (-1, 0 or 1)
  */
function send_notification($title, $message, $priority = "0") {
    $PUSHOVER_TOKEN = "---";
    $PUSHOVER_USER = "---";

    curl_setopt_array($ch = curl_init(), array(
        CURLOPT_URL => "https://api.pushover.net/1/messages.json",
        CURLOPT_POSTFIELDS => array(
        "token" => $PUSHOVER_TOKEN,
        "user" => $PUSHOVER_USER,
        "message" => $message,
        "priority" => $priority,
        "title" => $title,
    )));
    curl_exec($ch);
    curl_close($ch);
}

send_notification("notification","hello world","0");

?>
