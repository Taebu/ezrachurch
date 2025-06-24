<?php
include "./db_con.php";
$TABLES=$_POST;
$table=$_POST['table'];

$TABLES=array_diff_key($TABLES, array('table' => ""));
$sql=sprintf("insert into `%s` SET ",$table);
$sqls=array();
foreach($TABLES as $key =>$value)
{
	$value = addslashes($value);
	$sqls[]=sprintf("`%s`='%s' ",$key,$value);
}

$sqls[]="`eh_datetime`=now() ";

$sql.=join(",",$sqls);
$sql.=";";
//$query=mysql_query($sql);
$query=$mysqli->query($sql);
$json=array();
$json['success']=$query;
$json['REMOTE_ADDR']=$_SERVER['REMOTE_ADDR'];
$json['sql']=$sql;
echo json_encode($json);