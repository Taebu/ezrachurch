<?php
include_once "./db_con.php";
include_once "./subject.php";
include_once($_SERVER['DOCUMENT_ROOT'].'/wp/common.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/ac/commons.php');

$sst=isset($sst)&&strlen($sst)>0?$sst:"ab_date";
$sod=isset($sod)&&strlen($sod)>0?$sod:"desc";
?>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

<script src="/wm/lib/js/jquery-1.10.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="/wm/lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/ac/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all" />
<style>
.reference img{width:500px;float: left;margin-right: 15px;}
	.icons{background:url('/ac/lib/image/cashq_icon.png') no-repeat;width:14px;height:14px;display:inline-block;padding-right:3px;}
.isimg{background-position:-220px -195px;padding-right: 0;}
td{text-align: center;}	

h1,td{font-family: 'Godo';}
</style>
<script>
function set_delete(ab_no)
{
		$.ajax({
			url:"./delete.php",
			dataType:"json",
			type:"GET",
            data:{'ab_no':ab_no},
            success:function(data){

			if(data.success){
				alert("삭제되었습니다.");
				location.href='./list.php';
			}else{
					alert(data.message);
				}
			}
		});
}

var stackv=-1;

  /*
fn bottomview(v,i1,i2){..}
lazy loading 착안 html로드후 해당 업소명을 클릭 했을 때만 이미지를 로드.
@v	해당 테이블의 위치 row
@i1	이미지1 파일 이름
@i2	이미지2 파일 이름
return void;
*/
function bottom_view(v,img_arr)
{
var is_not_image= img_arr.length==0;
console.log(img_arr);
console.log("view data -> "+v+" : "+stackv);
if(v>stackv&&$(".bd_info").length=="1"){
v--;
console.log("-? view data -> "+v+" : "+stackv);
}


	if(stackv==v&&$(".bd_info").length=="1"){
	$(".bd_info").parent().remove();
	return;
	}
	$(".bd_info").parent().remove();
		var object=[];
		object.push("<tr><td class='bd_info' colspan='13'>");
		object.push("<span onclick=\"javascript:bottom_view($(this).parent().parent().index(),[]);\">");
		
		if(is_not_image)
		{
			object.push("no image");
		}
		$.each(img_arr,function(key,val){

		object.push("<img src='"+val+"'>");
		});
		object.push("</span>");
		object.push("</td></tr>");
		$(".reference > tbody > tr").eq(v).after(object.join(''));
		
stackv=v;
}	



    function page_move(num, form_name) {
        if (form_name == "out_form") {
            document.out_form.page.value = num;
            document.out_form.submit();
        }

        if (form_name == "in_form") {
            document.in_form.page.value = num;
            document.in_form.submit();
        }
    }

    function page_move2(num, form_name) {
        if (form_name == "out_form") {
            document.out_form.page2.value = num;
            document.out_form.submit();
        }

        if (form_name == "in_form") {
            document.in_form.page2.value = num;
            document.in_form.submit();
        }
    }
</script>

<?php
$listsize=15;
$pagesize=10;
$firstNum =0;
$page = isset($page)&&$page!=""?$page:1;
$firstNum = ($page-1)*$listsize;


print("<form method='POST' name='out_form'>");
printf('<input type="hidden" name="page"     value="%s">',$page);
function change_type($key)
{
	
	$array = array();
	$array['In']="입금";
	$array['Out']="출금";
	$array['Expenditure']="지출결의";
	$array['Budget']="예산신청액";
	$array['BudgetPlan']="내년예산안";

	if (array_key_exists($key, $array)) {
		$result=$array[$key];
	}else{
		$result="알수 없는 코드";
	}
	return $result;
}

$where=empty($where)?"":$where;
if(!empty($keyword))
{
	$where = sprintf(" and ab_contents like '%%%s%%' ",$keyword);
}

$order = "order by ab_no desc ";
if(isset($sst)&&isset($sod))
{
	$order = sprintf("order by  %s %s",$sst,$sod);	
}
if($is_admin){
	$sql=sprintf("select * from account_book where 1=1 %s %s limit %s,15",$where,$order,$firstNum);
}else if($is_multiple) {
	$sql=sprintf("select * from account_book where ab_class in ('%s') %s %s  limit %s,15",join("','",$array_multiple_class),$where,$order,$firstNum);
}else{
	$sql=sprintf("select * from account_book where ab_class='%s' %s %s  limit %s,15",$executive['ab_class'],$where,$order,$firstNum);
}
$query=$mysqli->query($sql);


