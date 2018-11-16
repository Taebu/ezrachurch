<?php
include_once("./_common.php");
/*
create table lecture_memo(
lm_content text,
ey_videoid varchar(255) not null,
mb_id varchar(50) not null,
lm_datetime datetime,
primary key(ey_videoid,mb_id)
);
*/
$sql="INSERT INTO lecture_memo SET ";
$sql.=sprintf("ey_videoid='%s',",$ey_videoid);
$sql.=sprintf("lm_content='%s',",$lm_content);
$sql.=sprintf("mb_id='%s',",$mb_id);
$sql.="lm_datetime=now() ";
$sql.="ON DUPLICATE KEY UPDATE ";
$sql.=sprintf("lm_content='%s',",$lm_content);
$sql.=sprintf("ey_videoid='%s',",$ey_videoid);
$sql.=sprintf("mb_id='%s',",$mb_id);
$sql.="lm_datetime=now();";
$result=sql_query($sql);
$json=array();
$json['success']=$result;

echo json_encode($json);
?>

