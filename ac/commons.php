<?php
global $is_executive;
global $executive;
global $is_multiple;
global $account_users;
global $array_multiple_class;

$is_executive = false;
$is_multiple = false;
$executive = array();
$account_users = array();
$array_multiple_class = array();
function get_executive($ss_mb_id)
{
   global $executive;
   $is_executive = false;
   $sql = sprintf("select * from account_user where au_id = '%s' ",$ss_mb_id);
   $executive = sql_fetch($sql);
   if($executive['au_id']==$ss_mb_id)
   {
	   $is_executive = true;
   }
   return $is_executive;
}

function is_multiple($ss_mb_id)
{	
	global $is_multiple;
	global $account_users;
	global $array_multiple_class;
	$i = 0;
	$sql = sprintf("select * from account_user where au_id = '%s' ",$ss_mb_id);
	$result = sql_query($sql);
	while ($list = sql_fetch_array($result))
	{
		array_push($account_users,$list);

		$array_multiple_class[]=$list['ab_class'];
		$i++;
	}
	return $i>1;
}

if ($_SESSION['ss_mb_id'])
{
    $is_executive = get_executive($_SESSION['ss_mb_id']);
	$is_multiple = is_multiple($_SESSION['ss_mb_id']);
}

if (!$is_executive)
    alert('임원만 이용하실 수 있습니다.', "/wp/");