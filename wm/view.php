<link rel="stylesheet" type="text/css" href="./lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./lib/css/stdtheme.css" media="all" />
<script src="./lib/js/jquery-1.10.1.min.js"></script>

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
</script>
<style>
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
	printf("<a href='./view.php?wm_no=%s' class='btn btn_primary'>이전</a>",$pre['wm_no']);
}else{	
	echo "<a class='btn btn_danger'>이전이 없습니다.</a>";
}

if($ord)
{
	printf("<a href='./view.php?wm_no=%s' class='btn btn_primary'>다음</a>",$ord['wm_no']);
}else{	
	echo "<a class='btn btn_danger'>다음이 없습니다.</a>";
}
echo "<form id='westminster'>";
echo sprintf("<input type='hidden' name='wm_no' value='%s'>",$view['wm_no']);
echo "<input type='hidden' name='table' value='westminster_confession'>";
echo '<table class="ibk_info">';
echo '<tr>';
echo '<th>보드번호</th><th>';
echo $view['wm_no'];
echo '</th></tr>';	
echo '<tr>';
echo '<td>장</td><td>';
echo $view['wm_chapter'];
echo '장</th></tr>';	
echo '<tr>';
echo '<td>장제목 [한글]</td><td>';
echo $SUBJECT['ko']["제".$view['wm_chapter']."장"];
echo '</th></tr>';	
echo '<tr>';
echo '<td>장제목 [영문]</td><td>';
echo $SUBJECT['en']["제".$view['wm_chapter']."장"];
echo '</th></tr>';	
echo '<tr>';
echo '<td>항</td><td>';
echo $view['wm_clause'];
echo '항</th></tr>';	
echo '<tr>';
echo '<td>제목</td><td>';
echo $view['wm_subject'];
echo '</th></tr>';	
echo '<tr>';
echo '<td>내용</td><td>';
echo nl2br($view['wm_content']);
echo '</th></tr>';	

echo '<tr>';
echo '<td>관련구절</td><td>';
echo nl2br($view['wm_relparse']);
echo "</td></tr>";

echo '<tr>';
echo '<td>해설</td><td>';
echo nl2br($view['wm_commentary']);
echo '</th></tr>';	
echo '<tr>';

echo "</table>";
if($pre)
{
	printf("<a href='./view.php?wm_no=%s' class='btn btn_primary'>이전</a>",$pre['wm_no']);
}else{	
	echo "<a class='btn btn_danger'>이전이 없습니다.</a>";
}

if($ord)
{
	printf("<a href='./view.php?wm_no=%s' class='btn btn_primary'>다음</a>",$ord['wm_no']);
}else{	
	echo "<a class='btn btn_danger'>다음이 없습니다.</a>";
}


echo sprintf("<input type='button' value='수정' onclick=\"location.href='./modify.php?wm_no=%s'\">",$view['wm_no']);

echo "<input type='button' value='리스트' onclick=\"location.href='./list.php'\">";
?>