<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/wp/common.php');

if(!isset($_SESSION['ss_mb_id']))
{
	print("성경 읽기 페이지에 오신 것을 환영합니다.<br>");
	print("해당 페이지는 성경 읽은 기록을 위해 로그인이 필요합니다.<br>");
	print("홈페이지에서 가입 하고 로그인 후 이용 가능합니다.<br><br>");
	print("사용 법은 간단합니다. 읽은 장을 클릭하면 토글 되면서 읽은 것으로 다시 클릭하면 안읽은 것으로 표시 됩니다.");
	print("성경 제목을 클릭하면 전체 장이 읽은 것이 하나라도 있으면 해제 되고 다시 클릭하면 전체가 체크 됩니다.<br><br>");
	print("<a href='/wp/bbs/login.php?&url=https%3A%2F%2Fezrachurch.kr%2Fbc%2FNavigation.php'>Home으로 가기</a>");
	exit();
}else{
	$mb_id=$_SESSION['ss_mb_id'];
}
?>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<script src="/wm/lib/js/jquery-1.10.1.min.js"></script>
<style>
 table{border-collapse: collapse; border-spacing: 0}
	td{border:1px solid #ccc;padding: 0;}
	.bible td{width:35px;text-align: center;border-top:0px;cursor:pointer;}
	.tdhighlight{background-color: seagreen;color:yellow}
	#read_info{float: left;}
	.reference{float: left;}
</style>
<script>
var selected_id = [];
	$(document).ready(function(){
    
	$(".bible td").click(function(){
      $(this).toggleClass('tdhighlight');
		set_id();
    }); 
	
	$(".reference td").click(function(){
		if($(".bible [data-id^="+$(this).data("id")+"_].tdhighlight").length>0)
		{
			$(".bible [data-id^="+$(this).data("id")+"_]").removeClass("tdhighlight");
		}else{
			$(".bible [data-id^="+$(this).data("id")+"_]").each(function(index,item){
				$(this).toggleClass('tdhighlight');
			});
		}
		
		set_id();
	});

	/* 서버에서 관련 자료를 불러 옵니다.*/
	get_id();

	/* 서버에서 성경을 읽은 자료를 불러 옵니다.*/
	get_read();
});

function set_id()
{
	var eb_count = $("#eb_count").val();

	var eb_no = $("#eb_no").val();

	selected_id = [];
	$(".tdhighlight").each(function(index, item){
    selected_id.push($(this).data("id"));
	});

	if(selected_id.length==1192)
	{
		if(confirm($("#mb_id").val()+"님 축하합니다. 성경 전부를 읽으셨습니다.\n초기화 하시겠습니까? 초기화 되면 1회독이 인정되고 폼은 초기화 됩니다."))
		{
			finished_read();
			init_id();
		}
	}

	var param = {'eb_data':selected_id.join(","),'mb_id':$("#mb_id").val(),'eb_no':eb_no,'eb_count':eb_count};
	$.ajax({
		url:"./set_read.php",
		dataType:"json",
		type:"POST",
		data:param,
		success:function(data){
		}
	});

}

function get_id()
{
		var param = {'mb_id':$("#mb_id").val()};
		var temp = [];
		$.ajax({
			url:"./get_read.php",
			dataType:"json",
			type:"POST",
            data:param,
            success:function(data){
				temp = data.eb_data.split(',');
				$("#eb_count").val(data.eb_count);
				$("#eb_no").val(data.eb_no);
				$.each(temp,function(key,value){
//					console.log(value);
				  $('[data-id=' + value + ']').addClass('tdhighlight');
				});
			}
		});
}

function init_id()
{
	$(".bible td").each(function(index,item){
		$(this).removeClass('tdhighlight');
	});
}

function finished_read()
{
	var eb_count = $("#eb_count").val();
	var eb_no = $("#eb_no").val();
	var param = {'eb_data':"",'eb_no':eb_no,'eb_count':eb_count,'eb_type':'end','mb_id':$("#mb_id").val()};
	$.ajax({
		url:"./set_read.php",
		dataType:"json",
		type:"POST",
		data:param,
		success:function(data){
		}
	});
}

function get_read()
{
	var param = {'mb_id':$("#mb_id").val(),'type':'list'};
	var temp = [];
	$.ajax({
		url:"./get_read.php",
		dataType:"json",
		type:"POST",
		data:param,
		success:function(data){
			var object = [];
			object.push("<table>");
			object.push("<tr><td>");
			object.push("읽은 횟수");
			object.push("</td><td>");
			object.push("읽기 시작한 일시");
			object.push("</td><td>");
			object.push("완독한 일시");
			object.push("</td></tr>");
			$.each(data.lists,function(key,val){
				object.push("<tr><td>");
				object.push(val.eb_count);
				object.push("</td><td>");
				object.push(val.eb_create_datetime);
				object.push("</td><td>");
				object.push(val.eb_end_datetime);
				object.push("</td></tr>");
			});
			object.push("</table>");
			$("#read_info").html(object.join(""));
			/*
			temp = data.eb_data.split(',');
			$("#eb_count").val(data.eb_count);
			$("#eb_no").val(data.eb_no);
			$.each(temp,function(key,value){
//					console.log(value);
			  $('[data-id=' + value + ']').addClass('tdhighlight');
			});
			*/
		}
	});
}
</script>
<body>
	<input type="hidden" id="eb_count" name="eb_count" value="0">
	<input type="hidden" id="eb_no" name="eb_no" value="0">
	<input type="hidden" id="mb_id" name="mb_id" value="<?php echo $mb_id;?>">

</body>
<?php
include_once "./navi_info.php";
print("<table class='reference'>");
foreach($bible_arraies as $key => $value)
{
	print("<tr>");
	printf("<td data-id='%s'>",$key);
	print($value['kor_name']);
	print("</td>");
	print("<td>");
	$pos_a = strpos($value['start'], ":");
	$pos_e = strpos($value['end'], ":");
	if($pos_a)
	{
		$array_a=explode(":", $value['start']);
		$value['start']=$array_a[0];
		$pos_a=false;
	}

	if($pos_e)
	{
		$array_end=explode(":", $value['end']);
		$value['end']=$array_end[0];
		$pos_e=false;
	}

	print("<table class='bible'><tr>");
	if($pos_a===false&&$pos_e===false)
	{
		$j=0;
		for ($i=$value['start'];$i<=$value['end'];$i++) {
			if(isset($array_a))
			{
				printf("<td data-id='%s'>%s</td>",$key."_".$i,join(":",$array_a));
				unset($array_a);
			}else if(isset($array_end)&&$i==$array_end[0]){
			
				printf("<td data-id='%s'>%s</td>",$key."_".$i,join(":",$array_end));
				unset($array_end);
			}else{
				printf("<td data-id='%s'>%s</td>",$key."_".$i,$i);
			}
			$j++;
			if($j%20==0)
			{
				print("</tr><tr>");
			}
		}
	}
	print("</tr></table>");
	print("</td>");
	print("</tr>");
}
print("</table>");
?>
<div id="read_info">#read_info</div>