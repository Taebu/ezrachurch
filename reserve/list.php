<?php
include_once "../wp/common.php";
if(!$is_admin)
{
	echo "수정 권한이 없습니다.";
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
<script src="/wp/js/jquery-1.8.3.min.js"></script>
<script src="https://kit.fontawesome.com/3235d0fc48.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="/wm/lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/ac/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all" />
<link rel="stylesheet" href="/wp/css/jquery.ui.min.css">  
<script src="/wp/js/jquery.ui.min.js"></script>
<script>
	/* datepicker */
var dateoption={dateFormat: "yy-mm-dd",
dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
dayNames: [ "일", "월", "화", "수", "목", "금", "토" ],
monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
showOn:"both", buttonImage: "https://jqueryui.com/resources/demos/datepicker/images/calendar.gif"
};

function set_datepicker()
{
	$("[name=frdt]").datepicker(dateoption);
    $("[name=todt]").datepicker(dateoption);
}
  $( function() {
    set_datepicker();
  });
</script>
</head>
<body>
<a href="./cal.php" style="font-size:40px"><i class="fa-solid fa-calendar-days"></i></a>

<a href="./write.php" style="font-size:40px"><i class="fa-regular fa-pen-to-square"></i></a>
<?php

extract($_REQUEST);
$order =isset($order)?$order:"frdt";
$asend = isset($asend)?$asend:"asc";
$i=1;
include_once "./db_con.php";
$sql = "select * from schedule limit 1;";
$query=$db->query($sql);
list($no,$name,$memo,$frdt,$todt,$holiday) = $query->fetch_array(MYSQLI_NUM);
// echo $no;
// echo $name;
// echo $memo;
// echo $frdt;
// echo $todt;
// echo $holiday;
$sql = "select * from schedule";
$order=sprintf(" order by %s %s;",$order,$asend);
$query=$db->query($sql.$order);
echo "<form name='cal'  id='cal' method='POST'>";
print("<table  class='reference'>");
print("<tr>");
printf("<th>%s</th>",'no');
printf("<th>%s</th>",'name');
printf("<th>%s</th>",'memo');
printf("<th>%s</th>",'frdt');
printf("<th>%s</th>",'todt');
printf("<th>%s</th>",'insdt');
printf("<th>%s</th>",'holiday');
printf("<th>%s</th>",'수정');
printf("<th>%s</th>",'삭제');
print("</tr>");
while($list=$query->fetch_assoc())
{
	
printf("<tr id='tr_%s'>",$list['no']);
printf("<td>%s</td>",$i++);
printf("<td id='name_%s'>%s</td>",$list['no'],$list['name']);
printf("<td id='memo_%s'>%s</td>",$list['no'],$list['memo']);
printf("<td id='frdt_%s'>%s</td>",$list['no'],$list['frdt']);
printf("<td id='todt_%s'>%s</td>",$list['no'],$list['todt']);
printf("<td>%s</td>",$list['insdt']);
printf("<td id='holiday_%s'>%s</td>",$list['no'],$list['holiday']);
printf("<td id='modify_%s'><a href='javascript:set_modify(%s)'>수정</a></td>",$list['no'],$list['no']);
printf("<td><a href='javascript:set_delete(%s)'>삭제</a></td>",$list['no']);
print("</tr>");
}
print("</table>");
?>
<input type="hidden" name="asend" id="asend" value="<?php echo $asend;?>">

</body>
<script>
var local_no = 0;
var is_modify=false;
function set_modify(no)
{
	if(is_modify)
	{
		alert("아직 수정 중입니다!!");
		return ;
	}
	is_modify=true;
	local_no=no;

	var name = $("#name_"+no).html();
	var memo = $("#memo_"+no).html();
	var frdt = $("#frdt_"+no).html();
	var todt = $("#todt_"+no).html();
	var holiday = $("#holiday_"+no).html();
	var object = "";
	var is_holiday = false;
	object = '<input type="text" name="name" value="'+name+'">';
	$("#name_"+no).html(object);
	object = '<input type="text" name="memo" value="'+memo+'">';
	$("#memo_"+no).html(object);
	object = '<input type="text" name="frdt" value="'+frdt+'"  onchange="javascript:set_todt(this.value)">';
	$("#frdt_"+no).html(object);
	object = '<input type="text" name="todt" value="'+todt+'">';
	$("#todt_"+no).html(object);
	if(holiday=="Y")
	{
		object  = '<label><input type="radio" name="holiday" value="Y" checked>Y</label>';
		object += '<label><input type="radio" name="holiday" value="N" >N</label>';
	}else{
		object  = '<label><input type="radio" name="holiday" value="Y">Y</label>';
		object += '<label><input type="radio" name="holiday" value="N" checked>N</label>';
	}
	$("#holiday_"+no).html(object);

	object = "<a href='javascript:set_modify_server("+no+")'>저장</a>";
	$("#modify_"+no).html(object);
	set_datepicker();
}

function set_modify_server(no)
{
	var param = $("#cal").serialize();
	param = param +"&no="+no;
	param = param +"&mode=update";

	$.ajax({
		url:"./set_cal.php",
		data:param,
		dataType:"json",
		type:"POST",
		success:function(data){
			if(data.success){
				is_modify=false;
				$("#name_"+no).html(data.name);
				$("#memo_"+no).html(data.memo);
				$("#frdt_"+no).html(data.frdt);
				$("#todt_"+no).html(data.todt);
				$("#holiday_"+no).html(data.holiday);
				$("#modify_"+no).html('<a href="javascript:set_modify('+no+')">수정</a>');
				
			}
		}
	});
}

function set_delete(no)
{
	if(confirm("일정을 삭제하면 되돌릴 수 없습니다. 삭제 하시겠습니까?")){
	var param = "no="+no;
	param = param +"&mode=delete";

	$.ajax({
		url:"./set_cal.php",
		data:param,
		dataType:"json",
		type:"POST",
		success:function(data){
			if(data.success){
				is_modify=false;
				$("#tr_"+no).html("");
			}
		}
	});
	}
}
var asend = $("#asend").val();
var order_name = "frdt";
$(window).load(function () {
	if(asend=="asc")
	{
		asend="desc";
	}else{
		asend="asc";
	}
$(document).on("click", "th", function () {
	
	order_name=$(this).html();
	location.href='./list.php?order='+order_name+"&asend="+asend;
});

});

  function set_todt(v)
  {
	$("[name=todt]").val(v);
  }
</script>

</html>
