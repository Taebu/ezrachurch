<?php
/*
http://ezrachurch.kr/wp/theme/modificate/youtube/make_js.php?loc_id=lecture_01
*/
include_once('./_common.php');
$json=array();
$json['success']=false;
$json['message']="not code";
if(!$loc_id){
	echo json_encode($json);
	return;
}

$sql=array();
$sql[]="select * from ez_youtubelink ";
$sql[]=sprintf(" where ey_group='%s' ",$loc_id);
$sql[]=" order by ey_datetime desc;";
$query=sql_query(join("",$sql));

$json['success']=true;

$json_data=array();
while($list=sql_fetch_array($query)){
$product=array();
array_push($json_data, $list);
}
unlink($loc_id.".js");
$myfile = fopen($loc_id.".js", "w") or die("Unable to open file!");
$txt = "var ez_youtube_wm=";
fwrite($myfile, $txt);
//echo $txt;
$txt = json_encode($json_data);
//echo $txt;
fwrite($myfile, $txt);
$txt=";";
fwrite($myfile, $txt);
//echo $txt;
fclose($myfile);
$json['message']="불러오기 완료";

echo json_encode($json);