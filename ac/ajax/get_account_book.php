<?php
include_once "../db_con.php";
include_once "../subject.php";
$json = array();
$json['in_form']=array();
$json['out_form']=array();
$page_yn=isset($page_yn)?$page_yn:"N";
$listsize=10;
$pagesize=10;
$limit="";
switch ($quater) {
    case 1:
		$last_year = date("Y",strtotime(sprintf("%s -1 year",$year)));
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
$start_date=isset($start_date)?$start_date:"";
$end_date=isset($end_date)?$end_date:"";


$in_total=0;
$in_next=0;
$out_total=0;



$sql=sprintf("select ab_amount,ab_contents from account_book where ab_type='In' and ab_class='%s'",$ab_class);
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}
$sql.="order by ab_datetime";
$query=$mysqli->query($sql.$limit);
while($list=$query->fetch_assoc()){
	if(strpos($list['ab_contents'], "이월금" )>-1){
		$in_next=$list['ab_amount'];
	}else{
		
		$in_total+=$list['ab_amount'];
		$list['ab_amount']=number_format((int)$list['ab_amount']);
		array_push($json['in_form'],$list);
	}

}


$sql=sprintf("select ab_amount,ab_contents from account_book where ab_type='Out' and ab_class='%s'",$ab_class);
if($quater!=""){
$sql.=sprintf(" and ab_date>='%s' and ab_date<='%s' ",$start_date,$end_date);
}


$query=$mysqli->query($sql);
while($list=$query->fetch_assoc()){
$out_total+=$list['ab_amount'];
	$list['ab_amount']=number_format((int)$list['ab_amount']);
array_push($json['out_form'],$list);
}

$json['in_total']=$in_total;
$json['in_next']=$in_next;
$json['in_final_total']=$in_total+$in_next;
$json['out_total']=$out_total;
$json['out_charge']=$json['in_final_total']-$out_total;
$json['out_final_total']=$out_total+$json['out_charge'];

echo json_encode($json);