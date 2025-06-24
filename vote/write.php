<script src="/wm/lib/js/jquery-1.10.1.min.js"></script>
<script>
$(document).ready(function () {
  $("[name='evq_type']").click(function () {
    if($(this).val()=="radio")
    {
		set_radio();
    }else{
		set_textarea();
    }
  });
});

function set_radio()
{
	var object = [];
	object.push('정답 : <label for="evq_answer_1"><input type="radio" name="evq_answer" id="evq_answer_1" value="O" checked>O</label> ');
	object.push('<label for="evq_answer_2"><input type="radio" name="evq_answer" id="evq_answer_2" value="X">X</label>');
	$("#answer_area").html(object.join(""));
}

function set_textarea()
{
	var object = [];
	object.push('정답 : <input type="text" name="evq_answer_key">');
	$("#answer_area").html(object.join(""));
}

</script>
<form action="./set_question.php" method="GET">
질문 : <input type="text" name="evq_question"><br>
질문 타입 : 
<label for="evq_type_1"><input type="radio" name="evq_type" id="evq_type_1" value="radio" checked>radio</label> 
<label for="evq_type_2"><input type="radio" name="evq_type" id="evq_type_2" value="text">text</label><br>
<div id="answer_area">정답 : <label for="evq_answer_1"><input type="radio" name="evq_answer" id="evq_answer_1" value="O" checked="">O</label> <label for="evq_answer_2"><input type="radio" name="evq_answer" id="evq_answer_2" value="X">X</label></div>	

</div><!-- #answer_area -->


정원(재적 -> 문제 참여자수) : <input type="text" name="evq_capacity"><br>
<br>
<input type="submit">
</form>