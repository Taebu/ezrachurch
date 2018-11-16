<?
$mysql_host = 'localhost';
$mysql_user = 'ezrachurch';
$mysql_password = '0837ezra';
$mysql_db = 'ezrachurch';
$connect=mysql_connect($mysql_host, $mysql_user, $mysql_password);
mysql_select_db($mysql_db, $connect);
mysql_query("set names utf8;") ;
extract($_GET);
extract($_POST);
$i=1;
foreach($sort_arr as $v){
$sql="update ezra_helper set eh_order='$i' where eh_id='$v';";
mysql_query($sql);
$i++;
}
$json['sql']=$sql;
echo json_encode($json);
?>