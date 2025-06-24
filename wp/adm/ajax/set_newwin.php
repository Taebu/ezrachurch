<?php
include_once("../../common.php");

$sql=sprintf("INSERT INTO newezra.g5_new_win
 (nw_device, nw_begin_time, nw_end_time, nw_disable_hours, nw_left, nw_top, nw_height, nw_width, nw_subject, nw_content, nw_content_html)
SELECT  nw_device, nw_begin_time, nw_end_time, nw_disable_hours, nw_left, nw_top, nw_height, nw_width, nw_subject, nw_content, nw_content_html
FROM newezra.g5_new_win where nw_id=%s;",$nw_id);


$query=$sql;
$json['query']=$query;
$result=sql_query($query);
$json['success']=$result;

echo json_encode($json);
