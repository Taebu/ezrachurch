<?php
include_once "./db_con.php";
include_once "../wp/common.php";

$create_table ='CREATE TABLE IF NOT EXISTS  `schedule` (
`no` int(10) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(50) DEFAULT NULL,
`memo` varchar(200) DEFAULT NULL,
`frdt` varchar(10) DEFAULT NULL,
`todt` varchar(10) DEFAULT NULL,
`insdt` varchar(20) DEFAULT NULL,
PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;';

dbquery($create_table);

$yy = isset($_REQUEST['yy'])?$_REQUEST['yy']:date('Y');
$mm = isset($_REQUEST['mm'])?$_REQUEST['mm']:date('m');

function sel_yy($yy, $func) {
	if($yy == '') $yy = date('Y');

	if($func=='') {
		$str = "<select name='yy' id='yy'>\n<option value=''></option>\n";
	} else {
		$str = "<select name='yy' id='yy' onChange='$func'>\n<option value=''></option>\n";
	}
	$gijun = date('Y');
	$start_year= $gijun-5;
	$end_year= $gijun+5;
	for($i=$start_year;$i<$end_year;$i++) {
		if($yy == $i) $str .= "<option value='$i' selected>$i</option>";
		else $str .= "<option value='$i'>$i</option>";
	}
	$str .= "</select>";
	return $str;
}

function sel_mm($mm, $func) {
	if($func=='') {
		$str = "<select name='mm' id='mm'>\n";
	} else {
		$str = "<select name='mm' id='mm' onChange='$func'>\n";
	}
	for($i=1;$i<13;$i++) {
		if($mm == $i) $str .= sprintf("<option value='%s' selected>%s</option>",$i,$i);
		else $str .= sprintf("<option value='%s'>%s</option>",$i,$i);
	}
	$str .= "</select>";
	return $str;
}
$temp_name ="";
function get_schedule($yy,$mm,$dd) {
	global $temp_name;
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
	$dd = str_pad($dd, 2, "0", STR_PAD_LEFT);
	$dtstr = $yy."-".$mm."-".$dd;
	$is_rep = false;
	$str="";
	$sql = sprintf("SELECT * FROM schedule WHERE frdt <= '%s' AND todt >= '%s' ORDER BY frdt, todt",$dtstr,$dtstr);
	$query = dbquery($sql);
	
	while($list=$query->fetch_assoc()){
		$is_rep = false;
		if($list['frdt']!=$list['todt'])
		{
			$from = new DateTime($dtstr);
			$to = new DateTime($list['todt']);
			$diff=date_diff( $from, $to );
			$mod_day=$diff->days+1;
			if(date('w',strtotime($dtstr))==5&&$mod_day>2){
				$mod_day=2;
			}
			
			if(date('w',strtotime($dtstr))==6&&$mod_day>1){
				$mod_day=1;
			}

			if($temp_name!=$list['name']&&$dtstr!=$list['todt']||date("w",strtotime(date($dtstr)))==0)
			{
				$str .= sprintf("<div class='rep rep_%s'>",$mod_day);
				$is_rep = true;
			}else{
				$str .= "<div class='rep'>";
			}
		}
		if($temp_name!=$list['name']||date("w",strtotime(date($dtstr)))==0)
		if((date("w",strtotime(date($dtstr)))==0||$list['holiday']=="Y")&&!$is_rep){
		$str .= sprintf("<span class='red'>%s</span><br>",$list['name']);
//		$str .= sprintf("%s<br>",$list['name']);
		}else{
		$str .= sprintf("%s<br>",$list['name']);
		}
		if(isset($list['memo'])&&strlen($list['memo'])>0){
		$str .= sprintf("%s<br>",$list['memo']);
		}
		if($list['frdt']!=$list['todt'])
		{
			$str .= "</div>";
		}
		$temp_name=$list['name'];
	}
	return $str;
}


// 1. 총일수 구하기
$last_day = date("t", strtotime($yy."-".$mm."-01"));

