<?php

/*
ezrachurch.kr/ajax/get_youtubemain.php
*/

include_once "../db_con.php";
$connect = new mysqli($host_name, $user_name, $db_password, $db_name);
//$result = $connect->query("SELECT 'Hello, dear MySQL user!' AS _message FROM DUAL");
//$row = $result->fetch_assoc();
//echo htmlentities($row['_message']);


$connect->query('SET NAMES utf8');
$sql="SELECT * FROM newezra.ez_youtubemain  order by ym_no desc";

$query=$connect->query($sql);
$json=array();
$json['posts']=array();
while($list=$query->fetch_assoc()){
array_push($json['posts'],$list);
}
echo json_encode($json);
