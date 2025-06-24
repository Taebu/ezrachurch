<?php
include_once $_SERVER['DOCUMENT_ROOT']."/ac/db_con.php";
include_once $_SERVER['DOCUMENT_ROOT']."/ac/subject.php";
extract($_GET);
$json = array();
$json['success']= false;
$json['member']="";
$sql = "select * from account_user ";
if(isset($mb_id))
{
$where = sprintf("where au_id='%s' ",$mb_id);
}else if(isset($ab_class)){
$where = sprintf("where ab_class='%s' ",$ab_class);
	
}
$query = $mysqli->query($sql.$where);
$member=$query->fetch_assoc();

if(isset($mb_id))
{
$sql = "select * from g5_member ";
$where = sprintf("where mb_id='%s' ",$mb_id);
$query = $mysqli->query($sql.$where);
$g5_member=$query->fetch_assoc();
}
if(isset($member)||isset($g5_member))
{
	$member['class_name']=$SUBJECT["ko"][$member['ab_class']];
	$json['member']=$member;
	if(isset($mb_id))
	{
		$json['g5_member']=$g5_member;
	}
	$json['success']= true;
}
echo json_encode($json);
