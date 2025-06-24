<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>2024 교사고시</title>
	<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all">
</head>
<body>
<?php
include_once "./db_con.php";
$where ="";
if(isset($c))
{
	$zero_fill = sprintf("%02d", $c);
	$where = sprintf("where ex_cate like '%%%s%%' ",$zero_fill);
}
$sql=sprintf( "select * from exam %s",$where);
$query=$mysqli->query($sql);
	print("<table class='reference'>");
	print("<colgroup>");
	print("<col width='10%'>");
	print("<col width='45%'>");
	print("<col width='45%'>");
	print("</colgroup>");
	print("<tr>");
	printf("<th>%s</th>",'ex_cate');
	printf("<th>%s</th>",'ex_question');
	printf("<th>%s</th>",'ex_answer');
	print("</tr>");
while($list=$query->fetch_assoc()){
	print("<tr>");
	printf("<td>%s</td>",$list['ex_cate']);
	printf("<td>%s</td>",$list['ex_question']);
	printf("<td>%s</td>",$list['ex_answer']);
	print("</tr>");
}
?>

	
</body>
</html>