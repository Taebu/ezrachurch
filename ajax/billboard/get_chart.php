<?php
$iswed="x";
include_once $_SERVER['DOCUMENT_ROOT']."/db_con.php";
$where="";
$connect = new mysqli($host_name, $user_name, $db_password, $db_name);

$json = array();
$json['data'] = array();
$json['data']['columns'] = array();
$json['data']['x'] = "x";
$json['data']['type'] = "spline";
/* data A */

/* 반복 1 */
$date_columns = array();
$date_columns[] = "x";

/* 반복 2 */
$am_columns = array();
$am_columns[] = "오전";

/* 반복 3 */
$ru_columns = array();
$ru_columns[] = "점심";

/* 반복 4 */
$pm_columns = array();
$pm_columns[] = "오후";

/* 반복 5 */
//$we_columns = array();
//$we_columns[] = "수요일";

/* data Z */



if(isset($to_date))
{
$where.=sprintf(" and insdate >= DATE('%s') ",$fr_date);
}

if(isset($to_date))
{
$where.=sprintf(" and insdate < (DATE('%s') + INTERVAL 1 DAY) ",$to_date);
}
$where.=$iswed=="O"?" and we>0 and pm='' ":""; 
$where.="  and am>0 ";
$sql=sprintf("select * from attendance where 1=1 %s order by insdate;",$where);

$query=$connect->query($sql);

while($list=$query->fetch_assoc()){
$date_columns[] = $list['insdate'];
$am_columns[] = $list['am']?$list['am']:'';
$ru_columns[] = $list['ru']?$list['ru']:'';
$pm_columns[] = $list['pm']?$list['pm']:'';
//$we_columns[] = $list['we']?$list['we']:'';
}
array_push($json['data']['columns'],$date_columns);
array_push($json['data']['columns'],$am_columns);
array_push($json['data']['columns'],$ru_columns);
array_push($json['data']['columns'],$pm_columns);
//array_push($json['data']['columns'],$we_columns);


$json['data']['types'] = array("오전"=>"spline","점심"=>"spline","오후"=>"spline","수요일"=>"spline");
$json['axis']["x"]=array("type"=>"timeseries","tick"=>array("format"=>"%m-%d"));
$json['bubble']=array("maxR"=>50);
$json['bindto'] = "#areaChart";
echo json_encode($json);