<?php
include_once("../../common.php");
extract($_POST);

if($mode=="write")
{
$sql=array();
$sql[]="INSERT INTO  ez_meet SET ";
$sql[]="em_lecture_no='{$em_lecture_no}',";
$sql[]="em_receipt_st='{$em_receipt_st}',";
$sql[]="em_receipt_ed='{$em_receipt_ed}',";
$sql[]="em_lecture_st='{$em_lecture_st}',";
$sql[]="em_lecture_ed='{$em_lecture_ed}',";
$sql[]="em_place='{$em_place}',";
$sql[]="em_lecture_name='{$em_lecture_name}',";
$sql[]="em_lecture_contents='{$em_lecture_contents}',";
$sql[]="em_author='{$em_author}',";
$sql[]="em_phone='{$em_phone}',";
$sql[]="em_status='{$em_status}',";
$sql[]="em_datetime=now();";

$query=join("",$sql);
$result=sql_query($query);
$json=array();
$json['success']=$result;
$json['query']=$query;
echo json_encode($json);
} /*if($mode=="write"){...}*/

if($mode=="update")
{
$sql=array();
$sql[]="UPDATE  ez_meet SET ";
$sql[]="em_lecture_no='{$em_lecture_no}',";
$sql[]="em_receipt_st='{$em_receipt_st}',";
$sql[]="em_receipt_ed='{$em_receipt_ed}',";
$sql[]="em_lecture_st='{$em_lecture_st}',";
$sql[]="em_lecture_ed='{$em_lecture_ed}',";
$sql[]="em_place='{$em_place}',";
$sql[]="em_lecture_name='{$em_lecture_name}',";
$sql[]="em_lecture_contents='{$em_lecture_contents}',";
$sql[]="em_author='{$em_author}',";
$sql[]="em_phone='{$em_phone}',";
$sql[]="em_status='{$em_status}',";
$sql[]="em_datetime=now() ";
$sql[]="where em_no='{$em_no}';";
 
$query=join("",$sql);
$result=sql_query($query);
$json=array();
$json['success']=$result;
$json['query']=$query;
echo json_encode($json);
} /*if($mode=="update"){...}*/

if($mode=="delete")
{
$sql=array();
$sql[]="delete from  ez_meet ";
$sql[]="where em_no='{$em_no}';";
 
$query=join("",$sql);
$result=sql_query($query);
$json=array();
$json['success']=$result;
$json['query']=$query;
echo json_encode($json);
} /*if($mode=="delete"){...}*/
?> 