<?php
$url = "https://equran.id/api/v2/surat";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);
if (curl_error($ch)) {
    echo curl_error($ch);
}

curl_close($ch);

$data_objek = json_decode($response, true);
?>