<?php
include_once "../db_con.php";
$sql="select * from ez_daily order by ed_date desc limit 1";
$query=$db->query($sql);
echo "<table>";
echo "<tr>";
$table_array = array("ed_no","mb_id","ed_author","ed_subject","modify","ed_date");

 while($list=$query->fetch_assoc()){

	foreach($list as $key=>$value)
	{
		if(in_array($key,$table_array))
		printf("<td>%s</td>",$key);
	}
	
 }
echo "</tr>";
$sql="select * from ez_daily order by ed_date desc";
$query=$db->query($sql);
while($list=$query->fetch_assoc()){
echo "<tr>";

	foreach($list as $key=>$value)
	{
		if(in_array($key,$table_array))
		{
			if($key=="ed_subject"){
			printf("<td><a href='./view.php?ed_no=%s'>%s</a></td>",$list['ed_no'],$list[$key]);
			printf("<td><a href='./modify.php?ed_no=%s'>수정</a></td>",$list['ed_no']);
			}
			else
			printf("<td>%s</td>",$list[$key]);
		
		}
	}
	
 echo "</tr>";
 }
 echo "</table>";
?>
<input type="button" onclick="javascript:location.href='./write.php';" value="경건일지 작성">
기록 일시 : 4월 18일 목요일 
성경본문 : 
묵상구절 : 8절, 19절 
기도시간 :
깨달은 점:
삶의 적용:
실천여부 O / X