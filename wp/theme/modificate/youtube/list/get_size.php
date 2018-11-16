<?php
/*

http://ezrachurch.kr/wp/theme/modificate/youtube/list/get_size.php?loc_id=lecture_01
*/
include_once('./_common.php');

$sql=sprintf("select count(*) cnt from `ez_youtubelink` where ey_group='%s';",$pr_list);
$query=sql_query($sql);
$row=sql_fetch_array($query);
echo json_encode($row);
