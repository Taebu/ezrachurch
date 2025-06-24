<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/db_con.php');

$sql = "select * from ez_vote_question ";
$query = $db->query($sql);
echo "<input type='button' onclick='javascript:location.href=\"/vote/write.php\"' value='글쓰기'>";
printf("<table>");
printf("<tr>");
printf("<td>%s</td>",'evq_no');
printf("<td>%s</td>",'evq_question');
printf("<td>%s</td>",'evq_answer_key');
printf("<td>%s</td>",'evq_type');
printf("<td>%s</td>",'evq_datetime');
printf("<td>%s</td>",'evq_capacity');
print("</tr>");
while($list = $query->fetch_array())
{
	printf("<tr>");
	printf("<td>%s</td>",$list[0]);
	printf("<td>%s</td>",$list[1]);
	printf("<td>%s</td>",$list[2]);
	printf("<td>%s</td>",$list[3]);
	printf("<td>%s</td>",$list[4]);
	printf("<td>%s</td>",$list[5]);
	print("</tr>");

}
print("</table>");