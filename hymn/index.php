<?php
include_once "./db_con.php";
$title="";
$contents="";
if(!isset($_GET['nh_number'])){
	print("찬송가 3, 4장을 찾는 경우 아래와 같이 언더스코어(underscore)를 각 장마다 추가하여 검색해 주세요.<br><br>");
	print("여러 장을 찾는 경우 _를 계속 추가 하시면 됩니다.<br>");
	print("아래 링크에서 크로마키 자막 작성법을 참고 하시면 됩니다.<br>");
	print("<a href='https://www.youtube.com/watch?v=dpJ8Q9BMq9M' style='text-decoration-line: none;'>https://www.youtube.com/watch?v=dpJ8Q9BMq9M</a>");
	print("<br>");
	print("<a href='https://ezrachurch.kr/hymn/3_4' style='text-decoration-line: none;'>https://ezrachurch.kr/hymn/3_4</a>");
	echo "<br>";
	include_once("./psalmn.php");
	exit();
}
$explode_number=explode("_",$_GET['nh_number']);
$sql=sprintf("select * from new_hymn where nh_number in (%s) order by field(nh_number,%s)",join(",",$explode_number),join(",",$explode_number));
$query=$mysqli->query($sql);
$titles = array();
echo "<table>";
echo "<tr><td>제목</td><td>작업</td></tr>";
while($list=$query->fetch_assoc()){
	$title=$list['nh_number'].". ".$list['nh_title'];
	$titles[]=$title;
	$contents=$list['nh_contents'];
$array_contents = explode("\n",$contents);

foreach($array_contents  as $key => $value)
{
	if($key%2==0)
	{
		echo "<tr><td>";
		echo $title;
		echo "</td>";
		echo "<td>";
		echo $value;
		echo "";
	}else{
		echo $value;
		echo "</td>";
		echo "</tr>";
	}
	
}

}
echo "</table>";
echo "<title>";
echo join(",",$titles);
echo "</title>";