// 2. 시작요일 구하기
$start_week = date("w", strtotime($yy."-".$mm."-01"));

// 3. 총 몇 주인지 구하기
$total_week = ceil(($last_day + $start_week) / 7);

// 4. 마지막 요일 구하기
$last_week = date('w', strtotime($yy."-".$mm."-".$last_day));
?>
<style>
th{width:130px;height:30px;text-align:center;background-color:#DDDDDD;font-weight: 900;}
td{width:130px;height:130px;text-align:left;vertical-align:top;background:rgba(255,255,255,0.9);position:relative;}
td.theader{height: 50px;text-align: center;background:rgba(255,255,255,0.9);}
.red{color: red;font-weight: 900;}
.blue{color: blue;}
.rep{
	background-color: #595959;
	color: white !important;
	position:absolute; 
	bottom:0; 
	left:0;
	width:100%;
	border:2px solid #fff;
	display:none;
	text-align:center;
	z-index: 1;
}
 table{
	background-image: url('/wp/data/file/gallery_01/3745449536_AFNrvSRG_78ebee2be014484aed42f72d0b193b353f9cb000.jpg');
	margin:0 auto;
	background-position: center;
	background-repeat: no-repeat;
	background-size: contain;
}

.rep_1{width:98%;display:block}
.rep_2{width:199%;display:block}
.rep_3{width:299%;display:block}
.rep_4{width:399%;display:block}
.rep_5{width:499%;display:block}
.rep_6{width:599%;display:block}
.rep_7{width:699%;display:block}

.pre, .next{width: 35px;float: left;cursor:pointer;position:relative;}
.pre{top: 0;left: 0;position: fixed;z-index:1;padding: 5px;}
.next{top: 0;right: 0;position: fixed;z-index:1;padding: 5px;}
.btn_pre, .btn_next{position: absolute;top:50%}
.this_day{background-color:#ccccccee;}
</style>
<script src="/wm/lib/js/jquery-1.10.1.min.js"></script>
<script src="./moment.js"></script>
<meta charset="UTF-8">
<script src="https://kit.fontawesome.com/3235d0fc48.js" crossorigin="anonymous"></script>

<body>

</body>

<form name="form" method="get">
<div class="wrap">
<div class="navigator">
<div class="pre">
<span class="btn_pre"><i class="fa-solid fa-circle-chevron-left"></i></span>

</div><!-- .pre -->
<div class="container">
<table cellpadding='0' cellspacing='1' bgcolor="#999999" id="cal_table">
<tr>
<td colspan="7" class="theader">
<a href="/"><i class="fa-solid fa-house"></i></a>
<?php echo sel_yy($yy,'submit();')?>년 <?php echo sel_mm($mm,'submit();')?>월 <input type="submit" value="달력보기">
<?php
if($is_admin){
echo '<a href="./list.php"><i class="fa-solid fa-list"></i></a> ';
echo '<a href="./write.php" style="font-size:32px"><i class="fa-regular fa-pen-to-square"></i></a>';
}?>
<a href="javascript:set_play()" ><i class="fa-solid fa-sync fa-spin" aria-hidden="true" id="fa_spin"></i></a>
<a href="javascript:change_calendar_image()" ><i class="fa-solid fa-play" aria-hidden="true"></i></a>
투명도 : <select name="opacity" id="opacity" onchange="javascript:set_opacity(this.value)">
	<option value='100'>100</option>
	<option value='90' selected>90</option>
	<option value='80'>80</option>
	<option value='70'>70</option>
	<option value='60'>60</option>
	<option value='50'>50</option>
	<option value='40'>40</option>
	<option value='30'>30</option>
	<option value='20'>20</option>
	<option value='10'>10</option>
	<option value='10'>0</option>
</select>
<p id="time">2012-02-12 00:00:00</p>
</td>
</tr>
<tr>
<th>일</th>
<th>월</th>
<th>화</th>
<th>수</th>
<th>목</th>
<th>금</th>
<th>토</th>
</tr>
<?php
$today_yy = date('Y');
$today_mm = date('m');
// 5. 화면에 표시할 화면의 초기값을 1로 설정
$day=1;
$last_days = 1;
// 6. 총 주 수에 맞춰서 세로줄 만들기
for($i=1; $i <= $total_week; $i++)
{
	
	print '<tr>';
	// 7. 총 가로칸 만들기
	for ($j=0; $j<7; $j++)
	{

		print ('<td>');
		// 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않아야하므로
		//    그 반대의 경우 -  ! 으로 표현 - 에만 날자를 표시한다.
		if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week)))
		{

			if($j == 0){
				// 9. $j가 0이면 일요일이므로 빨간색
				echo "<span class='red'><b>";
			}else if($j == 6){
				// 10. $j가 0이면 일요일이므로 파란색
				echo "<span class='blue'><b>";
			}else{
				// 11. 그외는 평일이므로 검정색
				echo "<span><b>";
			}

			// 12. 오늘 날자면 굵은 글씨
			if($today_yy == $yy && $today_mm == $mm && $day == date("j")){
				echo "<span class='today'>";
			}
			
			// 13. 날자 출력
			echo $day;

			if($today_yy == $yy && $today_mm == $mm && $day == date("j")){
				echo "</span>";
			}

			echo "</b></span> &nbsp;";

			
			//스케줄 출력
			$schstr = get_schedule($yy,$mm,$day);
			echo $schstr;

			// 14. 날자 증가
			$day++;
		}

		// 2024-12-14 토요일 22:36:19 
		// 8.1. 첫주에 이전달 일정도 출력하는 경우가 있어서 첫주를 기준으로 요일 기호를 뺀 기준으로 연산 일정을 출력.  
		if ($i == 1 && $j < $start_week)
		{
			// 첫째 날을 기준으로 주차의 숫자를 -만큼 지우기 
			$relative_day=sprintf("%s-%s-01 -%d day",$yy,$mm,$start_week-$j);
			$start_date=date("Y-m-d",strtotime($relative_day));
			$start_date=date_parse($start_date);
			$font_color=$j==0?"<span class='red'>":"<b>";
			printf("%s%02d-%02d ",$font_color,$start_date['month'],$start_date['day']);
			$schstr = get_schedule($start_date['year'],$start_date['month'],$start_date['day']);
			echo $schstr;
		}

		// 2024-12-14 토요일 22:36:19 
		// 8.2. 마지막주에 다음달 일정도 출력하는 경우가 있어서 마지막날을 기준으로 1씩 더해 연산 일정을 출력. 
		if($i == $total_week && $j > $last_week)
		{
			// 마지막 날을 기준으로 1씩 더함.
			$relative_day=sprintf("%s-%s-%s +%d day",$yy,$mm,$last_day,$last_days);
			$end_date=date("Y-m-d",strtotime($relative_day));
			$end_date=date_parse($end_date);
			$font_color=$j==0?"<span class='red'>":"<b>";
			printf("%s%02d-%02d",$font_color,$end_date['month'],$end_date['day']);
			$schstr = get_schedule($end_date['year'],$end_date['month'],$end_date['day']);
			echo $schstr;
			$last_days++;
		}

		print '</td>';
	}
	print '</tr>';
}
?>
</table> 
</div>
<div class="next"><span class="btn_next"><i class="fa-solid fa-circle-chevron-right"></i></span></div><!-- .next -->
</div>
</form>


