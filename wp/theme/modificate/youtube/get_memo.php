<?php
include_once("./_common.php");
/*
create table lecture_memo(
lm_no int unsigned auto_increment,
lm_content text,
ey_videoid varchar(255) not null,
mb_id varchar(50) not null,
lm_datetime datetime,
primary key(ey_videoid,mb_id)
);
*/
$sql="select * from  lecture_memo where ";
$sql.=sprintf("ey_videoid='%s' and ",$ey_videoid);
$sql.=sprintf("mb_id='%s';",$mb_id);
$result=sql_fetch($sql);
$json=array();
//$json['success']=;
$json['lm_content']=$result['lm_content'];
$json['sql']=$sql;

echo json_encode($json);
?>