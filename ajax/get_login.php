<?
$mysql_host = 'localhost';
$mysql_user = 'ezrachurch';
$mysql_password = '0837ezra';
$mysql_db = 'ezrachurch';
$connect=mysql_connect($mysql_host, $mysql_user, $mysql_password);
mysql_select_db($mysql_db, $connect);
mysql_query("set names utf8;") ;
extract($_REQUEST);
extract($_GET);
$sql="select * from g4_member where mb_id='{$mb_id}';";
$row=mysql_fetch_assoc(mysql_query($sql));
print_r($row);
?>