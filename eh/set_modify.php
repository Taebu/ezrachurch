<?php
include "./db_con.php";

if($is_block_ip)
{
	exit();
}
$TABLES=$_POST;
$eh_no=$_POST['eh_no'];
$table=$_POST['table'];

$TABLES=array_diff_key($TABLES, array('table' => "",'eh_no' => ""));
$sql=sprintf("update `%s` SET ",$table);
$sqls=array();
foreach($TABLES as $key =>$value)
{
	$value=addslashes($value);
	$sqls[]=sprintf("`%s`='%s' ",$key,$value);
}
$sqls[]="`eh_modify_datetime`=now() ";
$sql.=join(",",$sqls);
$sql.=sprintf("where eh_no='%s';",$eh_no);
//$query=mysql_query($sql);
$query=$mysqli->query($sql);
$json=array();
$json['success']=$query;
$json['sql']=$sql;
echo json_encode($json);