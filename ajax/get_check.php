<?php
$iswed="";
include_once "../db_con.php";
$where="";
$connect = new mysqli($host_name, $user_name, $db_password, $db_name);
//$result = $connect->query("SELECT 'Hello, dear MySQL user!' AS _message FROM DUAL");
//$row = $result->fetch_assoc();
//echo htmlentities($row['_message']);

if(isset($to_date))
{
$where.=sprintf(" and insdate >= DATE('%s') ",$fr_date);
}

if(isset($to_date))
{
$where.=sprintf(" and insdate < (DATE('%s') + INTERVAL 1 DAY) ",$to_date);
}
$where.=$iswed=="O"?" and we>0 and pm='' ":""; 
$sql=sprintf("select * from attendance where 1=1 %s order by insdate;",$where);
$query=$connect->query($sql);
$json=array();
while($list=$query->fetch_assoc()){
array_push($json,$list);
}
echo json_encode($json);
?>