<?php
include_once "./db_con.php";
include_once "./subject.php";
$ab_class=isset($ab_class)?$ab_class:"";
$quater=isset($quater)?$quater:"";
$year=isset($year)?$year:"2023";
$sign_yn=isset($sign_yn)?$sign_yn:"";
$page_yn=isset($page_yn)?$page_yn:"N";


if($ab_class=="")
{
	print "<script>alert('팀명이 선택되지 않았습니다.');
	location.href='list.php';
	</script>";
}

?>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="/wm/lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all" />
<link rel="stylesheet" type="text/css" href="/ac/css/main.css" media="all" />
<script src="/wp/js/jquery-1.8.3.min.js"></script>

<style>
	html{margin-top: 10px;}
	table.reference.bottom {
    position: absolute;
    bottom: 0;
}
#in_form_area{width:49%;float:left}
#out_form_area{width:49%;float:right}
h1{margin-top: 10px;}
table{margin-top: 20px;margin-bottom: 20px;}
</style>
<script>
	
function page_move(num,form_name){
if(form_name=="out_form")
{
  document.out_form.page.value=num;
  document.out_form.submit();
}


if(form_name=="in_form")
{
  document.in_form.page.value=num;
  document.in_form.submit();
}
}


function page_move2(num,form_name){
if(form_name=="out_form")
{
  document.out_form.page2.value=num;
  document.out_form.submit();
}


if(form_name=="in_form")
{
  document.in_form.page2.value=num;
  document.in_form.submit();
}
}

function get_account_book()
{
	var param=$("#in_form").serialize();
	$.ajax({
		url:"/ac/ajax/get_account_book.php",
		data:param,
		dataType:"json",
		type:"POST",
		async: false,
		success:success_data
	});

}

function success_data(data)
{
	console.log(data);
	var object= [];
	var i = 0;
	object.push("<table class='reference'>");
	object.push("<tr>");
	object.push('<th>');
	object.push('수입');
	object.push('</th>');
	object.push('<th>');
	object.push('항목');
	object.push('</th>');
	object.push("</tr>");

	$.each(data.in_form,function(key,val) {
	
	object.push("<tr>");
	object.push('<td>');
	object.push(val.ab_amount);
	object.push('</td>');
	object.push('<td>');
	object.push(val.ab_contents);
	object.push('</td>');
	object.push("</tr>");
	
	i++;
	if (i%11==0)
	{
	object.push("</table>");
	object.push("<table class='reference'>");
	object.push("<tr>");
	object.push('<th>');
	object.push('수입');
	object.push('</th>');
	object.push('<th>');
	object.push('항목');
	object.push('</th>');
	object.push("</tr>");
	}
	});
	object.push("</table>");
	

	$("#in_form_area").html(object.join(""));

	i = 0;
	object= [];
	object.push("<table class='reference'>");
	object.push("<tr>");
	object.push('<th>');
	object.push('지출');
	object.push('</th>');
	object.push('<th>');
	object.push('항목');
	object.push('</th>');
	object.push("</tr>");

	$.each(data.out_form,function(key,val) {
	object.push("<tr>");
	object.push('<td>');
	object.push(val.ab_amount);
	object.push('</td>');
	object.push('<td>');
	object.push(val.ab_contents);
	object.push('</td>');
	object.push("</tr>");

	i++;
	if (i%11==0)
	{
	object.push("</table>");
	object.push("<table class='reference'>");
	object.push("<tr>");
	object.push('<th>');
	object.push('지출');
	object.push('</th>');
	object.push('<th>');
	object.push('항목');
	object.push('</th>');
	object.push("</tr>");
	}		
	});
	object.push("</table>");
	

	$("#out_form_area").html(object.join(""));
	object= [];
	object.push("<table class='reference'>");
	object.push("<tr>");
	object.push('<td>수입 합계</td>');
	object.push('<td>'+data.in_total+'</td>');
	object.push('<td>지출 합계</td>');
	object.push('<td>'+data.out_total+'</td>');
	object.push("</tr>");
	object.push("<tr>");
	object.push('<td>이월금</td>');
	object.push('<td>'+data.in_next+'</td>');
	object.push('<td>차인 금액</td>');
	object.push('<td>'+data.out_charge+'</td>');
	object.push("</tr>");
	object.push("<tr>");
	object.push('<td>합계</td>');
	object.push('<td>'+data.in_final_total+'</td>');
	object.push('<td>합계</td>');
	object.push('<td>'+data.in_final_total+'</td>');
	object.push("</tr>");	
	object.push("</table>");
	$("#bottom_area").html(object.join(""));
}

