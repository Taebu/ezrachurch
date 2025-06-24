<?php
include "./db_con.php";
$TABLES=$_POST;
$table = isset($table)?$table:"";
$table=$_POST['table'];
$mode=isset($mode)?$mode:"";
if($mode=="modify")
{

$TABLES=array_diff_key($TABLES, array('table' => "",'mode' => ""));
$sql=sprintf("update `%s` SET ",$table);
$sqls=array();
foreach($TABLES as $key =>$value)
{
	$value=addslashes($value);
	$sqls[]=sprintf("`%s`='%s' ",$key,$value);
}
$sqls[]="`au_modify_datetime`=now() ";
$sql.=join(",",$sqls);
$sql.=sprintf("where au_no='%s';",$au_no);
//$query=mysql_query($sql);
$query=$mysqli->query($sql);
} /**  mode==modify */

$json=array();
$json['success']=$query;
echo json_encode($json);