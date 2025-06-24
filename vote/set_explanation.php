<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/db_con.php');
if($type=="explanation")
{
	$sql = sprintf("select * from ez_vote_question where evq_no='%s';",$q);
	$evq = $db->query($sql);
	$row=$evq->fetch_assoc();

	$json = array();
	$json['lists'] = array();
	$sql = sprintf("select * from ez_vote where ev_question_number='%s';",$q);
	$evq = $db->query($sql);
	$correct_count = 0;
	$in_correct_count = 0;
	while($list=$evq->fetch_assoc())
	{
		if($list['ev_answer']!=$row['evq_answer_key'])
		{
			set_dead($list);
			array_push($json['lists'],$list);
			$in_correct_count++;
		}else{
			set_live($list);
			$correct_count++;
		}
		
	}
}

if($type=="revival")
{
	$json = array();
	$json['lists'] = array();
	$sql = "select * from ez_vote;";
	$evq = $db->query($sql);
	$correct_count = 0;
	$in_correct_count = 0;
	while($list=$evq->fetch_assoc())
	{
		set_live($list);
		$correct_count++;
		array_push($json['lists'],$list);
	}
	$json['correct_count']=$correct_count;
	$json['in_correct_count']=$in_correct_count;
	echo json_encode($json);
	exit();
}

function set_live($list)
{
	global $db;
	$sql = sprintf("update ez_vote set ev_survive='O' where ev_no='%s';",$list['ev_no']);
	$query=$db->query($sql);
}

function set_dead($list)
{
	global $db;
	$sql = sprintf("update ez_vote set ev_survive='X' where ev_no='%s';",$list['ev_no']);
	$query=$db->query($sql);
}
$json['correct_count']=$correct_count;
$json['in_correct_count']=$in_correct_count;
echo json_encode($json);