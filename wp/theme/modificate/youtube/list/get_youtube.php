<?php
$type="";
$q="";
extract($_GET);
//$pr_list=$_GET['pr_list'];
if($pr_list=="lecture_01")
{
	$uploads_id= "PLJTXCswf-ZIGU9-4pkIUl8SNEMXDetly7"; 
}else if($pr_list=="lecture_02") {
	$uploads_id = "PLJTXCswf-ZIFGB2K5dPktB3XChaS4VYxm";
}else if($pr_list=="edu_01"){
	$uploads_id = "PLJTXCswf-ZIF4uip8EAPCMAJJAUOCf4Rs";
}else if($pr_list == "edu_02"){
	$uploads_id = "PLJTXCswf-ZIEAyigLQ8syQIRJV8VCsjtY";
}else if($pr_list== "edu_03") {
	$uploads_id = "PLJTXCswf-ZIFe7hgsjR1PHltN8rKHnsBW"; 
}
//echo $uploads_id;

if($uploads_id==""){
	echo "올바른 경로를 사용해 주세요.";

}else{
	if($type=="search"){
		$t=$nextPageToken;
		echo get_search_youtube($t,$uploads_id,$q);
	}else{
		$t=$nextPageToken;
		echo get_youtube($t,'4',$uploads_id,$q);		
	}

}
function get_youtube($t,$max = 4,$ui,$q="")
{
	$maxResults = 4;
	$API_key = 'AIzaSyCqAjZBq3TXvDIjgZXTPCh3O8sPChiE9z4';


	$data_url="https://www.googleapis.com/youtube/v3/playlistItems";
	$data_url.="?part=snippet";
	$data_url.="&maxResults=".$max;
	$data_url.="&playlistId=".$ui;
	$data_url.="&q=".$q;
	$data_url.="&key=".$API_key."";
	
	if(isset($t)){
	$data_url.="&pageToken=".$t."";
	}

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$data_url);
  curl_setopt($ch, CURLOPT_POST,false);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result=curl_exec ($ch);
  curl_close ($ch);
  return $result;
}

function get_search_youtube($t,$ui,$q)
{
	//https://www.googleapis.com/youtube/v3/search?key=AIzaSyCqAjZBq3TXvDIjgZXTPCh3O8sPChiE9z4&playlistId=PLJTXCswf-ZIF4uip8EAPCMAJJAUOCf4Rs&part=snippet&channelId=UC2r1rV2lL6zQVSnmkM8dwrg&q=%EC%A0%9C1%EC%9E%A5
	$data_url="https://www.googleapis.com/youtube/v3/search";
	$data_url.="?key=AIzaSyCqAjZBq3TXvDIjgZXTPCh3O8sPChiE9z4";
	$data_url.="&playlistId=".$ui;
	$data_url.="&part=snippet";
	$data_url.="&channelId=UC2r1rV2lL6zQVSnmkM8dwrg";
	$data_url.="&q=".$q;

	if(isset($t)){
	$data_url.="&pageToken=".$t."";
	}
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$data_url);
  curl_setopt($ch, CURLOPT_POST,false);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_close ($ch);
  $result=curl_exec ($ch);
  return $result;
}
	
?>