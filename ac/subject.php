<?php
$SUBJECT=array();
$year = isset($_GET['year'])?$_GET['year']:date("Y");
$sql = "select * from account_team where at_used_yn='Y';";
$query=$mysqli->query($sql);

while($list=$query->fetch_assoc())
{

$SUBJECT["ko"][$list['at_eng_name']]=$list['at_kor_name'];
}

/*
* paging
@param
$page 현재 선택된 페이지
$cnt 총 리스트 갯수
*/
function paging($page,$cnt,$form_name="out_form"){
$pagesize=10;
$listsize=15;
$lnum2 = ceil($cnt/$listsize);
$fnum = ((int)(($page-1)/$pagesize)*$pagesize)+1;
$lnum = ((int)(($page-1)/$pagesize)*$pagesize)+$pagesize;
$lnum= ( $lnum2 < $lnum)?$lnum2:$lnum;
$id="test";
echo "<div class=\"paginate\">";
if($fnum != "1"){
printf('<a class="pre" href="#%s" onclick="page_move(1,\'%s\');">',$id,$form_name);
echo "<img width=\"56\" height=\"27\" alt=\"처음\" src=\"/common/paginate/btn_page_first.gif\"></a>";
printf('<a class="pre" href="#%s" onclick="page_move(%s,\'%s\');">',$id,(int)(($page-1)/$pagesize)*$pagesize,$form_name);
echo "<img alt=\"이전\" src=\"/common/paginate/btn_page_prev.gif\" width=\"56\" height=\"27\">";
echo "</a>";
}
for($i=$fnum; $i<=$lnum; $i++)
{
	if($page == $i){
		echo "<strong><span>$i</span></strong>";
	}else{
		printf('<a href="#%s"  onclick="page_move(%s,\'%s\');"><span>%s</span></a>',$id,$i,$form_name,$i);
	}
}
if($lnum2 != $lnum){
printf('<a class="next" href="#%s"  onclick="page_move(%s,\'%s\');">',$id,$fnum+$pagesize,$form_name);
echo "<img alt=\"다음\"  src=\"/common/paginate/btn_page_next.gif\" width=\"57\" height=\"27\" >";
echo "</a>";
echo "<a class=\"next\" href=\"#$id\">";
echo "<img width=\"57\" height=\"27\" alt=\"끝\" src=\"/common/paginate/btn_page_end.gif\" onclick=\"page_move($lnum2,'$form_name');\">";
echo"</a>";
}
echo "</div>";
}

/*
* paging
@param
$page 현재 선택된 페이지
$cnt 총 리스트 갯수
*/
function paging2($page,$cnt,$form_name="out_form"){
$pagesize=10;
$listsize=10;
$lnum2 = ceil($cnt/$listsize);
$fnum = ((int)(($page-1)/$pagesize)*$pagesize)+1;
$lnum = ((int)(($page-1)/$pagesize)*$pagesize)+$pagesize;
$lnum= ( $lnum2 < $lnum)?$lnum2:$lnum;
$id="test";
echo "<div class=\"paginate\">";
if($fnum != "1"){
printf('<a class="pre" href="#%s" onclick="page_move2(1,\'%s\');">',$id,$form_name);
echo "<img width=\"56\" height=\"27\" alt=\"처음\" src=\"/common/paginate/btn_page_first.gif\"></a>";
printf('<a class="pre" href="#%s" onclick="page_move2(%s,\'%s\');">',$id,(int)(($page-1)/$pagesize)*$pagesize,$form_name);
echo "<img alt=\"이전\" src=\"/common/paginate/btn_page_prev.gif\" width=\"56\" height=\"27\">";
echo "</a>";
}
for($i=$fnum; $i<=$lnum; $i++)
{
	if($page == $i){
		echo "<strong><span>$i</span></strong>";
	}else{
		printf('<a href="#%s"  onclick="page_move2(%s,\'%s\');"><span>%s</span></a>',$id,$i,$form_name,$i);
	}
}
if($lnum2 != $lnum){
printf('<a class="next" href="#%s"  onclick="page_move2(%s,\'%s\');">',$id,$fnum+$pagesize,$form_name);
echo "<img alt=\"다음\"  src=\"/common/paginate/btn_page_next.gif\" width=\"57\" height=\"27\" >";
echo "</a>";
echo "<a class=\"next\" href=\"#$id\">";
echo "<img width=\"57\" height=\"27\" alt=\"끝\" src=\"/common/paginate/btn_page_end.gif\" onclick=\"page_move2($lnum2,'$form_name');\">";
echo"</a>";
}
echo "</div>";
}

/* 2024-09-13 
회계일 CONFIG
*/

$sql = sprintf("select * from account_config where ac_year='%s';",$year);
$query=$mysqli->query($sql);

$ac_config=$query->fetch_assoc();