<script type="text/javascript">

$(window).load(function () {
var yy = $("#yy").val();
var mm = $("#mm").val();
var current_date = yy+"-"+String(mm).padStart(2,'0')+"-01";
var now = new Date(current_date);


$(document).on("click", ".pre", function () {
	var past = now.setMonth(now.getMonth() -1);
	mm=now.getMonth()+1;

	location.href="/reserve/cal.php?yy="+now.getFullYear()+"&mm="+mm;
});

$(document).on("click", ".next", function () {
	var future = now.setMonth(now.getMonth() +1);
	mm=now.getMonth()+1;
	location.href="/reserve/cal.php?yy="+now.getFullYear()+"&mm="+mm;
});

// 모두가 로딩 된 후 #cal_table 테이블에 높이를 .pre, .next 높이와 일치 시킨다.
$(".pre").height($("#cal_table").height());
$(".next").height($("#cal_table").height());

// .today를 찾아서 부모 객체에 td 를 찾아 this_day 클래스를 추가 시킨다.
$(".today").closest('td').addClass("this_day");

// .red를 찾아 부모의 객체로 올라가고 span 태그를 찾아서 red class를 추가 하고 blue 클래스는 제거한다.
$(".red").parent().find('span').addClass("red").removeClass("blue");

// window의 너비를 구하여 95 뺀 나머지를 window_width에 이항한다.
var window_width = $(window).width()-95;

// #cal_table 너비에 window_width 값을 넣는다.
$("#cal_table").width(window_width);


$(".fa-solid").css({'font-size':'30px'});

//get_calendar_image();
});



