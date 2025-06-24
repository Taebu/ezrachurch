<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/db_con.php');
$json = array();
$sql = sprintf("select * from ez_vote where ev_name='%s' and ev_survive='X';",$ev_name);
$evq = $db->query($sql);
$dead=$evq->fetch_assoc();
$json['ev_name']=$ev_name;
if(isset($dead)&&count($dead)>0)
{
	$json['message'] = "문제를 틀리셔서 투표권을 상실하셨습니다.";
	echo json_encode($json);
	exit();
}
$sql = sprintf("select * from ez_vote where ev_question_number='%s' and ev_name='%s';",$ev_question_number,$ev_name);
$evq = $db->query($sql);
$row=$evq->fetch_assoc();

if(isset($row)&&$row['ev_survive']=="O")
{
	$array = array();
	$array[] = "축하합니다. 정답을 맞추 셨습니다. 다음 문제로 넘어갈 수 있습니다. 참여를 원하시면 다음 버튼을 눌러 주세요.";
	$array[] = "<br>";
	$array[] = sprintf("<input type='submit' value='다음 문제'>");
	$json['message']=join("",$array);
	$json['ev_name']=$ev_name;
	$json['action_url']=sprintf("/vote/q/%s",$row['ev_question_number']+1);
	echo json_encode($json);
}else if(isset($row)&&count($row)>0)
{
	$json['message'] = "낙장불입 : 같은 이름으로 이미 투표하였습니다. 결과를 기다려 주세요.";
	echo json_encode($json);
	exit();
}else{
	$sql = "insert into ez_vote set ";
	$sql.= sprintf("ev_question_number = '%s', ",$ev_question_number);
	$sql.= sprintf("ev_name = '%s', ",$ev_name);
	$sql.= sprintf("ev_answer = '%s', ",$ev_answer);
	$sql.= sprintf("ev_datetime = now(); ");
	$query = $db->query($sql);
	$json['message'] = "투표 완료 하였습니다.";
	echo json_encode($json);
	exit();

}
?>