<?php

$host_name="localhost";
$user_name="root";
$db_name="ezrachurch";
$db_password="";
// mysqli
$connect = new mysqli($host_name, $user_name, $db_password, $db_name);
//$result = $connect->query("SELECT 'Hello, dear MySQL user!' AS _message FROM DUAL");
//$row = $result->fetch_assoc();
//echo htmlentities($row['_message']);


/* change character set to utf8 */
//$connect=@mysql_connect($host_name, $user_name, $db_password) or die("DB connection failed because: " . @mysql_error()); 
//@mysql_select_db($db_name, $connect);
//@mysql_query("set names utf8;") ;

extract($_REQUEST);
extract($_POST);
extract($_GET);
$ROOT = $_SERVER['DOCUMENT_ROOT'];
?>