var timestamp = '<?php echo time();?>';
var image_json = "";
function updateTime(){
  $('#time').html(moment().format('YYYY-MM-DD A h:mm:ss'));
  timestamp++;
}
$(function(){
  setInterval(updateTime, 1000);
});

function get_calendar_image()
{
	$.ajax({
		url:"./image_file.php",
		dataType:"json",
		success:function(data){
			image_json = data;
			change_calendar_image();
		}
	});
}

function change_calendar_image()
{
	var random_value=0;
	var key =getRandomInt(0,7);
	if(key==0)
	{
		random_value=getRandomInt(0,image_json.images.length);
		$("#cal_table").css("background-image","url('/wp/data/file/gallery_01/"+image_json.images[random_value]+"')");
	}else if(key==1){
		random_value=getRandomInt(0,image_json.bsc_gallery.length);
		$("#cal_table").css("background-image","url('/wp/data/file/bsc_gallery/"+image_json.bsc_gallery[random_value]+"')");
	}else if(key==2){
		random_value=getRandomInt(0,image_json.gallery_02.length);
		$("#cal_table").css("background-image","url('/wp/data/file/gallery_02/"+image_json.gallery_02[random_value]+"')");
	}else if(key==3){
		random_value=getRandomInt(0,image_json.gallery_03.length);
		$("#cal_table").css("background-image","url('/wp/data/file/gallery_03/"+image_json.gallery_03[random_value]+"')");
	}else if(key==4){
		random_value=getRandomInt(0,image_json.gallery_04.length);
		$("#cal_table").css("background-image","url('/wp/data/file/gallery_04/"+image_json.gallery_04[random_value]+"')");
	}else if(key==5){
		random_value=getRandomInt(0,image_json.gallery_05.length);
		$("#cal_table").css("background-image","url('/wp/data/file/gallery_05/"+image_json.gallery_05[random_value]+"')");
	}else if(key==6){
		random_value=getRandomInt(0,image_json.bsc_edu.length);
		$("#cal_table").css("background-image","url('/wp/data/file/bsc_edu/"+image_json.bsc_edu[random_value]+"')");
	}
}

var calendarInterval = "";
$(function(){
  calendarInterval = setInterval(change_calendar_image, 60000);
});

function getRandomInt(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min)) + min; //최댓값은 제외, 최솟값은 포함
}
var is_calendar = true;
function set_play()
{
	if(is_calendar)
	{
		clearInterval(calendarInterval);
		$("#fa_spin").removeClass("fa-spin");
		is_calendar = false;
	}else{
		calendarInterval = setInterval(change_calendar_image, 60000);
		$("#fa_spin").addClass("fa-spin");
		is_calendar = true;
	}
}
function set_opacity(v)
{
	$("td").css("background-color","rgba(255,255,255,"+v*0.01+")");
	$(".this_day").css("background-color","rgba(204,204,204,"+v*0.01+")");
}
</script>