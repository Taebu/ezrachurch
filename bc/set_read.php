<?php
include "../db_con.php";
$TABLES=$_POST;
$sql=sprintf("select * from ez_bible where mb_id='%s' and eb_count='%s' limit 1;",$TABLES['mb_id'],$TABLES['eb_count']);
$query=$db->query($sql);
$images=$query->fetch_assoc();
echo $sql;
if(count($images))
{
	if(isset($TABLES['eb_type'])&&$TABLES['eb_type']=="end")
	{
		$TABLES=array_diff_key($TABLES, array('eb_type' => ""));
		$sql=sprintf("update `%s` SET ",'ez_bible');
		$sqls=array();
		foreach($TABLES as $key =>$value)
		{
			$sqls[]=sprintf("`%s`='%s' ",$key,addslashes($value));
			
		}

		$sqls[]="`eb_end_datetime`=now() ";

		$sql.=join(",",$sqls);
		$sql.=sprintf(" where eb_no='%s';",$TABLES['eb_no']);
		$query=$db->query($sql);
		echo $sql;
		echo "<br>";
		$sqls=array();
		$sql=sprintf("insert into `%s` SET ",'ez_bible');
		$sqls[]=sprintf("`%s`='' ",'eb_data');
		$sqls[]=sprintf("`%s`='%s' ",'mb_id',$TABLES['mb_id']);
		$sqls[]=sprintf("`%s`='%s' ",'eb_count',(int)$images['eb_count']+1);
		$sqls[]="`eb_create_datetime`=now() ";

		$sql.=join(",",$sqls);
		$sql.=";";
		$query=$db->query($sql);
		echo $sql;
	}else{
		$sql=sprintf("update `%s` SET ",'ez_bible');
		$sqls=array();
		foreach($TABLES as $key =>$value)
		{
			$sqls[]=sprintf("`%s`='%s' ",$key,addslashes($value));
		}

		$sqls[]="`eb_modify_datetime`=now() ";

		$sql.=join(",",$sqls);
		$sql.=sprintf(" where mb_id='%s' and eb_no='%s';",$TABLES['mb_id'],$TABLES['eb_no']);
		$query=$db->query($sql);
	}
}else{
	
$sql=sprintf("insert into `%s` SET ",'ez_bible');
$sqls=array();
foreach($TABLES as $key =>$value)
{
	$sqls[]=sprintf("`%s`='%s' ",$key,addslashes($value));
}

$sqls[]="`eb_create_datetime`=now() ";

$sql.=join(",",$sqls);
$sql.=";";
$query=$db->query($sql);

}