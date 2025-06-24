<link rel="stylesheet" type="text/css" href="./lib/css/main.css?d=240926" media="all" />
<link rel="stylesheet" type="text/css" href="./lib/css/stdtheme.css" media="all" />
<script src="./lib/js/jquery-1.10.1.min.js"></script>
<script src="./lib/js/jquery.cookie.js"></script>
<script>	
function set_modify()
{
	var param=$("#westminster").serialize();
	$.ajax({
		url:"./set_modify.php",
		data:param,
		dataType:"json",
		type:"POST",
		success:function(data){
			if(data.success){
				alert("수정되었습니다.");
				location.href='./list.php';
			}
		}
		});
}

if(!$.cookie('bodyFontSize')){
$.cookie('bodyFontSize', 12, { expires: 30 });
}
var bodyFontSize = $.cookie('bodyFontSize');

$(document).ready(function () {

$("body,form").css({"font-size":bodyFontSize+"px"});
$(".fontBig").click(function(){
	bodyFontSize = parseInt(bodyFontSize);
	bodyFontSize = bodyFontSize + 3;
	$.cookie('bodyFontSize', bodyFontSize, { expires: 30 });
	$("body,form").css({"font-size":bodyFontSize+"px"});
});


$(".fontSmall").click(function(){
	bodyFontSize = parseInt(bodyFontSize);
	bodyFontSize = bodyFontSize - 3;
	$.cookie('bodyFontSize', bodyFontSize, { expires: 30 });
	$("body,form").css({"font-size":bodyFontSize+"px"});
});
});
</script>
<style>
body{padding: 15px;font-family: "lee_sun_shin_dotum_b";;}
textarea{margin: 0px; width: 337px; height: 239px;}
/* 게시판용 버튼 */
.btn{
 display:inline-block;
 border:0px solid #fff;
 color:#fff !important;
 background:#ccc;
 padding:5px 5px 2px 5px;
 border-radius:5px;
 font-size: 9pt;
 text-decoration:none;
 cursor:pointer
}
.btn:focus,.btn:hover {text-decoration:none}

.btn_lg{padding:15px;padding-right:18px;font-size:15pt !important;}
.btn_md{padding:10px;padding-right:13px;font-size:12pt !important;}
.btn_sm{padding:8px;padding-right:10px;font-size:10pt !important;}

.btn_primary{background:#1c84c6;}
.btn_warning{background:#f7ac59;}
.btn_danger{background:#ed5565;}
.btn_success{background:#5cb85c;}
.btn_info{background:#5bc0de;}
.btn_black{background:#292b2c;}
.btn_secondary{background:#fff;color:#652b67 !important;border:1px solid #ccc ;}
.wm_content{
    line-height: 2.9;
    padding: 25px;}

.ml90{margin-left: 90px;}
p{text-indent:70px;}

sup{font-size:large !important;}
 </style>
 </head>
 <body>

</style>
<?php
include "./db_con.php";

include_once "./subject.php";

$sql=sprintf("select * from `westminster_confession` where wm_no='%s';",$wm_no);
$query=$mysqli->query($sql);
$view=$query->fetch_assoc();


$sql=sprintf("select wm_no from `westminster_confession` where wm_no<'%s' order by wm_no desc limit 1;",$wm_no);

$query=$mysqli->query($sql);
$pre=$query->fetch_assoc();
$sql=sprintf("select wm_no from `westminster_confession` where wm_no>'%s' limit 1;",$wm_no);

$query=$mysqli->query($sql);
$ord=$query->fetch_assoc();

if($pre)
{
	printf("<a href='./view.php?wm_no=%s' class='btn btn_lg btn_primary'>이전</a>",$pre['wm_no']);
}else{	
	echo "<a class='btn btn_lg btn_danger'>이전이 없습니다.</a>";
}

if($ord)
{
	printf("<a href='./view.php?wm_no=%s' class='btn btn_lg btn_primary'>다음</a>",$ord['wm_no']);
}else{	
	echo "<a class='btn btn_lg btn_danger'>다음이 없습니다.</a>";
}

print("<a class='btn btn_lg btn_warning fontSmall'>작게</a>");
print("<a class='btn btn_lg btn_danger fontBig'>크게</a>");

echo "<form id='westminster'>";
echo sprintf("<input type='hidden' name='wm_no' value='%s'>",$view['wm_no']);
echo "<input type='hidden' name='table' value='westminster_confession'>";
echo '보드번호 : ';
echo $view['wm_no'];
echo '<hr>';
echo $view['wm_chapter'];echo '장';
echo "&nbsp;".$SUBJECT['ko']["제".$view['wm_chapter']."장"];
echo '(';
echo $SUBJECT['en']["제".$view['wm_chapter']."장"];
echo ')';
echo '<hr>';
echo "".$view['wm_clause'];echo '항&nbsp;';
echo $view['wm_subject'];
echo '<hr>';	
echo '내용 : ';
echo '<hr>';
echo "<div class='westminster_blacktheme'>";
echo preg_replace("/(\d+)\)/", "<sup>$1)</sup>", nl2br($view['wm_content']));;
echo '</div><!-- .westminster_blacktheme -->';
echo '<hr>';
echo '내용(영문) : ';
echo '<hr>';
echo nl2br($view['wm_content_eng']);
echo '<hr>';	

echo '관련구절 : ';
echo '<hr>';
echo "<div class='westminster_blacktheme'>";
echo nl2br($view['wm_relparse']);
echo '</div><!-- .westminster_blacktheme -->';
echo '<hr>';
echo "</div>";
echo '관련구절 (영문) : ';
echo '<hr>';
echo nl2br($view['wm_relparse_eng']);
echo '<hr>';

echo '해설 : ';
echo '<hr>';
echo nl2br($view['wm_commentary']);
echo '<hr>';	
echo '해설 (영문) : ';
echo '<hr>';
echo nl2br($view['wm_commentary_eng']);
echo '<hr>';

if($pre)
{
	printf("<a href='./view.php?wm_no=%s' class='btn btn_lg btn_primary'>이전</a>",$pre['wm_no']);
}else{	
	echo "<a class='btn btn_lg btn_danger'>이전이 없습니다.</a>";
}

if($ord)
{
	printf("<a href='./view.php?wm_no=%s' class='btn btn_lg btn_primary'>다음</a>",$ord['wm_no']);
}else{	
	echo "<a class='btn btn_lg btn_danger'>다음이 없습니다.</a>";
}

print("<a class='btn btn_lg btn_warning fontSmall'>작게</a>");
print("<a class='btn btn_lg btn_danger fontBig'>크게</a>");
if(!$is_block_ip)
echo sprintf("<input  class='btn btn_lg btn_primary' type='button' value='수정' onclick=\"location.href='./modify.php?wm_no=%s'\">",$view['wm_no']);

echo "<input  class='btn btn_lg btn_primary' type='button' value='리스트' onclick=\"location.href='./list.php'\">";
?>