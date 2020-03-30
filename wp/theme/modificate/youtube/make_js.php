<?php
/*
http://ezrachurch.kr/wp/theme/modificate/youtube/make_js.php?loc_id=lecture_01
http://ezrachurch.kr/wp/theme/modificate/youtube/make_js.php?loc_id=lecture_02
http://ezrachurch.kr/wp/theme/modificate/youtube/make_js.php?loc_id=edu_03
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
$sql[]="select * from newezra.ez_youtubelink ";
$sql[]=sprintf(" where ey_group='%s' ",$loc_id);
if($loc_id=="edu_03"){
$sql[]=" order by ey_title;";
}else{
$sql[]=" order by ey_datetime desc;";
}
$query=sql_query(join("",$sql));

$json['success']=true;
$json['sql']=join("",$sql);
$json_data=array();
while($list=sql_fetch_array($query)){
array_push($json_data, $list);
}

unlink($loc_id.".js");
$myfile = fopen($loc_id.".js", "w") or die("Unable to open file!");
$txt = "var ez_youtube_wm=";
fwrite($myfile, $txt);
//echo $txt;
$txt = json_encode($json_data);
//echo "<pre>";
//print_r($json_data);
//ho $txt2;
//echo $txt;
fwrite($myfile, $txt);
fwrite($myfile,";");
//echo $txt;
fclose($myfile);
$json['message']="불러오기 완료";

echo json_encode($json);