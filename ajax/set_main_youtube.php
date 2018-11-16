<?php
$iswed="";
include_once "../db_con.php";
$where="";
$db = new mysqli($host_name, $user_name, $db_password, $db_name);
extract($_POST);
$db->query('SET NAMES utf8');

if($mode=='modify')
{
	$sql="update newezra.ez_youtubemain set ";
	$sql.=sprintf("ym_link='%s',",$ym_link);
	$sql.=sprintf("ym_content='%s', ",$ym_content);
	$sql.=sprintf("ym_time='%s' ",$ym_time);
	$sql.=sprintf("where ym_no='%s' ;",$ym_no);
}

if($mode=='write')
{
	$sql="insert into newezra.ez_youtubemain set ";
	$sql.=sprintf("ym_link='%s',",$ym_link);
	$sql.=sprintf("ym_content='%s', ",$ym_content);
	$sql.=sprintf("ym_time='%s', ",$ym_time);
	$sql.="ym_datetime=now() ";
}

if($mode=='delete')
{
	$sql="delete from newezra.ez_youtubemain ";
	$sql.=sprintf("where ym_no='%s' ;",$ym_no);
}


$query=$db->query($sql);

$json=array();

$json['success']=$query;
$json['sql']=$sql;
echo json_encode($json);
?>