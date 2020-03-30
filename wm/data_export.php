<?php
include_once "./db_con.php";
include_once "./subject.php";
$sql="select * from bible.westminster_chapter;";
$query = $mysqli->query($sql);
$chapter = [];
$chapter_eng = [];
while($list=$query->fetch_assoc())
{
	$chapter[$list['wc_chapter']] = $list['wc_subject']; 
	$chapter_eng[$list['wc_chapter']] = $list['wc_subject_eng']; 
}

$sql="select * from bible.westminster_confession  order by wm_order;";
$query = $mysqli->query($sql);
while($list=$query->fetch_assoc())
{
	
	$c = $list['wm_chapter'];
	$subject = $chapter[$c];
	$subject_eng = $chapter_eng[$c];
if($list['wm_clause']=="1")
{
 printf("%s장 %s (%s)",$c,$subject ,$subject_eng ,$list['wm_clause']); }
echo "<br>";
printf("%s항 ",$list['wm_clause']);
echo "<br>";
echo nl2br($list['wm_content']); 
$wm_relparse= explode("\r\n",$list['wm_relparse']);
echo "<br>";
$relparse=$wm_relparse[0];
echo $relparse;
/*
$array_relparse=explode(".",$relparse);
foreach($array_relparse as $ar)
{
	if($ar=="")
	{
		
	}else{
		echo $ar;echo ".";	
	}
	echo "<br>";
}
*/
echo "<br>";echo "<br>";
}