<?php
function get_pre($wm_no)
{
	global $mysqli;
	$sql=sprintf("select * from `westminster_confession` where wm_no<'%s' order by wm_no desc limit 1;",$wm_no);
	$query=$mysqli->query($sql);
	$pre=$query->fetch_assoc();
	return $pre;
}

function get_ord($wm_no)
{
	global $mysqli;
	$sql=sprintf("select * from `westminster_confession` where wm_no>'%s' limit 1;",$wm_no);
	$query=$mysqli->query($sql);
	$ord=$query->fetch_assoc();
	return $ord;
}
