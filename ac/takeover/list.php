<?php
include_once "../db_con.php";
include_once($_SERVER['DOCUMENT_ROOT'].'/wp/common.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/ac/commons.php');
?>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<script src="/wp/js/jquery-1.8.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="/wm/lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="/wm/lib/css/stdtheme.css" media="all" />
<style>
	img{width:100%}
	.icons{background:url('//cashq.co.kr/img/admin/common/cashq_icon.png') no-repeat;width:14px;height:14px;display:inline-block;padding-right:3px;}
.isimg{background-position:-220px -195px;padding-right: 0;}
td{text-align: center;}	
</style>
<script>
	function set_takeover(n)
	{
		var at_no= n;
		$.ajax({
			url:"./ajax/set_takeover.php",
			dataType:"json",
			data:'at_no='+at_no,
			type:"POST",
			success:function(data){
				if(data.success){
					alert("인수인계 성공");
					//location.href='/ac/';
				}
			}
		});	
	}
</script>
<?php
$listsize=15;
$pagesize=10;
$firstNum =0;
$page = isset($page)&&$page!=""?$page:1;
$firstNum = ($page-1)*$listsize;


printf('<input type="hidden" name="page"     value="%s">',$page);

$where=empty($where)?"":$where;
if(!empty($keyword))
{
	$where = sprintf(" and ab_contents like '%%%s%%' ",$keyword);
}

$sql=sprintf("select * from newezra.account_takeover where 1=1 %s order by at_datetime desc limit %s,15",$where,$firstNum);
$query=$mysqli->query($sql);

$count_sql="select count(*) cnt from account_takeover where 1=1 ";
if(!empty($keyword)){
$count_sql.=sprintf(" and ab_contents like '%%%s%%' ",$keyword);
}

if(!$is_admin){
	$count_sql.=sprintf(" and ab_class='%s' ",$executive['ab_class']);
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
printf("<input type='button' value='쓰기' onclick=\"location.href='./write2.php?ab_class=%s'\">",$executive['ab_class']);
}
echo "<table class='reference'>";
echo "<tr>";
printf('<th>%s</th>','at_no');
printf('<th>%s</th>','mb_id');
printf('<th>%s</th>','au_id');
printf('<th>%s</th>','at_status');
printf('<th>%s</th>','ab_class');
printf('<th>%s</th>','au_bankname');
printf('<th>%s</th>','au_bankno');
printf('<th>%s</th>','au_holder');
printf('<th>%s</th>','at_content');
printf('<th>%s</th>','at_datetime');
printf('<th>%s</th>','at_accept_datetime');
printf('<th>%s</th>','at_deny_datetime');
printf('<th>%s</th>','변경');
echo "</tr>";
while($list=$query->fetch_assoc()){
print "<tr>";
printf('<td>%s</td>',$list['at_no']);
printf('<td>%s</td>',$list['mb_id']);
printf('<td>%s</td>',$list['au_id']);
printf('<td>%s</td>',$list['at_status']);
printf('<td>%s</td>',$list['ab_class']);
printf('<td>%s</td>',$list['au_bankname']);
printf('<td>%s</td>',$list['au_bankno']);
printf('<td>%s</td>',$list['au_holder']);
printf('<td>%s</td>',$list['at_content']);
printf('<td>%s</td>',$list['at_datetime']);
printf('<td>%s</td>',$list['at_accept_datetime']);
printf('<td>%s</td>',$list['at_deny_datetime']);
if($list['at_status']=="reception")
{
	printf("<td><input type='button' onclick='javascript:set_takeover(%s)' value='인수인계'></td>",$list['at_no']);
}else{
	printf('<td>%s</td>',"완료");	
}
print "</tr>";
if($querys->num_rows>0){
$pages = array();
while($image_list=$querys->fetch_assoc()){
$pages[] = sprintf("/upload/%s/%s/%s_%s/%s",$image_list['ab_class'],$image_list['bf_date'],$image_list['ab_no'],$image_list['bf_no'],$image_list['bf_file']);
}
$arr_pages="['".join("','",$pages)."']";
//"['/upload/media/20230627/211_0/1687871717_1417374394.png']"
printf('<td><span onclick="javascript:bottom_view($(this).parent().parent().index(),%s)">%s <span class="icons isimg"></span> %s</span></td>',$arr_pages,$list['ab_contents'],$querys->num_rows>1?" x ".$querys->num_rows:"");
}
print "</tr>";

}
	if($query->num_rows==0)
	{
		printf("<tr><td colspan='5' class='tac'>\"%s\"로 검색된 결과가 없습니다.</td></tr>",$keyword);
	}

echo "</table>";

