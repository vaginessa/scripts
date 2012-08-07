<?php

$url = 'https://localhost/rest';

/*$headers = array(
    'Accept: application/json',
    'Content-Type: application/json',
);

$data = json_encode($_POST);
*/

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

curl_setopt($handle, CURLOPT_HEADER, false);
curl_setopt($handle, CURLOPT_VERBOSE, true);

curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

//curl_setopt($handle, CURLOPT_USERPWD, "login:password");
//curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

//curl_setopt($handle, CURLOPT_POST, true);
//curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($handle);
$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if($code == 200) {
    echo $response;
}
