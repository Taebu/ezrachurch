
<?php
$member=array();
$member['mb_level']="";
//include_once("./_common.php");

$isadmin=$member['mb_level']=="10"?true:false;
$thisyear=date("Y");
$lastyear=$thisyear-1;
$last2year=$thisyear-2;
$last3year=$thisyear-3;
$last4year=$thisyear-4;

?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

<script src="http://code.jquery.com/jquery-1.9.1.js"></script> 
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<script src="https://d3js.org/d3.v4.min.js"></script>
<script src="/wp/adm/check/billboard.js"></script>
<link rel="stylesheet" href="/wp/adm/check/billboard.css">
</head>
<body>
<form id="ezracheck" name="ezracheck" method="get">
<input type="hidden" name="mode" id="mode" value="insert">
<input type="hidden" name="mode_seq" id="mode_seq">

<h2>서울 에스라 교회 출석인원</h2>
<div id="areaChart">areaChart</div>
<div id="input_area">
<h4>입력</h4>
<input type="text" name="insdate" id="insdate" placeholder="2014-12-23">
<input type="text" name="am" id="am" placeholder="오전">
<input type="text" name="ru" id="ru" placeholder="식사">
<input type="text" name="pm" id="pm" placeholder="오후">
<input type="text" name="we" id="we" placeholder="수요예배">
<input type="button" value="입력" id="insert" onclick="test();">
<input type="button" value="수정" id="btn_modify" onclick="modi()" style="display:none">
</div><!-- #input_area -->

<div id="search_area">
<h4>검색 영역</h4>
<fieldset>
 <p><input id="fr_date" class="frm_input" name="fr_date" maxLength="11" value="<?php echo $fr_date;?>" size="11" type="text"> ~
    <input id="to_date" class="frm_input" name="to_date" maxLength="11" value="<?php echo $to_date;?>" size="11" type="text">
<input type="button" value="차트 검색" onclick="get_check('t');"></p>
<p>
  <input type="button" value="<?php echo $last2year;?> 1사분기" onclick="getchart('<?php echo $last2year;?>-01-01')">
  <input type="button" value="<?php echo $last2year;?> 2사분기" onclick="getchart('<?php echo $last2year;?>-04-01')">
  <input type="button" value="<?php echo $last2year;?> 3사분기" onclick="getchart('<?php echo $last2year;?>-07-01')">
  <input type="button" value="<?php echo $last2year;?> 4사분기" onclick="getchart('<?php echo $last2year;?>-10-01')"></p>
<p>
  <input type="button" value="<?php echo $lastyear;?> 1사분기" onclick="getchart('<?php echo $lastyear;?>-01-01')">
  <input type="button" value="<?php echo $lastyear;?> 2사분기" onclick="getchart('<?php echo $lastyear;?>-04-01')">
  <input type="button" value="<?php echo $lastyear;?> 3사분기" onclick="getchart('<?php echo $lastyear;?>-07-01')">
  <input type="button" value="<?php echo $lastyear;?> 4사분기" onclick="getchart('<?php echo $lastyear;?>-10-01')"></p>
<p>
  <input type="button" value="<?php echo $thisyear;?> 1사분기" onclick="getchart('<?php echo $thisyear;?>-01-01')">
  <input type="button" value="<?php echo $thisyear;?> 2사분기" onclick="getchart('<?php echo $thisyear;?>-04-01')">
  <input type="button" value="<?php echo $thisyear;?> 3사분기" onclick="getchart('<?php echo $thisyear;?>-07-01')">
  <input type="button" value="<?php echo $thisyear;?> 4사분기" onclick="getchart('<?php echo $thisyear;?>-10-01')">

  </p>


<p><input type="checkbox" name="chk_am" id="chk_am" checked value='0'><label for="chk_am">오전</label>
<input type="checkbox" name="chk_ru" id="chk_ru" checked value='1'><label for="chk_ru">점심</label>
<input type="checkbox" name="chk_pm" id="chk_pm" checked value='2'><label for="chk_pm">오후</label>
<input type="checkbox" name="chk_we" id="chk_we" checked value='0'><label for="chk_we">수요</label></p>

</fieldset>
</div><!-- #search_area -->
<script> 

var chart="";
var bb_data = "";
window.onload = function () {
var param=$("#ezracheck").serialize();
$.ajax({
  url:"/ajax/billboard/get_chart.php",
  data:param,
  dataType:"json",
  success:function(data){
	  bb_data = data;
    chart = bb.generate(data);
  }});
};


setTimeout(function() {
//chart.toggle(["오전","점심","오후","수요일"]);
}, 7000);


$("#insdate").val(getDateISO());
$("#fr_date").val(getDateISO(-2));
$("#to_date").val(getDateISO());

function getDateISO(editmonth){
var myDate, day, month, year, date;
myDate = new Date();
day = myDate.getDate();
if (day <10)
  day = "0" + day;
if(editmonth){
month = myDate.getMonth()+1 + editmonth;
}else{
month = myDate.getMonth() + 1;
}
year = myDate.getFullYear();

if(month<1){
month=month+12;
console.log(month);
year=year-1;
}

if (month < 10)
  month = "0" + month;


/*
2014-12-31 (수) 조정흠 지적 수정 
오류 12월인 경우 9월은 -3month로 세팅 할 경우 31일 이 없기에 에러가 남.
4,6,9,11월
2월은 28일 넘어 갈 경우 무조건 28일

*/
day=(month=="02"&&day>28)?"28":day;
day=((month=="04"||month=="06"||month=="09"||month=="11")&&day=="31")?"30":day;

date = year + "-" + month + "-" + day;
return date;
}

</script> 

</body>
</html>
