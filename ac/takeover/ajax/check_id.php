<?php
include_once $_SERVER['DOCUMENT_ROOT']."/db_con.php";
extract($_GET);
$json = array();
$json['success']= false;
$sql = "select * from g5_member ";
$where = sprintf("where mb_id='%s' ",$mb_id);
$query = $db->query($sql.$where);
$member=$query->fetch_assoc();
if(isset($member))
{
	$json['success']= true;
	$json['mb_name']= $member['mb_name'];
}
echo json_encode($json);
