<?php
header("Content-Type: text/html; charset=UTF-8");

extract($_POST);
include("./_common.php");
$sql="insert into ez_youtubelink set ";
$sql.=sprintf("ey_videoid='%s',",$ey_videoid);
$sql.=sprintf("ey_title='%s',",$ey_title);
$sql.=sprintf("ey_group='%s',",$ey_group);
$sql.="ey_datetime=now();";
$result=sql_query($sql);
$json['success']=$result;
$json['sql']=$sql;
echo json_encode($json);