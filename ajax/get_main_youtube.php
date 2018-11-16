<?php
$iswed="";
include_once "../db_con.php";
$where="";
$connect = new mysqli($host_name, $user_name, $db_password, $db_name);

$sql="select * from ez_youtubemain;";
$query=$connect->query($sql);
$json=array();
while($list=$query->fetch_assoc()){
array_push($json,$list);
}
echo json_encode($json);
?>