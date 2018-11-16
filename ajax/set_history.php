<?
$mysql_host = 'localhost';
$mysql_user = 'ezrachurch';
$mysql_password = '0837ezra';
$mysql_db = 'ezrachurch';
$connect=mysql_connect($mysql_host, $mysql_user, $mysql_password);
mysql_select_db($mysql_db, $connect);
mysql_query("set names utf8;") ;
extract($_REQUEST);
extract($_POST);
$sql=array();
if($mode=="insert")
{
$sql[]="insert into ezra_history SET ";
}else if($mode=="update"){
$sql[]="update ezra_history SET ";
}
$sql[]="eh_datetime='$eh_datetime',";
$sql[]="eh_content='$eh_content' ";
if($mode=="update"){
$sql[]="where eh_id='$eh_id';";
}

if($mode=="delete"){
$sql=array();
$sql[]="delete from ezra_history ";
$sql[]="where eh_id='$eh_id';";
}
$query=mysql_query(join("",$sql));
$json['success']=$query;
$json['sql']=join("",$sql);

echo json_encode($json);
?>