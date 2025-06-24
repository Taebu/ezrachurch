<?php
include_once($_SERVER['DOCUMENT_ROOT']."/wp/common.php");

if($mode=="write")
{

$sql="insert into  ez_daily set ";
$sql.=sprintf("ed_subject='%s',",$ed_subject);
$sql.=sprintf("ed_date='%s',",$ed_date);
$sql.=sprintf("ed_author='%s',",$ed_author);
$sql.=sprintf("ed_youtube_url='%s',",$ed_youtube_url);
$sql.=sprintf("ed_content='%s';",$ed_content);
}


if($mode=="modify")
{

$sql="update  ez_daily set ";
$sql.=sprintf("ed_subject='%s',",$ed_subject);
$sql.=sprintf("ed_date='%s',",$ed_date);
$sql.=sprintf("ed_author='%s',",$ed_author);
$sql.=sprintf("ed_youtube_url='%s',",$ed_youtube_url);
$sql.=sprintf("ed_content='%s' ",$ed_content);
$sql.=sprintf("where ed_no='%s' ",$ed_no);

}

$query=$sql;
$json['query']=$query;
$result=sql_query($query);
$json['success']=$result;
$json['join_chk']=$join_chk;

echo json_encode($json);
