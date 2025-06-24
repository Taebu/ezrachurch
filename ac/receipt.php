<?php
include_once "./db_con.php";
include_once "./subject.php";
$ab_class=isset($ab_class)?$ab_class:"";
$quater=isset($quater)?$quater:"";
$year=isset($year)?$year:"2023";
$sign_yn=isset($sign_yn)?$sign_yn:"";
$page_yn=isset($page_yn)?$page_yn:"N";
//echo $year;
$limit="";
switch ($quater) {
    case 1:
		$last_year = date("Y",strtotime(sprintf("%s-01-01 -1 year",$year)));
		$start_date=date("Y-m-d",strtotime($last_year."-12-09"));
		$end_date=date("Y-m-d",strtotime($year."-03-09"));
        break;
    case 2:
		$start_date=date("Y-m-d",strtotime($year."-03-10"));
		$end_date=date("Y-m-d",strtotime($year."-06-09"));
        break;
    case 3:
		$start_date=date("Y-m-d",strtotime($year."-06-10"));
		$end_date=date("Y-m-d",strtotime($year."-09-08"));
        break;
    case 4:
		$start_date=date("Y-m-d",strtotime($year."-09-09"));
		$end_date=date("Y-m-d",strtotime($year."-12-08"));
        break;
}


//echo $last_year;
$start_date=isset($start_date)?$start_date:"";
$end_date=isset($end_date)?$end_date:"";

if($ab_class=="")
{
	print "<script>alert('팀명이 선택되지 않았습니다.');
	location.href='list.php';
	</script>";
}

?>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="/wm/lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all" />
<link rel="stylesheet" type="text/css" href="/ac/css/main.css" media="all" />
<style>
	html{margin-top: 10px;}
	table.reference.bottom {
    position: absolute;
    bottom: 0;
}
.img_receipt{float: left;width: 48%;
    text-align: center;
    font-size: xx-large;
    font-weight: 900;
	

        position: relative;
        margin-bottom: 60px;
	}
img{    width: -webkit-fill-available;}

.img_label{
	margin-top: 30px;
    margin-bottom: 30px;
    line-height: normal;

        position: absolute;
        bottom: 0;
        background: black;
        color: white;
        padding: 5px;
        margin: 0;
        margin-bottom: -50px;}
</style>
<script>
	
function page_move(num,form_name){
if(form_name=="out_form")
{
  document.out_form.page.value=num;
  document.out_form.submit();
}


if(form_name=="in_form")
{
  document.in_form.page.value=num;
  document.in_form.submit();
}
}


function page_move2(num,form_name){
if(form_name=="out_form")
{
  document.out_form.page2.value=num;
  document.out_form.submit();
}


if(form_name=="in_form")
{
  document.in_form.page2.value=num;
  document.in_form.submit();
}
}
</script>
<h1><?php echo $year;?>년 <?php echo $SUBJECT['ko'][$ab_class];?> <?php echo $quater;?>분기 영수증 모아보기
</h1>
<?php

$listsize=10;
$pagesize=10;
$page = isset($page)?$page:1;  
$page2 = isset($page2)?$page2:1;  
$firstNum = ($page-1)*$listsize;

$count_sql=sprintf("select count(*) cnt from account_book where ab_type='In' and ab_class='%s'",$ab_class);
if($quater!=""){
$count_sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}
$count_query=$mysqli->query($count_sql);
$cnt=$count_query->fetch_assoc();
$cnt = $cnt['cnt'];

$lnum2 = ceil($cnt/$listsize);
$fnum = ((int)(($page-1)/$pagesize)*$pagesize)+1;
$lnum = ((int)(($page-1)/$pagesize)*$pagesize)+$pagesize;

if($lnum2<$lnum)
{
	$lnum= $lnum2;
}


$sql=sprintf("select sum(ab_amount) as sum_amount from account_book where ab_type='In' and ab_class='%s'",$ab_class);
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}
$in_total=0;
$query=$mysqli->query($sql);
$sum=$query->fetch_assoc();
$in_total=$sum['sum_amount'];



$out_total=0;

$firstNum = ($page2-1)*$listsize;

$count_sql=sprintf("select count(*) cnt from account_book where ab_type='Out' and ab_class='%s'",$ab_class);
if($quater!=""){
$count_sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}
$count_query=$mysqli->query($count_sql);
$cnt=$count_query->fetch_assoc();
$cnt = $cnt['cnt'];

$lnum2 = ceil($cnt/$listsize);
$fnum = ((int)(($page-1)/$pagesize)*$pagesize)+1;
$lnum = ((int)(($page-1)/$pagesize)*$pagesize)+$pagesize;

if($lnum2<$lnum)
{
	$lnum= $lnum2;
}


$sql=sprintf("select * from account_book where ab_type='Out' and ab_class='%s'",$ab_class);
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}

if($cnt>10&&$page_yn=="Y"){
$limit=sprintf(" limit %s,%s;",$firstNum,$listsize);
}

$query=$mysqli->query($sql);
while($list=$query->fetch_assoc()){
$out_total+=$list['ab_amount'];
}

echo "<form name='out_form'>";
printf('<input type="hidden" name="ab_class" value="%s">',$ab_class);
printf('<input type="hidden" name="year"     value="%s">',$year);
printf('<input type="hidden" name="quater"   value="%s">',$quater);
printf('<input type="hidden" name="sign_yn"  value="%s">',$sign_yn);
printf('<input type="hidden" name="page"     value="%s">',$page);
printf('<input type="hidden" name="page2"     value="%s">',$page2);

///echo $sql;
$query=$mysqli->query($sql.$limit);
while($list=$query->fetch_assoc()){
if($list['ab_file']>0){
	$sqls=sprintf("select * from account_image_file where ab_no='%s';",$list['ab_no']);
	$querys=$mysqli->query($sqls);
	if($querys->num_rows>0){
	$pages = array();
	while($image_list=$querys->fetch_assoc()){
//		 $srcfile = sprintf("%s/upload/%s/%s/%s_%s/%s",$_SERVER['CONTEXT_DOCUMENT_ROOT'],$image_list['ab_class'],$image_list['bf_date'],$image_list['ab_no'],$image_list['bf_no'],$image_list['bf_file']);
//		 $exif = @exif_read_data($srcfile);
//		 print_r($exif);
	$pages[] = sprintf("<div class='img_receipt'><img src='/upload/%s/%s/%s_%s/%s'><div class='img_label'>%s</div></div>",$image_list['ab_class'],$image_list['bf_date'],$image_list['ab_no'],$image_list['bf_no'],$image_list['bf_file'],$list['ab_contents']);
	}
	echo join("",$pages);
	}
}
}

if($cnt>10&&$page_yn=="Y"){
print "<tr style='background: white;border-bottom: 0px;'>";
print('<td colspan=3 style="border-bottom: 0;">');
echo paging2($page2,$cnt);
print('</td>');
print "</tr>";
}
echo "</table>";
echo "</form>";
echo "<div style='clear:both'></div>";
if($page_yn=="Y"){
print "<table class=\"reference bottom\" style='width:97%;'>";
}else{
print "<table class=\"reference\" style='width:97%;margin-top:25px'>";
}
//if($ab_class=="moderator")
echo "</table>";



//echo "<input type='button' value='list' onclick=\"location.href='./list.php'\">";