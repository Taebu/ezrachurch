<?php
include_once("../../common.php");
/*
wp/bbs/ajax/get_dontions.php
*/
$sql=array();
$sql[]="select * from g5_donations ";
/*
$sql[]=sprintf("where wr_id='%s' ",$wr_id);
$sql[]=sprintf("and bo_table='%s' ",$bo_table);
*/
$query=sql_query(join("",$sql));

$json=array();
$json['donations']=array();
 while ($list = sql_fetch_array($query))
{
	array_push($json['donations'],$list);

}
echo json_encode($json);