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
extract($_GET);
$sql=array();
$eh_content=${"eh_content_".$eh_id};
$eh_position=${"eh_position_".$eh_id};
$eh_name=${"eh_name_".$eh_id};

if($mode=="insert")
{
$sql[]="insert into ezra_helper SET ";
}else if($mode=="update"){
$sql[]="update ezra_helper SET ";
}
$sql[]="eh_datetime=now(),";
$sql[]="eh_content='$eh_content', ";
$sql[]="eh_position='$eh_position', ";
$sql[]="eh_name='$eh_name' ";
if($mode=="update"){
$sql[]="where eh_id='$eh_id';";
}

if($mode=="delete"){
$sql=array();
$sql[]="update ezra_helper set eh_status='D' ";
$sql[]="where eh_id='$eh_id';";
}
$query=mysql_query(join("",$sql));
$json['success']=$query;
$json['sql']=join("",$sql);

echo json_encode($json);
?>