<?php
/*
/wp/bbs/ajax/set_donations.php
*/
include_once("../../common.php");

$json=array();
$json['success']=false;
$is_validate=isset($bo_table)&&isset($wr_id)&&isset($do_content);

	$sql=array();
	$sql[]="insert into g5_donations set";
	$sql[]=sprintf(" bo_table='%s',",$bo_table);
	$sql[]=sprintf(" wr_id='%s',",$wr_id);
	$sql[]=sprintf(" do_content='%s',",$do_content);
	$sql[]=sprintf(" do_price='%s',",$do_price);
	$sql[]=" do_datetime=now();";
	$query=sql_query(join("",$sql));
	$json['success']=$query;
	echo json_encode($json);

/*이제까지의 모든 금액을 합산한다.*/
	$sql=array();
	$sql[]=sprintf("update g5_write_%s set",$bo_table);
	$sql[]=sprintf(" wr_3=wr_3+%s ",$do_price);
	$sql[]=sprintf(" where wr_id='%s';",$wr_id);
	$query=sql_query(join("",$sql));