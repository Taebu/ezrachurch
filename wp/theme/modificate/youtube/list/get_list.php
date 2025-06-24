<?php
$ch = curl_init();

$header_data = [];
$header_data[] = 'Authorization: Bearer '.$_POST['access_token'];
$header_data[] = 'X-Client-Data '.$_POST['access_token'];
//curl_setopt($ch, CURLOPT_HEADER, true);//헤더 정보를 보내도록 함(*필수)

curl_setopt($ch, CURLOPT_URL, "https://content.googleapis.com/youtube/v3/playlistItems");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data); //header 지정하기

$jsonArray = $_POST;
curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($jsonArray));

$result = curl_exec($ch);
curl_close($ch);

echo $result;
