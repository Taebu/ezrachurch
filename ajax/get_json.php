<?
$mysql_host = 'localhost';
$mysql_user = 'ezrachurch';
$mysql_password = '0837ezra';
$mysql_db = 'ezrachurch';
$connect=mysql_connect($mysql_host, $mysql_user, $mysql_password);
mysql_select_db($mysql_db, $connect);
mysql_query("set names utf8;") ;
extract($_REQUEST);
$ROOT = $_SERVER['DOCUMENT_ROOT'];
if($listsize == "") $listsize= 13;  
$pagesize = 1;
if($page == "") $page = 1;  
$firstNum = ($page-1)*$listsize;
$sql = ''; 
$where.=isset($key)?" and $key like '%$keyword%' ":"";
$sqls = "select * from g4_board where 1=1  and bo_list_level<5"; 
$querys = mysql_query($sqls); 

for($i =0; $rss = mysql_fetch_array($querys); $i++){
	if($i == 0){ 
		$sql .= "SELECT * FROM ";
		$sql .= "(SELECT wr_subject,wr_id,wr_datetime,wr_comment,wr_parent,wr_is_comment,wr_name,ca_name,wr_content, '$rss[bo_table]' AS bo_table,wr_hit, '$rss[bo_subject]' AS bo_subject FROM g4_write_$rss[bo_table] "; 
	}else{ 
		$sql .= "UNION ALL SELECT wr_subject,wr_id,wr_datetime,wr_comment,wr_parent,wr_is_comment,wr_name,ca_name,wr_content, '$rss[bo_table]' AS bo_table,wr_hit, '$rss[bo_subject]' AS bo_subject FROM g4_write_$rss[bo_table] "; 
	} 
} 
if($type=="comment"){
$sql .= ") a where a.wr_is_comment = '1' $where order by a.wr_datetime desc limit $firstNum,$listsize"; 
}else{
$sql .= ") a where a.wr_is_comment = '0' $where  and a.wr_subject!=''  order by a.wr_datetime desc limit $firstNum,$listsize"; 
}
$query = mysql_query($sql); 

$sql = ''; 
$sqls = "select * from g4_board where 1=1  and bo_list_level<5"; 
$querys = mysql_query($sqls); 

for($i =0; $rss = mysql_fetch_array($querys); $i++){
	if($i == 0){ 
		$sql .= "SELECT count(*) cnt FROM ";
		$sql .= "(SELECT wr_subject,wr_id,wr_datetime,wr_parent,wr_comment,wr_is_comment,wr_name,ca_name,wr_content, '$rss[bo_table]' AS bo_table, '$rss[bo_subject]' AS bo_subject FROM g4_write_$rss[bo_table] "; 
	}else{ 
		$sql .= "UNION ALL SELECT wr_subject,wr_id,wr_datetime,wr_parent,wr_comment,wr_is_comment,wr_name,ca_name,wr_content, '$rss[bo_table]' AS bo_table, '$rss[bo_subject]' AS bo_subject FROM g4_write_$rss[bo_table] "; 
	} 
} 
if($type=="comment"){
$sql .= ") a where a.wr_is_comment = '1'  $where"; 
}else{
$sql .= ") a where a.wr_is_comment = '0'  $where and a.wr_subject!=''"; 
}
$c_query = mysql_query($sql); 
$cnt= mysql_fetch_assoc($c_query);
$cnt=$cnt[cnt];
$lnum2 = ceil($cnt/$listsize);
$fnum = ((int)(($page-1)/$pagesize)*$pagesize)+1;
$lnum = ((int)(($page-1)/$pagesize)*$pagesize)+$pagesize;
$lnum= ( $lnum2 < $lnum)?$lnum2:$lnum;
$json=array();
$json['posts']=array();
$json['page']=$fnum;
$json['total_page']=$lnum2;
$json['cnt']=$cnt;
while($rs = mysql_fetch_assoc($query)){ 
	$product=array();
	$product['wr_id']=$rs['wr_id'];
	$product['wr_datetime']=date("m-d",strtotime($rs[wr_datetime]));
	$product['wr_parent']=$rs[wr_parent];
	$product['wr_comment']=$rs['wr_comment'];
	$product['wr_is_comment']=$rs[wr_is_comment];
	$product['wr_hit']=$rs[wr_hit];
if($type=="comment"){
//	$product['wr_content']=mb_substr(strip_tags(trim($rs[wr_content])),0,12, "utf-8");
	$product['wr_content']=strip_tags(trim($rs[wr_content]));
}else{
if($board_type=="list"){
	$product['wr_content']=$rs[wr_subject];
	$product['wr_name']=$rs[wr_name];
	$product['ca_name']=$rs[ca_name];
	$product['bo_subject']=$rs[bo_subject];
	
}else{
//	$product['wr_content']=mb_substr(strip_tags(trim($rs[wr_subject])),0,12, "utf-8");
	$product['wr_content']=strip_tags(trim($rs[wr_subject]));
}
}
	$product['bo_table']=$rs[bo_table];
	array_push($json['posts'],$product);
}
header('Content-Type: application/json');
echo json_encode($json);
?>