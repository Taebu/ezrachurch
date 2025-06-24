<?php
include_once "./db_con.php";
include_once "./subject.php";
$ab_class=isset($ab_class)?$ab_class:"";
$quater=isset($quater)?$quater:"1";
$sign_yn=isset($sign_yn)?$sign_yn:"";
$year=isset($year)?$year:"2024";
$page_yn=isset($page_yn)?$page_yn:"N";
$limit="";
function get_range_date($quarter)
{
	global $start_date;
	global $end_date;
	global $year;
	global $ac_config;
switch ($quarter) {
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
}

get_range_date($quater);
$start_date=isset($start_date)?$start_date:"";
$end_date=isset($end_date)?$end_date:"";
if($ab_class=="")
{
	print "<script>alert('팀명이 선택되지 않았습니다.');
	location.href='list.php';
	</script>";
}
if($quater=="4")
{
//	$year++;
}
$display_quater=$quater+1;
$display_quater=$display_quater%4;
$display_quater=$display_quater==0?"4":$display_quater;
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

<h1><?php echo $year;?>년  <?php echo $SUBJECT['ko'][$ab_class];?> <?php echo "연간  예산 사용 결과";?></h1>
<?php
$listsize=10;
$pagesize=10;
$page = isset($page)?$page:1;  
$page2 = isset($page2)?$page2:1;  
$firstNum = ($page-1)*$listsize;

$count_sql=sprintf("select count(*) cnt from account_book where ab_type='Budget' and ab_class='%s'  and ab_contents not in ('일반헌금','절기헌금','기타') ",$ab_class);
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

$sql=sprintf("select sum(ab_amount) as sum_amount from account_book where ab_type='Budget' and ab_class='%s'  and ab_contents not in ('일반헌금','절기헌금','기타') ",$ab_class);
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}
$in_total=0;
$query=$mysqli->query($sql);
$sum=$query->fetch_assoc();
$in_total=$sum['sum_amount'];


$settlement = array();
$settlement['1분기'] = array();
$settlement['2분기'] = array();
$settlement['3분기'] = array();
$settlement['4분기'] = array();

$sql=sprintf("select ab_type,sum(ab_amount) as `ab_amount`  from account_book where ab_class='%s'  ",$ab_class);
$sql.=" and ab_contents not in ('일반헌금','절기헌금','기타') ";
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}
$group_by =" GROUP BY `ab_type`;";
$query=$mysqli->query($sql.$limit.$group_by);

while($list=$query->fetch_assoc()){
$settlement['1분기'][$list['ab_type']]=$list['ab_amount'];
}


$sql.="and ab_contents like '%예산%' ";
$sql.="and ab_type like 'In' ";
$query = $mysqli->query($sql.$group_by);
$list=$query->fetch_assoc();
if(isset($list['ab_amount']))
{

$settlement['1분기']['next_budget']=$list['ab_amount'];
}
get_range_date(2);
$sql=sprintf("select ab_type,sum(ab_amount) as `ab_amount`  from account_book where ab_class='%s' ",$ab_class);
$sql.=" and ab_contents not in ('일반헌금','절기헌금','기타') ";
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}
$group_by =" GROUP BY `ab_type`;";
//echo $sql.$limit.$group_by;
$query=$mysqli->query($sql.$limit.$group_by);

while($list=$query->fetch_assoc()){
$settlement['2분기'][$list['ab_type']]=$list['ab_amount'];
}


$sql.="and ab_contents like '%예산%' ";
$sql.="and ab_type like 'In' ";
$query = $mysqli->query($sql.$group_by);
$list=$query->fetch_assoc();
if(isset($list['ab_amount']))
{
$settlement['2분기']['next_budget']=$list['ab_amount'];
}

get_range_date(3);
$sql=sprintf("select ab_type,sum(ab_amount) as `ab_amount`  from account_book where ab_class='%s' ",$ab_class);
$sql.=" and ab_contents not in ('일반헌금','절기헌금','기타') ";
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}
$sql.=" and ab_contents not in ('일반헌금','절기헌금','기타') ";
$group_by =" GROUP BY `ab_type`;";
$query=$mysqli->query($sql.$limit.$group_by);

while($list=$query->fetch_assoc()){
$settlement['3분기'][$list['ab_type']]=$list['ab_amount'];
}

