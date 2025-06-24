<?php
$host_name="localhost";

$db_name="bible";
$user_name="cashq";
$db_password="cashq9495";

$host_name="localhost";
$user_name="root";
$db_name="newezra";
$db_password="";
//$connect=mysql_connect($host_name, $user_name, $db_password);
$mysqli = new mysqli($host_name, $user_name, $db_password, $db_name);
$db = new PDO('mysql:host='.$host_name.';dbname=bible;charset=utf8mb4', $user_name, '');

$mysqli->select_db("bible");
//mysql_query("set names utf8;") ;
$mysqli->query("set names utf8;");
extract($_REQUEST);
$ROOT = $_SERVER['DOCUMENT_ROOT'];
//header("Content-Type:text/html;charset=utf-8");
$arrow_ip = array();
$arrow_ip[] = "14.5.85.81";
$arrow_ip[] = "218.154.47.11";
$arrow_ip[] = "172.30.1.23";
$arrow_ip[] = "172.30.1.254";
$is_block_ip = false;
if(!in_array($_SERVER['REMOTE_ADDR'],$arrow_ip))
{
	$is_block_ip = true;
}
?>