$(function() {
	get_account_book()
});
</script>
<h1 id="h1_title"><?php echo $year;?>년 <?php echo $SUBJECT['ko'][$ab_class];?> <?php echo $quater;?>분기 <?php echo $ab_class=="moderator"?"항목별 명세서":"회계보고";?>
</h1>
<?php
echo "<form name='in_form' id='in_form'>";
printf('<input type="hidden" name="ab_class" value="%s">',$ab_class);
printf('<input type="hidden" name="year"     value="%s">',$year);
printf('<input type="hidden" name="quater"   value="%s">',$quater);
printf('<input type="hidden" name="sign_yn"  value="%s">',$sign_yn);
printf('<div id="in_form_area">#in_form_area</div>');
echo "</form>";

echo "<form name='out_form'>";
printf('<input type="hidden" name="ab_class" value="%s">',$ab_class);
printf('<input type="hidden" name="year"     value="%s">',$year);
printf('<input type="hidden" name="quater"   value="%s">',$quater);
printf('<input type="hidden" name="sign_yn"  value="%s">',$sign_yn);
printf('<div id="out_form_area">#out_form_area</div>');
echo "</form>";
echo "<div style='clear:both'></div>";
echo "<div id='bottom_area'></div>";
if($page_yn=="Y"){
print "<table class=\"reference bottom\" style='width:97%;'>";
}else{
print "<table class=\"reference\" style='width:97%;margin-top:25px'>";
}
if($ab_class=="moderator")
{

}
if($sign_yn=="Y")
{
$sql=sprintf("select * from account_user where ab_class='%s'",$ab_class);

$query=$mysqli->query($sql);
$account_user=$query->fetch_assoc();

if(isset($account_user))
{
print('<td>은행이름</td>');
printf('<td>%s</td>',$account_user['au_bankname']);
print('<td>계좌번호</td>');
printf('<td>%s</td>',$account_user['au_bankno']);
print('<td>입금자명</td>');
printf('<td>%s</td>',$account_user['au_holder']);
print "</tr>";
}else{
print('<td colspan="6" style="text-align:center">계좌 정보가 없습니다.<button onclick="location.href=\'bank_modify.php\'">계좌 정보 수정</button></td>');
print "</tr>";
}
print "<tr>";
print "<td colspan='6' style='background-color:white;border-bottom:0'>";
print "<table class=\"reference\" style='width:70%;float:right;border:1px solid #ccc'>";
echo "<colgroup>";
echo "<col width='12%'>";
echo "<col width='22%'>";
echo "<col width='22%'>";
echo "<col width='22%'>";
echo "<col width='22%'>";
echo "</colgroup>";
print "	<tr>";
print "		<th rowspan='2'>결제</th>";
print "		<th>팀장</th>";
print "		<th>담당</th>";
print "		<th>담임</th>";
print "		<th>재정집행부</th>";
print "	</tr>";
print "	<tr style='height: 100px;'>";
print "		<td style='border:1px solid #ccc'></td>";
print "		<td style='border:1px solid #ccc'></td>";
print "		<td style='border:1px solid #ccc'></td>";
print "		<td style='border:1px solid #ccc'></td>";
print "	</tr>";
print "</table>";
print "</td>";
print "</tr>";
}
echo "</table>";
