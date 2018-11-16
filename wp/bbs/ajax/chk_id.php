<?php
include_once("../../common.php");
$json['count']=0;

$query="select count(*) cnt from g5_member where mb_id='{$mb_id}';";
$result=sql_fetch($query);
$json['count']=$result['cnt'];
echo json_encode($json);
?>