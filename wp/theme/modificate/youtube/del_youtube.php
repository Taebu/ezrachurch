<?php
header("Content-Type: text/html; charset=UTF-8");

extract($_POST);
//SELECT * FROM newezra.ez_youtubelink where ey_videoid='N2Y94UQTmpo';

include("./_common.php");
$json['success']=false;
if($link!="")
{
	$sql="DELETE FROM ez_youtubelink WHERE ";
	$sql.=sprintf("ey_videoid='%s';",$link);
	$result=sql_query($sql);
	$json['success']=$result;
	$json['sql']=$sql;
}
echo json_encode($json);