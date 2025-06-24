<?php
/*************************************************
* 웨스터민스터 신앙고백서 구절의 내용을 제이슨으로 가져 옵니다.
*
*
*
* ezrachurch.kr/wm/get_westminster.php
*************************************************/
header("Content-Type:text/html;charset=utf-8");
include_once "./db_con.php";
/* (wc_chapter,wc_subject) */
$sql="select * from bible.westminster_chapter;";
$query = $mysqli->query($sql);
$chapter = [];
$chapter_eng = [];
while($list=$query->fetch_assoc())
{
	$chapter[$list['wc_chapter']] = $list['wc_subject']; 
	$chapter_eng[$list['wc_chapter']] = $list['wc_subject_eng']; 
}

$sql = "SELECT * FROM bible.westminster_confession  order by wm_order;";
$query = $mysqli->query($sql);
$west = [];

				
while($list=$query->fetch_assoc())
{
	$c = $list['wm_chapter'];
	$subject = $chapter[$c];
	$subject_eng = $chapter_eng[$c];
	$west[] = sprintf("%s장 %s (%s) %s항 \n%s",$c,$subject ,$subject_eng ,$list['wm_clause'],$list['wm_content']); 
}

echo json_encode($west);