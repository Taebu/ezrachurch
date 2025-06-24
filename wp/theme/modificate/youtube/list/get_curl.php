<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/oauth2/v4/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$jsonArray = $_POST;
curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($jsonArray));

$result = curl_exec($ch);
curl_close($ch);

echo $result;