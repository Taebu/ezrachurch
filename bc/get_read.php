<?php
include "../db_con.php";
$TABLES=$_POST;
if(isset($TABLES['type'])&&$TABLES['type']=="list")
{
	$json = array();
	$sql=sprintf("select * from ez_bible where mb_id='%s';",$TABLES['mb_id']);
	$query=$db->query($sql);
	$json['lists']= array();
	while($list=$query->fetch_assoc())
	{
		array_push($json['lists'],$list);
	}
	echo json_encode($json);
}else{
	$sql=sprintf("select * from ez_bible where mb_id='%s' order by eb_no desc limit 1;",$TABLES['mb_id']);
	$query=$db->query($sql);
	$images=$query->fetch_assoc();
	echo json_encode($images);
}