<?php
include_once "./db_con.php";
include_once "./subject.php";
$sql="SELECT * FROM westminster_confession order by wm_order,wm_clause limit 1;";
$sql="SELECT *,REGEXP_REPLACE(wm_content, '([0-9]+\\))', '<sup>\\1</sup>') as wm_content FROM westminster_confession order by wm_order,wm_clause;";
$sql="SELECT 
*,
REGEXP_REPLACE(wm_content, '([0-9]+\\\\))', '<sup>\\\\1</sup>')  wm_content,
REGEXP_REPLACE(wm_commentary, '(제([0-9]+)장([0-9ㄱ-힣\\\\- ]+)교훈)', '<h3>\\\\1</h3>')  wm_commentary 
FROM westminster_confession order by wm_order,wm_clause;";



$query=$db->query($sql);
echo "<pre>";
$temp_chapter=0;

while($list=$query->fetch(PDO::FETCH_ASSOC))
{

	if($temp_chapter!=$list['wm_chapter'])
	{
		echo "<h1>"."제".$list['wm_chapter']."장 : ".$SUBJECT['ko']["제".$list['wm_chapter']."장"]." ";
		echo "(".$SUBJECT['en']["제".$list['wm_chapter']."장"].")</h1>";

	}
	$temp_chapter=$list['wm_chapter'];
    echo "<h2>".$list['wm_clause']."항";
    echo " : ".$list['wm_subject']."</h2>";
    echo "<p>".$list['wm_content']."</p>";
    echo "<p>".$list['wm_relparse']."</p>";
//    echo "<p>".$list['wm_content_eng']."</p>";
	if(strlen($list['wm_commentary'])>0)
	{
//    printf("<h3>%s장 %s항 교훈</h3>",$list['wm_chapter'],$list['wm_clause']);
	echo "<p>".$list['wm_commentary']."</p>";
//  echo "<p>".$list['wm_commentary_eng']."</p>";
	}
//    echo "<p>".$list['wm_relparse_eng']."</p>";
//    echo "<p>".$list['wm_commentary_eng']."</p>";
}