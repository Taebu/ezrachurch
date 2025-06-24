<?php
include_once $_SERVER['DOCUMENT_ROOT']."/db_con.php";
extract($_GET);
$json = array();
$json['success']= false;
$json['query'] = "";
function make_query($table,$query,$type="insert",$where=array())
{
	global $db;
	global $json;
	$sql=array();
	$wheres=array();
	$wheres[]=" where 1=1 ";

	if($type=="insert")
	{
		$pre_text=sprintf("INSERT INTO `%s` SET ",$table);	
	}else if($type=="update"){
		$pre_text=sprintf("UPDATE `%s` SET ",$table);	
	}
	foreach($query as $key=>$value)
	{
		if($value==="now()")
		{
			$sql[]=sprintf("`%s`=now()",$key);
		}else{
			$sql[]=sprintf("`%s`='%s' ",$key,$value);
//			echo $key. " = > ".$value;
		}
	}

	if($type=="update")
	{
		foreach($where as $key=>$value)
		{
			$wheres[]=sprintf(" `%s`='%s' ",$key,$value);
		}
	}

	if($type=="insert"||$type=="update")
	{
	$sql[0]=$pre_text." ".$sql[0];
	}

	if($type=="update")
	{
		$return_value=join(",",$sql).join(" and ",$wheres);	
	}else{
		$return_value=join(",",$sql);
	}
	$json['query']=$return_value;
	return $db->query($return_value);
}



$_POST['at_datetime']="now()";
if(isset($_POST['at_status'])&&$_POST['at_status']=="reception")
{
	$result=make_query("account_takeover",$_POST);
	$json['success']= $result;
}else if(isset($_POST['at_no'])){
	$json['success']=true;
	$where=array('at_no'=>$_POST['at_no']);
	$query = array('at_status'=>'accept');
	make_query("account_takeover",$query,"update",$where);

}
echo json_encode($json);
