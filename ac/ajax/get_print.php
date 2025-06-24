<?php
include_once "../db_con.php";
include_once "../subject.php";
$q=isset($q)?$q:"1";
function get_account($q)
{
	global $ac_config;
	$account=get_account_book($q,$ac_config);
	return $account;
}

function get_account_book($q,$ac_config)
{
	$config = $ac_config;
	$account = array();
	$account[$q.'분기']=array();
	$account[$q.'분기'] = get_quarter($q,$config);
	
	echo json_encode($account);
}

function get_quarter($q,$config)
{
	global $mysqli;
	$return_array = array();
	$sql = sprintf("select * from account_book ");
	$sql.= sprintf(" where ab_date>='%s' and ab_date<='%s' ",$config['ac_'.$q.'quarter_start'],$config['ac_'.$q.'quarter_end']);
	$sql.= " order by ab_class asc, ab_type asc;";
	$query = $mysqli->query($sql);
	while($list = $query->fetch_assoc())
	{
		array_push($return_array,$list);
	}
	return $return_array;
}
$year=isset($year)?$year:date("Y");
$account = get_account($q);