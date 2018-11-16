<?php
include "./db_con.php";
$TABLES=$_POST;
$wm_no=$_POST['wm_no'];
$table=$_POST['table'];

$TABLES=array_diff_key($TABLES, array('table' => "",'wm_no' => ""));
$sql=sprintf("update `%s` SET ",$table);
$sqls=array();
foreach($TABLES as $key =>$value)
{
	$value=addslashes($value);
	$sqls[]=sprintf("`%s`='%s' ",$key,$value);
}

$sql.=join(",",$sqls);
$sql.=sprintf("where wm_no='%s';",$wm_no);
//$query=mysql_query($sql);
$query=$mysqli->query($sql);
$json=array();
$json['success']=$query;
echo json_encode($json);