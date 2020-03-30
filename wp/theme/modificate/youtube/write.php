<script src="js/jquery.js"></script>

<script>
/* set_youtubelink()  
 디비에 기록
*/
function set_youtubelink() {
	// body...
var param=$("#youtubelist").serialize();

var ey_title=$("#ey_title").val();
var ey_videoid=$("#ey_videoid").val();


if(ey_title=="")
{
	alert("제목을 적어 주세요.");
	$("#ey_title").focus();
	return;
}

if(ey_videoid=="")
{
	alert("비디오 링크를 적어 주세요.");
	$("#ey_videoid").focus();
	return;
}
//param=encodeURIComponent(param);
console.log(param);
	$.ajax({
		url:"./set_youtube.php",
		data:param,
		dataType:"json",
		type:"POST",
		success:function(data){
			console.log(data);
			$("#btn_refresh").html(data.sql);
			set_make();
		}
	});
}

function set_make()
{
	$.ajax({
		url:"./make_js.php?loc_id="+$("#pr_list").val(),
		data:"",
		dataType:"json",
		type:"GET",
		beforeSend:function(){
			$("#btn_refresh").val("불러오는 중...");
		},
		success:function(data){
			if(data.success){
				$("#btn_result").html(data.message);
			}else{
				$("#btn_result").html(data.message);
			}
		}
	});
}

</script>
<?php

echo "<form id='youtubelist'>";
printf("<input type='hidden' name='ey_group' id='ey_group' value='%s'>",$_GET['pr_list']);
echo 'title : <br><input type="text" name="ey_title" id="ey_title" value="" style="width:90%;font-size:2em;padding:15px;margin:20px"><br>';
echo '<br><br>youtube_link : <br><input type="text" name="ey_videoid" id="ey_videoid" value="" style="width:90%;font-size:2em;padding:15px;margin:20px"><br>';
echo "</form>";
echo '<input type="button" value="쓰기" onclick="javascript:set_youtubelink();">';

echo '<div id="btn_refresh">...</div>';
echo '<div id="btn_result">,,,</div>';