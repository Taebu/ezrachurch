<?php
include_once "./db_con.php";
include_once "./subject.php";
$ab_class=isset($ab_class)?$ab_class:"";
$quater=isset($quater)?$quater:"1";
$year=isset($year)?$year:"2025";
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
<h1>2025년 <?php echo $display_quater;?>분기 총예산</h1>
<?php

$total_array= array();
$sql="select ab_class,sum(ab_amount) as sum_amount from account_book where ab_type='Expenditure' ";
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}

//$sql.=" and ab_class not like 'moderator' ";

$sql.=" group by ab_class";
$in_total=0;
$query=$mysqli->query($sql);

while($list=$query->fetch_assoc()){
//	printf("%s (%s)",$SUBJECT['ko'][$list['ab_class']],$list['ab_class']);
	$total_array[$list['ab_class']]['key']=$list['ab_class'];
	$total_array[$list['ab_class']]['Expenditure']=number_format($list['sum_amount']);
//	echo number_format($list['sum_amount']);
//	echo "<br>";
	$in_total+=$list['sum_amount'];
}

	$sql="
	select 
		ab_class,
		sum(ab_amount) as sum_amount 
	from 
		account_book 
	where 
		ab_type='Budget' ";

if($quater!=""){
	$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}
$sql.=" and ab_contents like '%예산%' ";
//$sql.=" and ab_class not like 'moderator' ";
$sql.=" group by ab_class";
$out_total=0;

$query=$mysqli->query($sql);

while($list=$query->fetch_assoc())
{
//	printf("%s (%s)",$SUBJECT['ko'][$list['ab_class']],$list['ab_class']);
	$ab_class=$list['ab_class'];
	$total_array[$ab_class]['Budget']=number_format($list['sum_amount']);
//	echo number_format($list['sum_amount']);
	$out_total+=$list['sum_amount'];
//	echo "<br>";
}

function get_moderator_expenditure($quater)
{
	global $mysqli;
	global $start_date;
	global $end_date;
	$sql="
	select 
		ab_class,
		sum(ab_amount) as sum_amount 
	from 
		account_book 
	where 
		ab_type='In' ";

	if($quater!=""){
		$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
	}
	$sql.=" and ab_class='moderator' ";
	$sql.=" and ab_contents not like '%이월금%' ";
	$sql.=" and ab_contents not in ('일반헌금','절기헌금', '기타') ";
	$out_total=0;
	
	$query=$mysqli->query($sql);
	$row = $list=$query->fetch_assoc();
	return number_format($row['sum_amount']);
}
if(isset($total_array['moderator']['Expenditure']))
{
	$total_array['moderator']['Budget']=get_moderator_expenditure($quater);
//	print_r($total_array['moderator']);
}
$total_arrays=array();
foreach ($total_array as $key => $value) {
	$total_arrays[$key]['Budget']=0;
	$total_arrays[$key]['Expenditure']=0;

	if($key=="moderator")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=0;
	}
	if($key=="mans")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=1;
	}else if($key=="building")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=2;

	}else if($key=="hymn")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=3;
	}else if($key=="worship_band")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=4;
	}else if($key=="media")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=5;

	}else if($key=="facilities")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=6;

	}else if($key=="welfare_mission")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=7;

	}else if($key=="new_family")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=8;

	}else if($key=="womans")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=9;

	}else if($key=="kitchen")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=10;

	}else if($key=="kids")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=11;
	}else if($key=="sunday_school")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=12;
	}else if($key=="youth")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=13;
	}else if($key=="student")
	{
		$total_arrays[$key]=$total_array[$key];
		$total_arrays[$key]['grade']=14;
	}
}
function sortByOrder($a, $b) {
    if ($a['grade'] > $b['grade']) {
        return 1;
    } elseif ($a['grade'] < $b['grade']) {
        return -1;
    }
    return 0;
}

usort($total_arrays, 'sortByOrder');
echo "<table class=\"reference\" >";
echo "<tr><th>부서/팀</th><th>예산</th><th>청구액</th></tr>";
// print_r($total_arrays);
foreach ($total_arrays as $key => $value) {
	echo "<tr>";
    foreach($value as $keys => $values){
		if($keys=="key")
		{
			printf("<td>%s</td>",$SUBJECT['ko'][$values]);
		}else if($keys=="Expenditure"||$keys=="Budget"){
			printf("<td>%s</td>",$values);
		}else if(count($value)==3) {
			printf("<td>%s</td>","0");
		}
    }
	echo "</tr>";
}
//echo str_replace(',', '',$total_array['moderator']['Budget']);
$out_total = $out_total+str_replace(',', '',$total_array['moderator']['Budget']);
printf("<tr><td>합계</td><td>%s</td><td>%s</td></tr>",number_format($in_total),number_format($out_total));
echo "</table>";
