<?php
$iswed="";
include_once "../db_con.php";
$where="";
$connect = new mysqli($host_name, $user_name, $db_password, $db_name);
//$result = $connect->query("SELECT 'Hello, dear MySQL user!' AS _message FROM DUAL");
//$row = $result->fetch_assoc();
//echo htmlentities($row['_message']);

$where.=isset($to_date)?" and insdate >= DATE('$fr_date') and insdate < (DATE('$to_date') + INTERVAL 1 DAY) ":"";
$where.=$iswed=="O"?" and we>0 and pm='' ":""; 
$sql="select * from attendance where 1=1 $where order by insdate;";
$query=$connect->query($sql);
$json=array();
while($list=$query->fetch_assoc()){
array_push($json,$list);
}
echo json_encode($json);
?>