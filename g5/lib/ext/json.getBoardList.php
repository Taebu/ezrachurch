<?$last_sb_idx = 0;?>
<?
include_once('../../common.php');

$where = ($_GET['json']=="get_post")?"where seq='".$_GET['seq']."' and status='I'":$where;
$where.= ($searchkeyword)?" and INSTR(sb_subject,'$searchkeyword') ":$where;

$where2= ($searchkeyword)?" and INSTR(sb_writer,'$searchkeyword') ":$where2;
$where3= ($searchkeyword)?" and INSTR(sb_contents,'$searchkeyword') ":$where3;

// array for JSON response
$response = array();
$start=($start)?$start:0;
$last_sb_idx = 0;
$listsize =($size)?$size:5;
//$pe_idx=22;
//$ms_idx=7;
$REG_DATE = date("Y-m-d H:i:s");

$listsize = 13;
$pagesize = 1;
if($page == "") $page = 1;  
$firstNum = ($page-1)*$listsize;
$sql = ''; 
$sqls = "select * from g4_board"; 
$querys = sql_query($sqls); 
for($i =0; $rss = sql_fetch_array($querys); $i++){ 
if($i == 0){ 
$sql .= "SELECT * FROM ";
$sql .= "(SELECT wr_id,wr_datetime,wr_parent,wr_is_comment,wr_content, '$rss[bo_table]' AS bo_table FROM g4_write_$rss[bo_table] "; 
}else{ 
$sql .= "UNION ALL SELECT wr_id,wr_datetime,wr_parent,wr_is_comment,wr_content, '$rss[bo_table]' AS bo_table FROM g4_write_$rss[bo_table] "; 
} 
} 
$sql .= ") a where a.wr_is_comment = '1' order by a.wr_datetime desc limit $start,$listsize"; 


$result = sql_query($sql);
$start++;
// check for empty result
if (mysql_num_rows($result) > 0) {
	// looping through all results
	// products node
	$response["posts"] = array();
	while ($row = mysql_fetch_array($result)) {
	  $product = array();
	  $product["wr_id"]       	= $row[wr_id];
	  $product["wr_datetime"] 	= $row[wr_datetime];
	  $product["wr_parent"] 	= $row[wr_parent];
	  $product["wr_is_comment"]	    = $row[wr_is_comment];
	  $product["wr_content"]       = $row[wr_content];
	  $product["bo_table"]     = $row[bo_table];
  	  array_push($response["posts"], $product);
	}
	// success
	$response["count"]=count($response["posts"]);
	$response["start"]=count($response["posts"]);
	$response["sb_notice"]=$sb_notice;
	$response["success"] = 1;

	// echoing JSON response
	echo ($callback)?$callback.'('.json_encode($response).')':json_encode($response);
} else {
	// no products found
	$response["success"] = 0;
	$response["count"]=count($response["posts"]);
	$response["message"] = "No products found";

	// echo no users JSON
	echo ($callback)?$callback.'('.json_encode($response).')':json_encode($response);
}
?>