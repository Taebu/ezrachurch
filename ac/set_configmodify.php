<?php
include "./db_con.php";
$TABLES=$_POST;
$table = isset($table)?$table:"";
$table=$_POST['table'];
$mode=isset($mode)?$mode:"";
if($mode=="modify")
{

$TABLES=array_diff_key($TABLES, array('table' => "",'ac_year' => "",'mode' => ""));
$sql=sprintf("update `%s` SET ",$table);
$sqls=array();
foreach($TABLES as $key =>$value)
{
	$value=addslashes($value);
	$sqls[]=sprintf("`%s`='%s' ",$key,$value);
}
$sql.=join(",",$sqls);
$sql.=sprintf("where ac_year='%s';",$ac_year);
//$query=mysql_query($sql);
$query=$mysqli->query($sql);
} /**  mode==modify */

$json=array();
$json['success']=$query;
echo json_encode($json);