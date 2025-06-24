<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<script>	
function set_modify()
{
	var param=$("#westminster").serialize();
	$.ajax({
		url:"./set_modify.php",
		data:param,
		dataType:"json",
		type:"POST",
		success:function(data){
			if(data.success){
				alert("수정되었습니다.");
				location.href='./list.php';
			}
		}
		});
}
</script>
<body>

</style>
<?php
include "./db_con.php";

include_once "./subject.php";
$sql=sprintf("select * from `westminster_confession` where wm_no='%s';",$wm_no);
$query=$mysqli->query($sql);
$view=$query->fetch_assoc();


$sql=sprintf("select wm_no from `westminster_confession` where wm_no<'%s' order by wm_no desc limit 1;",$wm_no);

$query=$mysqli->query($sql);
$pre=$query->fetch_assoc();
$sql=sprintf("select wm_no from `westminster_confession` where wm_no>'%s' limit 1;",$wm_no);

$query=$mysqli->query($sql);
$ord=$query->fetch_assoc();
if($pre)
{
	printf("<a href='./view.php?wm_no=%s' class='btn btn-primary'>이전</a>",$pre['wm_no']);
}else{	
	echo "<a class='btn btn-danger'>이전이 없습니다.</a>";
}

if($ord)
{
	printf("<a href='./view.php?wm_no=%s' class='btn btn-primary'>다음</a>",$ord['wm_no']);
}else{	
	echo "<a class='btn btn-danger'>다음이 없습니다.</a>";
}
echo "<div class='row'>";
echo '  <div class="col-xs-2">';
echo '  </div>';
echo '  <div class="col-md-8 col-md-offset-2 col-xs-8">';
echo "<form id='westminster'>";
echo sprintf("<input type='hidden' name='wm_no' value='%s'>",$view['wm_no']);
echo "<input type='hidden' name='table' value='westminster_confession'>";
echo '<h3>보드번호</h3><p>';
echo $view['wm_no'];
echo '</p>';
echo '<h3>장</h3><p>';
echo $view['wm_chapter'];
echo '장</th></tr>';	
echo '<h3>장제목 [한글]</h3><p>';
echo $SUBJECT['ko']["제".$view['wm_chapter']."장"];
echo '</p>';
echo '<h3>장제목 [영문]</h3><p>';
echo $SUBJECT['en']["제".$view['wm_chapter']."장"];
echo '</p>';
echo '<h3>항</h3><p>';
echo $view['wm_clause'];
echo '항</th></tr>';	
echo '<h3>제목</h3><p>';
echo $view['wm_subject'];
echo '</p>';

echo '<h3>내용</h3><p>';
echo nl2br($view['wm_content']);
echo '</p>';


echo '<h3>내용(영문)</h3><p>';
echo nl2br($view['wm_content_eng']);
echo '</p>';

echo '<h3>관련구절</h3><p>';
echo nl2br($view['wm_relparse']);
echo '</p>';

echo '<h3>관련구절 (영문)</h3><p>';
echo nl2br($view['wm_relparse_eng']);
echo '</p>';

echo '<h3>해설</h3><p>';
echo nl2br($view['wm_commentary']);
echo '</p>';

echo '<h3>해설 (영문)</h3><p>';
echo nl2br($view['wm_commentary_eng']);
echo '</p>';

echo "</table>";
if($pre)
{
	printf("<a href='./view.php?wm_no=%s' class='btn btn_primary'>이전</a>",$pre['wm_no']);
}else{	
	echo "<a class='btn btn_danger'>이전이 없습니다.</a>";
}

if($ord)
{
	printf("<a href='./view.php?wm_no=%s' class='btn btn_primary'>다음</a>",$ord['wm_no']);
}else{	
	echo "<a class='btn btn_danger'>다음이 없습니다.</a>";
}


echo sprintf("<button type='button' value='수정'   class='btn btn-primary' onclick=\"location.href='./modify.php?wm_no=%s'\">",$view['wm_no']);
echo "<button type='button'  class='btn btn-info' value='리스트' onclick=\"location.href='./list.php'\">";
?>

<link rel="stylesheet" href="/wm/lib/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="/wm/lib/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>