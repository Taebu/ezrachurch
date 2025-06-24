<?php
include_once "../wp/common.php";
extract($_REQUEST);
$json = array();
$json = $_POST;
$json['success'] = false;
if($mode=="update")
{
$sql = "update schedule set ";
$sql.=sprintf("name='%s',",$_POST['name']);
$sql.=sprintf("memo='%s',",$_POST['memo']);
$sql.=sprintf("frdt='%s',",$_POST['frdt']);
$sql.=sprintf("todt='%s',",$_POST['todt']);
$sql.=sprintf("holiday='%s' ",$_POST['holiday']);
$sql.=sprintf("where no='%s'",$_POST['no']);
$result=sql_query($sql);
}

if($mode=="insert")
{
$sql = "insert into schedule set ";
$sql.=sprintf("name='%s',",$_POST['name']);
$sql.=sprintf("memo='%s',",$_POST['memo']);
$sql.=sprintf("frdt='%s',",$_POST['frdt']);
$sql.=sprintf("todt='%s',",$_POST['todt']);
$sql.=sprintf("holiday='%s';",$_POST['holiday']);
$result=sql_query($sql);
}

if($mode=="delete")
{
$sql = "delete from schedule ";
$sql.=sprintf("where no='%s'",$_POST['no']);
$result=sql_query($sql);
}
if($result)
{
	$json['success'] = true;
}
$json['sql'] = $sql;
echo json_encode($json);