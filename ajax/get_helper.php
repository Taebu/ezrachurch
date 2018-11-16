<?
$mysql_host = 'localhost';
$mysql_user = 'ezrachurch';
$mysql_password = '0837ezra';
$mysql_db = 'ezrachurch';
$connect=mysql_connect($mysql_host, $mysql_user, $mysql_password);
mysql_select_db($mysql_db, $connect);
mysql_query("set names utf8;") ;
extract($_REQUEST);
$sql="select * from ezra_helper where eh_status='I' order by eh_order ";
$query=mysql_query($sql);
$json['posts']=array();
while($list=mysql_fetch_assoc($query))
{	
		$list['eh_contents']=$list['eh_content'];
	$list['eh_content']=nl2br($list['eh_content']);

	array_push($json['posts'],$list);
}
echo json_encode($json);
?>
