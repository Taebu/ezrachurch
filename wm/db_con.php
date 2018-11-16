<?php
$host_name="localhost";

$db_name="bible";
$user_name="cashq";
$db_password="cashq9495";

$host_name="localhost";
$user_name="root";
$db_name="ezrachurch";
$db_password="";
//$connect=mysql_connect($host_name, $user_name, $db_password);
$mysqli = new mysqli($host_name, $user_name, $db_password, $db_name);


$mysqli->select_db("bible");
//mysql_query("set names utf8;") ;
$mysqli->query("set names utf8;");
extract($_REQUEST);
$ROOT = $_SERVER['DOCUMENT_ROOT'];
//header("Content-Type:text/html;charset=utf-8");

?>