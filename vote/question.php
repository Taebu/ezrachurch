<script src="/wm/lib/js/jquery-1.10.1.min.js"></script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/db_con.php');

$sql = sprintf("select * from ez_vote_question where evq_no='%s';",$q);
$evq = $db->query($sql);
$row=$evq->fetch_assoc();
if(!isset($row)){
	exit("문제를 다 풀었습니다. 축하합니다. 우승입니다.");
}
printf('<h1>%s</h1>',$row['evq_question']);
?>
<script>
	function set_question()
	{
		var param = $("#question").serialize();
		$.ajax({
			url:"/vote/set_write.php",
			data:param,
			dataType:"json",
			type:"POST",
			success:function(data)
			{
				$("#question").attr("action", data.action_url);
				$("#ev_name").val(data.ev_name);

				$("#result").html(data.message);
			}
		});		

	}
</script>
<form action="/vote/set_write.php" method="POST" id="question">
<input type="hidden" name="ev_question_number" value="<?php echo $q;?>">
<input type="text" name="ev_name" id="ev_name" value="<?php echo $ev_name;?>" placeholder="참여할 이름을 기입해 주세요."><br>
<?php 
if($row['evq_type']=="radio"){
?>
<label for="ev_answer_1"><input type="radio" name="ev_answer" id="ev_answer_1" value="O" checked>O</label>
<label for="ev_answer_2"><input type="radio" name="ev_answer" id="ev_answer_2" value="X">X</label><br>
<?php 
}

if($row['evq_type']=="text"){
?>
<textarea name="ev_answer" id="ev_answer" cols="30" rows="10"></textarea>
<?php 
}
?><br>
<div id="result">#result</div>
</form>
<input type="button" onclick="javascript:set_question()" value="정답제출 및 정답 확인">