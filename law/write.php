<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="./lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./lib/css/stdtheme.css" media="all" />
<script src="./lib/js/jquery-1.10.1.min.js"></script>

<script>	

function set_write()
{
	var param=$("#westminster").serialize();
	$.ajax({
		url:"./set_write.php",
		data:param,
		dataType:"json",
		type:"POST",
		success:function(data){
			if(data.success){
				alert("입력되었습니다.");
				location.href='./list.php';
			}
		}
		});
}
</script>
<style>
textarea{margin: 0px; width: 337px; height: 239px;}
input{padding:10px;font-size:19px;margin-right:10px;width: 90%;}

</style>
<?php
include_once "./subject.php";
function get_numeric($str)
{
	return  preg_replace("/[^0-9]*/s", "", $str); ;
}
echo "<form id='westminster'>";
echo "<input type='hidden' name='table' value='westminster_confession'>";
echo '<table class="ibk_info">';
echo '<tr>';
echo '<td>장</td><td>';
echo "<select name='wm_chapter'>";
foreach($SUBJECT['ko'] as $key =>$value)
{
	printf("<option value='%s'>%s %s</option>",get_numeric($key),$key,$value);
}
echo "</select>";
echo '장</th></tr>';	
echo '<tr>';
echo '<td>항</td><td>';
echo "<input type='text' name='wm_clause' value=''>";
echo '항</th></tr>';	
echo '<tr>';
echo '<td>제목</td><td>';
echo "<input type='text' name='wm_subject' value=''>";
echo '</th></tr>';	
echo '<tr>';
echo '<td>내용</td><td>';
echo "<textarea name='wm_content'></textarea>";
echo '</th></tr>';	



echo '<tr>';
echo '<td>내용 영문</td><td>';
echo "<textarea name='wm_content_eng'></textarea>";
echo '</th></tr>';	

echo '<tr>';
echo '<td>해설</td><td>';
echo "<textarea name='wm_commentary'></textarea>";
echo '</th></tr>';	

echo '<tr>';
echo '<td>해설 (영문)</td><td>';
echo "<textarea name='wm_commentary_eng'></textarea>";
echo '</th></tr>';	

echo '<tr>';
echo '<td>관련구절</td><td>';

echo "<textarea name='wm_relparse'></textarea>";
echo "</td></tr></table>";

echo "<input type='button' value='쓰기' onclick='set_write();'>";