$count_sql="select count(*) cnt from account_book where 1=1 ";
if(!empty($keyword)){
$count_sql.=sprintf(" and ab_contents like '%%%s%%' ",$keyword);
}

if(!$is_admin&&!$is_multiple){
	$count_sql.=sprintf(" and ab_class='%s' ",$executive['ab_class']);
}else if(!$is_admin&&$is_multiple) {
$count_sql.=sprintf(" and ab_class in ('%s')  ",join("','",$array_multiple_class));
}
$count_query=$mysqli->query($count_sql);
$cnt=$count_query->fetch_assoc();
$cnt = $cnt['cnt'];

$lnum2 = ceil($cnt/$listsize);
$fnum = ((int)(($page-1)/$pagesize)*$pagesize)+1;
$lnum = ((int)(($page-1)/$pagesize)*$pagesize)+$pagesize;

if($lnum2<$lnum)
{
	$lnum= $lnum2;
}


if(!empty($keyword))
{
printf('<input type="text" name="keyword" id="" value="%s">',$keyword);
echo '<input type="submit" value="검색">';
printf("<tr><td colspan='5' class='tac'>\"%s\"로 검색된 결과 %d개 검색 되었습니다.</td></tr>",$keyword,$cnt);
}else{
print('<input type="text" name="keyword" id="" value="" placeholder="검색어를 입력 해 주세요.">');
echo '<input type="submit" value="검색">';
}
echo "<br>";
if($is_admin){
print("<input type='button' value='쓰기' onclick=\"location.href='./write2.php'\">");
}else{
	if($is_multiple)
	{
		foreach($array_multiple_class as $key=>$value)
		{
			printf("<input type='button' value='%s 쓰기' onclick=\"location.href='./write2.php?ab_class=%s'\">",$value,$value);
		}
	}else{
		printf("<input type='button' value='쓰기' onclick=\"location.href='./write2.php?ab_class=%s'\">",$executive['ab_class']);
	}
}
$sod2=$sod=="desc"?"asc":"desc";
$symbol=$sod=="desc"?"▼":"▲";

echo "<input type='button' value='csv import' onclick=\"location.href='/ac/csv/file.php'\">";
echo "<table class='reference'>";
echo "<tr>";
printf("<th><a href='/ac/list.php?sst=ab_no&sod=%s'>ab_no %s</a></th>",$sod2,$symbol);
echo "<th>class</th>";
printf("<th><a href='/ac/list.php?sst=ab_date&sod=%s'>ab_date %s</a></th>",$sod2,$symbol);
printf("<th><a href='/ac/list.php?sst=ab_type&sod=%s'>ab_type %s</a></th>",$sod2,$symbol);
printf("<th><a href='/ac/list.php?sst=ab_amount&sod=%s'>ab_amount %s</a></th>",$sod2,$symbol);
printf("<th><a href='/ac/list.php?sst=ab_contents&sod=%s'>ab_contents %s</a></th>",$sod2,$symbol);
printf("<th><a href='/ac/list.php?sst=ab_datetime&sod=%s'>ab_datetime %s</a></th>",$sod2,$symbol);
echo "<th>datetime</th>";
echo "<th>datetime</th>";
echo "</tr>";
while($list=$query->fetch_assoc()){
	$sqls=sprintf("select * from account_image_file where ab_no='%s';",$list['ab_no']);
	$querys=$mysqli->query($sqls);
$ab_class=$list['ab_class'];
print "<tr>";
printf('<td>%s</td>',$list['ab_no']);
printf('<td>%s(%s)</td>',$SUBJECT["ko"][$ab_class],$ab_class);
printf('<td>%s</td>',$list['ab_date']);
printf('<td>%s</td>',change_type($list['ab_type']));
if($list['ab_type']=="In"||$list['ab_type']=="Budget")
	printf('<td class="blue">%s</td>',number_format($list['ab_amount']));
else
	printf('<td>-%s</td>',number_format($list['ab_amount']));
if($querys->num_rows>0){
$pages = array();
while($image_list=$querys->fetch_assoc()){
$pages[] = sprintf("/upload/%s/%s/%s_%s/%s",$image_list['ab_class'],$image_list['bf_date'],$image_list['ab_no'],$image_list['bf_no'],$image_list['bf_file']);
}
$arr_pages="['".join("','",$pages)."']";
//"['/upload/media/20230627/211_0/1687871717_1417374394.png']"
printf('<td><span onclick="javascript:bottom_view($(this).parent().parent().index(),%s)">%s <span class="icons isimg"></span> %s</span></td>',$arr_pages,$list['ab_contents'],$querys->num_rows>1?" x ".$querys->num_rows:"");
}else{
printf('<td>%s</td>',$list['ab_contents']);
}
printf('<td>%s</td>',$list['ab_datetime']);
printf("<td><a href='./modify2.php?ab_no=%s'>수정</a></td>",$list['ab_no']);
printf("<td><a href='javascript:set_delete(%s);'>삭제</a></td>",$list['ab_no']);
print "</tr>";

}
	if($query->num_rows==0)
	{
		printf("<tr><td colspan='5' class='tac'>\"%s\"로 검색된 결과가 없습니다.</td></tr>",$keyword);
	}

