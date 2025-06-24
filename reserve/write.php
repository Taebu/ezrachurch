<?php
include_once "../wp/common.php";
if(!$is_admin)
{
	echo "수정 권한이 없습니다.";
	exit();
}

$frdt=date("Y-m-d",strtotime("+1 day"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
<script src="/wp/js/jquery-1.8.3.min.js"></script>
<link rel="stylesheet" href="/wp/css/jquery.ui.min.css">  
<script src="/wp/js/jquery.ui.min.js"></script>
<script>
function set_modify_server()
{
	var param = $("#cal").serialize();

	$.ajax({
		url:"./set_cal.php",
		data:param,
		dataType:"json",
		type:"POST",
		success:function(data){
			if(data.success){
				location.href='./list.php';
			}
		}
	});
}

/* datepicker */
var dateoption={dateFormat: "yy-mm-dd",
dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
dayNames: [ "일", "월", "화", "수", "목", "금", "토" ],
monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
showOn:"both", buttonImage: "https://jqueryui.com/resources/demos/datepicker/images/calendar.gif"
};

  $( function() {
    $("[name=frdt]").datepicker(dateoption);
    $("[name=todt]").datepicker(dateoption);
  });
  function set_todt(v)
  {
	$("[name=todt]").val(v);
  }
	</script>
</head>
<body>
	<form name="cal" id="cal" method="POST" onsubmit="return set_modify_server()">
	<input type="hidden" name="mode" value="insert">
	<table>
		<tr>
			<td>일정</td>
			<td><input type="text" name="name" required placeholder="name"></td>
		</tr>
		<tr>
			<td>메모</td>
			<td><input type="text" name="memo" placeholder="memo"></td>
		</tr>
		<tr>
			<td>시작일</td>
			<td><input type="text" name="frdt" required placeholder="frdt" value="<?php echo $frdt;?>" onchange="javascript:set_todt(this.value)"></td>
		</tr>
		<tr>
			<td>종료일</td>
			<td><input type="text" name="todt" required placeholder="todt" value="<?php echo $frdt;?>"></td>
		</tr>
		<tr>
			<td>공휴일 여부 (기본값 : N)</td>
			<td><label><input type="radio" name="holiday" value="N" checked>N</label>
		<label><input type="radio" name="holiday" value="Y">Y</label></td>
		</tr>
	</table>
	<input type="submit">
	</form>
</body>
</html>