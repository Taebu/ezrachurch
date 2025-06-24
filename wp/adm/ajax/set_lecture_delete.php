<?php
include_once("../../common.php");

$join_chk=join($chk,",");
$sql="delete from ez_lecture where el_no in (".$join_chk.")";


$query=$sql;
$json['query']=$query;
$result=sql_query($query);
$json['success']=$result;
$json['join_chk']=$join_chk;

echo json_encode($json);
?>