<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/db_con.php');
$ev_answer_O=0;
$ev_answer_X=0;
$q = isset($q)?$q:"1";
$sql = sprintf("select * from ez_vote_question where evq_no='%s';",$q);
$evq = $db->query($sql);
$row=$evq->fetch_assoc();
$sql = "SELECT MAX(evq_no) FROM ez_vote_question;";
$max_evq = $db->query($sql);
$max=$max_evq->fetch_array();
$max_evq_no=$max[0]+1;
$answer_q=$q+1;
if($max_evq_no<$answer_q)
{ 
	echo "다음 문제가 없습니다.";
	exit();
}
$sql = sprintf("select ev_answer,count(*) as ev_count from ez_vote where ev_question_number='%s' group by ev_answer;",$q);
$query = $db->query($sql);
while($list=$query->fetch_assoc())
{
	${'ev_answer_'.$list['ev_answer']}=$list['ev_count'];
}
$sql = sprintf("select * from ez_vote where ev_question_number='%s';",$q);
$query = $db->query($sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vote :: Page</title>
<script src="/wm/lib/js/jquery-1.10.1.min.js"></script>
<style>
table{border-collapse: collapse; border-spacing: 0}
body{background-color:black;color:#d4daf2;}
.vote{color:#01fc0a}
.right_wing{color:red}
.ANSWER_O::before{content:"●"}
.ANSWER_O{color:#01fc0a}
.ANSWER_X::before{content:"●"}
.ANSWER_X{color:red}
.ANSWER_Y{color:yellow}
.in_correct{background-color: red;color:white;padding: 5px;}
</style>
<script>
	function set_explanation()
	{

		var param = {'q':$("#q").val(),'type':'explanation'};
		$.ajax({
			url:"./set_explanation.php",
			data:param,
			dataType:"json",
			type:"POST",
			success:function(data)
			{
				$("#correct_count").html("정답 : "+data.correct_count+"인");
				$("#in_correct_count").html("오답 : "+data.in_correct_count+"인");
				$.each(data.lists,function(key,val)
				{
					$('span[data-id=' + val.ev_no + ']').addClass('in_correct');
				});
			}
		});
	}

	function set_revival()
	{
		var param = {'q':$("#q").val(),'type':'revival'};
		$.ajax({
			url:"./set_explanation.php",
			data:param,
			dataType:"json",
			type:"POST",
			success:function(data)
			{
				$("#correct_count").html("정답 : "+data.correct_count+"인");
				$("#in_correct_count").html("오답 : "+data.in_correct_count+"인");
				$('span').addClass('ANSWER_O');
			}
		});		
	}
</script>
</head>
<body>
<input type="text" name="q" id="q" value="<?php echo $q;?>">
<table>
	<tr>
		<td>재적 : <?php echo $row['evq_capacity'];?></td>
		<td>재석 : ?</td>
		<td class='ANSWER_O'>찬성 : <?php echo $ev_answer_O;?> 인</td>
		<td class='ANSWER_X'>반대 : <?php echo $ev_answer_X;?> 인</td>
		<td class='ANSWER_Y'>기권 : 0 인</td>
	</tr>
</table>
<div id="correct_count">#correct_count</div>

<div id="in_correct_count">#in_correct_count</div>

<?php 
printf('<h1>%s</h1>',$row['evq_question']);
print('<input type="button" onclick="javascript:set_explanation();" value="정답 확인">');

if($max_evq_no>$answer_q){
printf('<input type="button" onclick="location.href=\'/vote/%s\'" value="다음 문제">',$answer_q);
}else{
	print("다음 문제가 없습니다.");
}
print('<input type="button" onclick="javascript:set_revival();" value="전원 부활">');
echo "<p></p>";
$ev_name =array();
while($list=$query->fetch_assoc()){
	$ev_name[] = "'".$list['ev_name']."'";
	if($list['ev_type']=="radio")
	printf("<span class='ANSWER_%s' data-id='%s'>%s</span> ",$list['ev_answer'],$list['ev_no'],$list['ev_name']);

	if($list['ev_type']=="text")
	printf("<span class='ANSWER_O' data-id='%s'>%s : %s</span> ",$list['ev_no'],$list['ev_name'],$list['ev_answer']);
}

if(count($ev_name)>0)
{
$sql =sprintf("SELECT distinct ev_name FROM newezra.ez_vote where ev_question_number not in (%s) and ev_name not in (%s);",$q,join(",",$ev_name));
}else{
	$sql =sprintf("SELECT distinct ev_name FROM newezra.ez_vote where ev_question_number not in (%s);",$q);
}
$query=$db->query($sql);
while($list=$query->fetch_assoc())
{
	printf("<span>%s</span> ",$list['ev_name']);
}
?>

</body>
</html>