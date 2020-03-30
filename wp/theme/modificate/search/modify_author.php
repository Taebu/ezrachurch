<?php
header("Content-Type: text/html; charset=UTF-8");

extract($_POST);

include("./_common.php");
$json['success']=false;
if(isset($ey_videoid))
{
	$sql="update ez_youtubelink set ";
	$sql.=sprintf("ey_author='%s' ",$ey_author);
	$sql.=" WHERE ";
	$sql.=sprintf("ey_videoid='%s';",$ey_videoid);
	$result=sql_query($sql);
	$json['success']=$result;
	$json['sql']=$sql;
}
echo json_encode($json);