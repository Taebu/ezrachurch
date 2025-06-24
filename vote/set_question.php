<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/db_con.php');
$sql="insert into ez_vote_question set ";
$sql.=sprintf("`evq_question`='%s',",$evq_question);
$sql.=sprintf("`evq_type`='%s',",$evq_type);
$sql.=sprintf("`evq_answer_key`='%s',",$evq_answer_key);
$sql.=sprintf("`evq_capacity`='%s';",$evq_capacity);
$query=$db->query($sql);