$sql.="and ab_contents like '%예산%' ";
$sql.="and ab_type like 'In' ";
$query = $mysqli->query($sql.$group_by);
$list=$query->fetch_assoc();
if(isset($list['ab_amount']))
{

$settlement['3분기']['next_budget']=$list['ab_amount'];
}
get_range_date(4);
$sql=sprintf("select ab_type,sum(ab_amount) as `ab_amount`  from account_book where ab_class='%s' ",$ab_class);
$sql.=" and ab_contents not in ('일반헌금','절기헌금','기타') ";
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}
$group_by =" GROUP BY `ab_type`;";
$query=$mysqli->query($sql.$limit.$group_by);

while($list=$query->fetch_assoc()){
$settlement['4분기'][$list['ab_type']]=$list['ab_amount'];
}

$sql.=" and ab_contents like '%예산%' ";
$sql.=" and ab_type like 'In' ";
// echo $sql.$group_by;
$query = $mysqli->query($sql.$group_by);
$list=$query->fetch_assoc();
if(isset($list['ab_amount']))
{

$settlement['4분기']['next_budget']=$list['ab_amount'];
}

//echo "<br>";
echo "<table class=\"reference\">";
echo "<tr>";
echo "<th>";
echo "구분";
echo "</th>";
echo "<th>";
echo "수입(원)";
echo "</th>";
echo "<th>";
echo "지출(원) ";
echo "</th>";
echo "<th>";
echo "잔액(원)";
echo "</th>";
echo "</tr>";
$in_total = 0;
$out_total = 0;
$mod = 0;
$mod_total = 0;
$next_budget = 0;
//echo "<pre>";
//print_r($settlement);
//echo "</pre>";
$value_next_buget=0;
foreach ($settlement as $key=>$value){
	//echo $key."=>".$value;
	$value_next_buget=isset($value['next_budget'])?$value['next_budget']:0;
	$next_budget = $next_budget + $value_next_buget;
	echo "<tr>";
	echo "<td>";
	echo $key;
	echo "</td>";
	echo "<td>";
	if(isset($value['In']))
	{
		$in_total = $in_total+$value['In'];
	}

	if(isset($value['In']))
	{
		echo number_format($value['In']);
	}else{
		echo "0";
	}
	if(isset($value['In'])&&isset($value['next_budget']))
	{
	echo "<br>";

	echo "이월금 + 기타수입 : ".number_format($value['In']-$value['next_budget']);
	}else if(isset($value['In'])) {
	echo "<br>";

	echo "이월금 : ".number_format($value['In']);
	}

	if(isset($value['next_budget']))
	{

	echo "<br>";
	echo "예산신청액 : ".number_format($value['next_budget']);
	}else{
	echo "<br>";
	echo "예산신청액 : 0";
		
	}

//	if(isset($value['Expenditure']))
//	{
//	echo "<br>";
//	echo "지출결의 : ".number_format($value['Expenditure']);
//	}

	if($key=="4분기"&&isset($next_budget)&&$next_budget>0)
	{
	echo "<br>";
	echo "연간청구예산 : ".number_format($next_budget);
	}
	echo "</td>";
	echo "<td>";
	if(isset($value['Out']))
	{
	echo number_format($value['Out']);
	$out_total = $out_total+$value['Out'];
	}
	echo "</td>";
	echo "<td>";
	if(isset($value['Out'])&&isset($value['In']))
	{
		$mod = $value['In']-$value['Out'];
		echo number_format($mod);
		$mod_total = $mod_total +$mod;
	}
	echo "</td>";
	echo "</tr>";
}
echo "<tr><td>연간청구 예산·지출</td><td>";
//echo number_format($in_total);
//echo number_format($next_budget);
echo "</td><td>";
echo number_format($out_total);
echo "</td><td>";
//echo number_format($next_budget-$out_total);
echo "</td></tr>";
echo "</table>";
echo "<form name='in_form'>";
printf('<input type="hidden" name="ab_class" value="%s">',$ab_class);
printf('<input type="hidden" name="year"     value="%s">',$year);
printf('<input type="hidden" name="quater"   value="%s">',$quater);
printf('<input type="hidden" name="sign_yn"  value="%s">',$sign_yn);
printf('<input type="hidden" name="page"     value="%s">',$page);
printf('<input type="hidden" name="page2"     value="%s">',$page2);