echo "</table>";

if($cnt>10){
print "<tr style='background: white;border-bottom: 0px;'>";
print('<td colspan=3 style="border-bottom: 0;">');
echo paging($page,$cnt);
print('</td>');
print "</tr>";
}
if($is_admin){
print("<input type='button' value='쓰기' onclick=\"location.href='./write2.php'\">");
}else{
	if($is_multiple)
	{

		foreach($array_multiple_class as $key=>$value)
		{
		
			printf("<input type='button' value='%s 쓰기' onclick=\"location.href='./write2.php?ab_class=%s'\">",$value,$value);
		}
	}else{
		printf("<input type='button' value='쓰기' onclick=\"location.href='./write2.php?ab_class=%s'\">",$executive['ab_class']);
	}
}
echo "<input type='button' value='csv import' onclick=\"location.href='/ac/csv/file.php'\">";

$year="2025";
$quater="2";

echo "<input type='button' value='통계' onclick=\"location.href='./total.php'\">";
printf("<input type='button' value='슬라이드 보고서'  onclick=\"location.href='./test.php?year=%s&quater=%s'\">",$year,$quater);
printf("<input type='button' value='스크롤 보고서' onclick=\"location.href='./print/%s/%s'\">",$year,$quater);
print "<br>";
echo "<table class='reference tac'>";

echo "<tr>";
print("<th>팀</th>");
print("<th>회계보고</th>");
print("<th>지출결의서</th>");
print("<th>내년예산안</th>");
print("<th>연간예산사용결과</th>");
print("<th>영수증</th>");
print("<th>회계보고(사인란)</th>");
print("<th>지출결의서(사인란)</th>");
echo "</tr>";
foreach($SUBJECT['ko'] as $key =>$value)
{
	if($is_admin||$key==$executive['ab_class']||in_array($key,$array_multiple_class))
	{
		echo "<tr>";
		printf("<td>%s</td>",$value);
		printf("<td><input type='button' value='Go' onclick=\"location.href='%s/%s/%s/%s'\"></td>","/ac/report",$key,$year,$quater);
		printf("<td><input type='button' value='Go' onclick=\"location.href='%s/%s/%s/%s'\"></td>","/ac/next",$key,$year,$quater);
		printf("<td><input type='button' value='Go' onclick=\"location.href='%s/%s/%s/%s'\"></td>","/ac/budget_plan",$key,$year,$quater);
		printf("<td><input type='button' value='Go' onclick=\"location.href='%s/%s/%s'\"></td>","/ac/settlement",$key,$year);
		printf("<td><input type='button' value='Go' onclick=\"location.href='%s/%s/%s/%s'\"></td>","/ac/receipt",$key,$year,$quater);
		printf("<td><input type='button' value='Go' onclick=\"location.href='%s?ab_class=%s&year=%s&quater=%s&sign_yn=Y&page_yn=N'\"></td>","/ac/report.php",$key,$year,$quater);
		printf("<td><input type='button' value='Go' onclick=\"location.href='%s?ab_class=%s&year=%s&quater=%s&sign_yn=Y&page_yn=N'\"></td>","/ac/next_quater.php",$key,$year,$quater);
		echo "</tr>";
	}
}
echo "</table>";
