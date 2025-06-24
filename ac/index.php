<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all">
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/wp/common.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/ac/commons.php');
include_once "./db_con.php";
include_once "./subject.php";
global $account_users;

print("<a href='/'>home</a>");
print("<br>");
if($is_admin)
{
	print("<br>");
	print("할렐루야!!!<br> 관리자님 안녕하세요. <br>서울에스라교회 회계보고 페이지에 오신걸 환영합니다.<br>");
	print("전체 보고 리스트로 이동합니다.<br>");
	print("<button onclick=\"location.href='list.php'\">리스트</button>");
	print("<br>");
	print("<button onclick=\"location.href='/ac/takeover/list.php'\">회계 인수 인계 리스트</button>");
	print("<br>");
	print("<button onclick=\"location.href='/ac/config_modify.php'\">회계일 변경</button>");

}else{
	$multiple_name = array();
	foreach($array_multiple_class as $key=>$value)
	{
		$multiple_name[]= sprintf("%s(%s)",$SUBJECT['ko'][$value],$value);
	}
	printf("<br>할렐루야. <br>\"%s\"장님 안녕하세요. 서울에스라교회 회계보고 페이지에 오신걸 환영합니다.<br>",join(", ", $multiple_name),$executive['au_name']);
	echo "<table class='reference'>";
	print("<tr>");
	printf("<th>%s(%s) </th>",'팀명','class명');
	printf("<th>%s</th>",'은행명');
	printf("<th>%s</th>",'계좌번호');
	printf("<th>%s</th>",'입금자명');
	printf("<th>%s</th>",'계좌 정보 수정');
	printf("<th>%s</th>",'인수 인계');
	print("</tr>");
	foreach($account_users as $key=>$value)
	{
		$ab_class=$value['ab_class'];
		print("<tr>");
		printf("<td>%s(%s) </td>",$SUBJECT['ko'][$ab_class],$ab_class);
		printf("<td>%s</td>",$value['au_bankname']);
		printf("<td>%s</td>",$value['au_bankno']);
		printf("<td>%s</td>",$value['au_holder']);
		printf("<td><button onclick=\"location.href='bank_modify.php?ab_class=%s'\">계좌 정보 수정</button> </td>",$ab_class);
		printf("<td><button onclick=\"location.href='/ac/takeover/write.php?ab_class=%s'\">회계 인수 인계</button></td>",$ab_class);
		print("</tr>");
	}
	echo "</table>";

	print("<br>  맞으실까요?");
	echo "<br>";
	echo "<br>";
	echo "맞으시면 리스트로 이동 합니다. -> ";
	echo "<button onclick=\"location.href='list.php'\">리스트</button>";
}
