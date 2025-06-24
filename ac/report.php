<?php
include_once "./db_con.php";
include_once "./subject.php";
$ab_class=isset($ab_class)?$ab_class:"";
$quater=isset($quater)?$quater:"";
$year=isset($year)?$year:"2023";
$sign_yn=isset($sign_yn)?$sign_yn:"";
$page_yn=isset($page_yn)?$page_yn:"N";
$limit="";
switch ($quater) {
    case 1:
		$last_year = date("Y",strtotime(sprintf("%s-01-01 -1 year",$year)));
		$start_date=date("Y-m-d",strtotime($ac_config['ac_1quarter_start']));
		$end_date=date("Y-m-d",strtotime($ac_config['ac_1quarter_end']));
        break;
    case 2:
		$start_date=date("Y-m-d",strtotime($ac_config['ac_2quarter_start']));
		$end_date=date("Y-m-d",strtotime($ac_config['ac_2quarter_end']));
        break;
    case 3:
		$start_date=date("Y-m-d",strtotime($ac_config['ac_3quarter_start']));
		$end_date=date("Y-m-d",strtotime($ac_config['ac_3quarter_end']));
		break;
    case 4:
		$start_date=date("Y-m-d",strtotime($ac_config['ac_4quarter_start']));
		$end_date=date("Y-m-d",strtotime($ac_config['ac_4quarter_end']));
        break;

}
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
h1,td{font-family: 'Godo';}
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
<h1><?php echo $year;?>년 <?php echo $SUBJECT['ko'][$ab_class];?> <?php echo $quater;?>분기 <?php echo $ab_class=="moderator"?"항목별 명세서":"회계보고";?>
<?php
//echo $start_date;
//echo " ~ ";
//echo $end_date;

?>
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


$sql=sprintf("select sum(ab_amount) as sum_amount from account_book where ab_type='In' and ab_class='%s' and ab_contents not in ('일반헌금','절기헌금','기타') ",$ab_class);
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}
$in_total=0;
$query=$mysqli->query($sql);
$sum=$query->fetch_assoc();
$in_total=$sum['sum_amount'];


$sql=sprintf("select * from account_book where ab_type='In' and ab_class='%s'",$ab_class);
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}

$sql.="order by ab_date";
//print $sql;
if($page_yn=="Y"){
$limit=sprintf(" limit %s,%s;",$firstNum,$listsize);
}
$query=$mysqli->query($sql.$limit);
echo "<form name='in_form'>";
printf('<input type="hidden" name="ab_class" value="%s">',$ab_class);
printf('<input type="hidden" name="year"     value="%s">',$year);
printf('<input type="hidden" name="quater"   value="%s">',$quater);
printf('<input type="hidden" name="sign_yn"  value="%s">',$sign_yn);
printf('<input type="hidden" name="page"     value="%s">',$page);
printf('<input type="hidden" name="page2"     value="%s">',$page2);
echo "<table class=\"reference\" style='width:48%;float:left;margin-right: 15px;' >";
echo "<colgroup>";
//echo "<col width='15%'>";
echo "<col width='15%'>";
echo "<col width='70%'>";
echo "</colgroup>";
echo "<tr>";
//echo "<th>ab_date</th>";
echo "<th>수입액</th>";
echo "<th>수입목록</th>";
echo "</tr>";
$in_next=0;
while($list=$query->fetch_assoc())
{
//printf('<td>%s</td>',date("m-d",strtotime($list['ab_date'])));
	if(strpos($list['ab_contents'], "이월금" )>-1){
		$in_next=$list['ab_amount'];
	}else{
		print "<tr>";
			printf('<td>%s</td>',number_format($list['ab_amount']));		
			if($ab_class=="ezratv"||$ab_class=="building"){
//				printf('<td>%s</td>',iconv_substr($list['ab_contents'],0,1,"utf-8")."무기명");
				printf('<td>%s</td>',"무기명");
			}else{
				printf('<td>%s</td>',$list['ab_contents']);	
			}
		print "</tr>";	
	}
}
if($cnt>10&&$page_yn=="Y"){
print "<tr style='background: white;border-bottom: 0px;'>";
print('<td colspan=3 style="border-bottom: 0;">');
echo paging($page,$cnt,'in_form');
print('</td>');
print "</tr>";
}
echo "</table>";
echo "</form>";

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
$sql.="order by ab_date";
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
echo "<table class=\"reference\" style='width:48%;float:left'>";
echo "<colgroup>";
//echo "<col width='15%'>";
echo "<col width='15%'>";
echo "<col width='70%'>";
echo "</colgroup>";
echo "<tr>";

