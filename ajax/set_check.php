<?php
$am=$ru=$pm=$we=$insdate="";
include_once "../db_con.php";

if($mode=="insert"){
	$sql="insert into attendance set insdate='$insdate', am='$am',ru='$ru',pm='$pm',we='$we';";
}else if($mode=="update") {
	# code...
	$sql="update attendance set insdate='$insdate', am='$am',ru='$ru',pm='$pm',we='$we'  where seq='$seq';";
}else if($mode=="del") {
	# code...
	$sql="delete from attendance where seq='$seq';";
} 

$result=$connect->query($sql);

$json['success']=$result;
$json['message']=$result?"s":"f";
$json['insdate']=$insdate;
$json['am']=$am;
$json['ru']=$ru;
$json['pm']=$pm;
$json['we']=$we;
$json['seq']=($mode=="insert")?$connect->insert_id:$seq;
$json['sql']=$sql;
echo json_encode($json);

/*
echo "user_name : ".$user_name;
$sql="select * from attendance";
$query=mysql_query($sql);

while($list=mysql_fetch_assoc($query)){
print_r($list);
}
*/
?>