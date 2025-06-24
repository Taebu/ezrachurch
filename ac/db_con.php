<?php

$host_name="localhost";
$user_name="root";
$db_name="newezra";
$db_password="";
$mysqli = new mysqli($host_name, $user_name, $db_password, $db_name);
$db = new PDO('mysql:host='.$host_name.';dbname=bible;charset=utf8mb4', $user_name, '');

// $mysqli->select_db("bible");
//mysql_query("set names utf8;") ;
$mysqli->query("set names utf8;");
extract($_REQUEST);
extract($_GET);

$ROOT = $_SERVER['DOCUMENT_ROOT'];
//header("Content-Type:text/html;charset=utf-8");

?>