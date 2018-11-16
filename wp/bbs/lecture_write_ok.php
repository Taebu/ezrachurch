<?php
include_once("../common.php");
//print_r($member);
//print_r($_POST);
//echo json_encode($_POST);
$sql=array();
$json=array();
if($mode=="test")
{
	$add_person=array();
	//print_r($_POST);	
	for($i=0;$i<count($add_name);$i++)
	{
		$add_person[]=sprintf("add_name=%s|add_birth=%s|add_sex=%s",$add_name[$i],$add_birth[$i],$add_sex[$i]);	
	}
	echo join("&",$add_person);
}

if($mode=="write")
{
	$add_person=array();
	//print_r($_POST);	
	for($i=0;$i<count($add_name);$i++)
	{
		$add_person[]=sprintf("add_name=%s|add_birth=%s|add_sex=%s",$add_name[$i],$add_birth[$i],$add_sex[$i]);	
	}
	$str_person=join("&",$add_person);

	$mb_zip1        = isset($_POST['mb_zip'])           ? substr(trim($_POST['mb_zip']), 0, 3) : "";
	$mb_zip2        = isset($_POST['mb_zip'])           ? substr(trim($_POST['mb_zip']), 3)    : "";
	$el_ip=$member['mb_login_ip'];


	$sql[]="INSERT INTO ez_lecture SET ";
	
	if($mb_id!="anonymous")
	{
		$sql[]="mb_id='{$mb_id}',";
	}
	$sql[]="em_no='{$em_no}',";
	$sql[]="em_lecture_no='{$em_lecture_no}',";
	$sql[]="el_sex='{$el_sex}',";
	$sql[]="el_email='{$el_email}',";
	$sql[]="el_name='{$el_name}',";
	$sql[]="el_birth='{$el_birth}',";
	$sql[]="el_stdt='{$el_stdt}',";
	$sql[]="el_eddt='{$el_eddt}',";
	$sql[]="mb_zip1='{$mb_zip1}',";
	$sql[]="mb_zip2='{$mb_zip2}',";
	$sql[]="mb_addr1='{$mb_addr1}',";
	$sql[]="mb_addr2='{$mb_addr2}',";
	$sql[]="mb_addr3='{$mb_addr3}',";
	$sql[]="mb_addr_jibeon='{$mb_addr_jibeon}',";
	$sql[]="el_tel='{$el_tel}',";
	$sql[]="el_hp='{$el_hp}',";
	$sql[]="el_church='{$el_church}',";
	$sql[]="el_group='{$el_group}',";
	$sql[]="el_position='{$el_position}',";
	$sql[]="el_job='{$el_job}',";
	$sql[]="el_ip='{$el_ip}',";
	$sql[]="el_marriedyn='{$el_marriedyn}',";
	$sql[]="el_count='{$el_count}',";
	$sql[]="el_total='{$el_total}',";
	$sql[]="el_comment='{$el_comment}',";
	$sql[]="el_status='ap',";
	$sql[]=sprintf("el_addperson='%s',",$str_person);
	$sql[]="el_datetime=now();";
	
	$query=join($sql,"");
	$json['query']=$query;
	$result=sql_query($query);

	$el_comment=$str_addperson;
	$json['result']=$result;
	
	if($mb_id!="anonymous")
	{
		$sql=array();

		$sql[]="UPDATE g5_member SET ";
		$sql[]="em_no='{$em_no}',";
		$sql[]="em_lecture_no='{$em_lecture_no}',";
		$sql[]="el_sex='{$el_sex}',";
		$sql[]="el_email='{$el_email}',";
		$sql[]="el_name='{$el_name}',";
		$sql[]="el_birth='{$el_birth}',";
		$sql[]="el_stdt='{$el_stdt}',";
		$sql[]="el_eddt='{$el_eddt}',";
		$sql[]="mb_addr_jibeon='{$mb_addr_jibeon}',";
		$sql[]="el_tel='{$el_tel}',";
		$sql[]="el_hp='{$el_hp}',";
		$sql[]="el_church='{$el_church}',";
		$sql[]="el_group='{$el_group}',";
		$sql[]="el_position='{$el_position}',";
		$sql[]="el_job='{$el_job}',";
		$sql[]="el_ip='{$el_ip}',";
		$sql[]="el_marriedyn='{$el_marriedyn}',";
		$sql[]="el_count='{$el_count}',";
		$sql[]="el_total='{$el_total}',";
		$sql[]="el_comment='{$el_comment}',";
		$sql[]="el_status='ap',";
		$sql[]="el_datetime=now();";

		$sql[]="where mb_id='{$mb_id}';";
		
		$query=join($sql,"");

	}
//$json['query']=$query;
	//$result=sql_query($query);


	echo json_encode($json);
}
?>