//echo "<th>ab_date</th>";
echo "<th>지출액</th>";
echo "<th>지출목록</th>";
echo "</tr>";
$query=$mysqli->query($sql.$limit);
while($list=$query->fetch_assoc()){

print "<tr>";
//printf('<td>%s</td>',date("m-d",strtotime($list['ab_date'])));
printf('<td>%s</td>',number_format($list['ab_amount']));
if($ab_class=="moderator"){
	printf('<td>%s %s</td>',$list['ab_etc'],$list['ab_contents']);
}else {
	printf('<td>%s</td>',$list['ab_contents']);
}
print "</tr>";
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
if(true)
{
	$next_month_amount = $in_next;
	$in_totals=$in_total+$next_month_amount;
	$out_charge=$in_totals-$in_next-$out_total;
	print "<tr>";
	print('<th>수입 합계</th>');
	printf('<td colspan="2">%s</td>',number_format($in_total-$in_next));
	print('<th>지출 합계</th>');
	printf('<td colspan="2">%s</td>',number_format($out_total));
	print "</tr>";
	print "<tr>";
	print('<th>이월금</th>');
	printf('<td colspan="2">%s</td>',number_format($next_month_amount));
	print('<th>차인 금액</th>');
	printf('<td colspan="2">%s</td>',number_format($out_charge));
	print "</tr>";
	print "<tr>";
	print('<th>합계</th>');
	printf('<td colspan="2">%s</td>',number_format($in_total));
	print('<th>합계</th>');
	printf('<td colspan="2">%s</td>',number_format($out_total+$out_charge));
	print "</tr>";
}else {
print "<tr>";
print('<td>수입 합계</td>');
printf('<td>%s</td>',number_format($in_total));
print('<td>지출 합계</td>');
printf('<td>%s</td>',number_format($out_total));
print('<td>잔액</td>');
printf('<td>%s</td>',number_format($in_total-$out_total));
print "</tr>";

}

if($sign_yn=="Y")
{
$sql=sprintf("select * from account_user where ab_class='%s'",$ab_class);

$query=$mysqli->query($sql);
$account_user=$query->fetch_assoc();

if(isset($account_user))
{
print('<td>은행이름</td>');
printf('<td>%s</td>',$account_user['au_bankname']);
print('<td>계좌번호</td>');
printf('<td>%s</td>',$account_user['au_bankno']);
print('<td>입금자명</td>');
printf('<td>%s</td>',$account_user['au_holder']);
print "</tr>";
}else{
print('<td colspan="6" style="text-align:center">계좌 정보가 없습니다.<button onclick="location.href=\'bank_modify.php\'">계좌 정보 수정</button></td>');
print "</tr>";
}
print "<tr>";
print "<td colspan='6' style='background-color:white;border-bottom:0'>";
print "<table class=\"reference\" style='width:70%;float:right;border:1px solid #ccc'>";
echo "<colgroup>";
echo "<col width='12%'>";
echo "<col width='22%'>";
echo "<col width='22%'>";
echo "<col width='22%'>";
echo "<col width='22%'>";
echo "</colgroup>";
print "	<tr>";
print "		<th rowspan='2'>결제</th>";
print "		<th>팀장</th>";
print "		<th>담당</th>";
print "		<th>담임</th>";
print "		<th>재정집행부</th>";
print "	</tr>";
print "	<tr style='height: 100px;'>";
print "		<td style='border:1px solid #ccc'></td>";
print "		<td style='border:1px solid #ccc'></td>";
print "		<td style='border:1px solid #ccc'></td>";
print "		<td style='border:1px solid #ccc'></td>";
print "	</tr>";
print "</table>";
print "</td>";
print "</tr>";
}
echo "</table>";



//echo "<input type='button' value='list' onclick=\"location.href='./list.php'\">";