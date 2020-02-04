<?php
$sub_menu = "500100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '출석관리';
include_once('../admin.head.php');

$isadmin=$member['mb_level']=="10"?true:false;
$thisyear=date("Y");
$lastyear=$thisyear-1;
$last2year=$thisyear-2;
$last3year=$thisyear-3;
$last4year=$thisyear-4;
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
<script src="//code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>

<script src="//d3js.org/d3.v4.min.js"></script>
<script src="billboard.js"></script>
<link rel="stylesheet" href="billboard.css">
<style>
.node1{position: absolute;top:50%;left: 50%}
#chart7,#chart8,#input_area{float:left;}
#avg_area,#input_area{float:left;}
#search_area {clear:both;}
  .att{width:100%;border:1px solid #ccc;}
  .att td{border:1px solid #ccc;text-align: center;}
  .att tr:nth-child(2n){background:#ff8c00}

</style>
<form id="ezracheck" name="ezracheck" method="get">
<input type="hidden" name="mode" id="mode" value="insert">
<input type="hidden" name="mode_seq" id="mode_seq">
<div id="btns">
<input type="button" value="합체" onclick="merge('t')">
<input type="button" value="분리" onclick="merge('f')">
</div>
<div id="chart7"></div><!-- #chart7 -->

<div id="chart8"></div><!-- #chart8 -->

<div id="example"></div><!-- #example -->

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
 <p><input id="fr_date" class="frm_input" name="fr_date" maxLength="11" value="<?echo $fr_date;?>" size="11" type="text"> ~
    <input id="to_date" class="frm_input" name="to_date" maxLength="11" value="<?echo $to_date;?>" size="11" type="text">
<input type="button" value="차트 검색" onclick="get_check('t');"></p>
<!-- <p>
  <input type="button" value="<?echo $last4year;?> 1사분기" onclick="getchart('<?echo $last4year;?>-01-01')">
  <input type="button" value="<?echo $last4year;?> 2사분기" onclick="getchart('<?echo $last4year;?>-04-01')">
  <input type="button" value="<?echo $last4year;?> 3사분기" onclick="getchart('<?echo $last4year;?>-07-01')">
  <input type="button" value="<?echo $last4year;?> 4사분기" onclick="getchart('<?echo $last4year;?>-10-01')"></p>
<p>
  <input type="button" value="<?echo $last3year;?> 1사분기" onclick="getchart('<?echo $last3year;?>-01-01')">
  <input type="button" value="<?echo $last3year;?> 2사분기" onclick="getchart('<?echo $last3year;?>-04-01')">
  <input type="button" value="<?echo $last3year;?> 3사분기" onclick="getchart('<?echo $last3year;?>-07-01')">
  <input type="button" value="<?echo $last3year;?> 4사분기" onclick="getchart('<?echo $last3year;?>-10-01')"></p> -->
<p>
  <input type="button" value="<?echo $last2year;?> 1사분기" onclick="getchart('<?echo $last2year;?>-01-01')">
  <input type="button" value="<?echo $last2year;?> 2사분기" onclick="getchart('<?echo $last2year;?>-04-01')">
  <input type="button" value="<?echo $last2year;?> 3사분기" onclick="getchart('<?echo $last2year;?>-07-01')">
  <input type="button" value="<?echo $last2year;?> 4사분기" onclick="getchart('<?echo $last2year;?>-10-01')"></p>
<p>
  <input type="button" value="<?echo $lastyear;?> 1사분기" onclick="getchart('<?echo $lastyear;?>-01-01')">
  <input type="button" value="<?echo $lastyear;?> 2사분기" onclick="getchart('<?echo $lastyear;?>-04-01')">
  <input type="button" value="<?echo $lastyear;?> 3사분기" onclick="getchart('<?echo $lastyear;?>-07-01')">
  <input type="button" value="<?echo $lastyear;?> 4사분기" onclick="getchart('<?echo $lastyear;?>-10-01')"></p>
<p>
  <input type="button" value="<?echo $thisyear;?> 1사분기" onclick="getchart('<?echo $thisyear;?>-01-01')">
  <input type="button" value="<?echo $thisyear;?> 2사분기" onclick="getchart('<?echo $thisyear;?>-04-01')">
  <input type="button" value="<?echo $thisyear;?> 3사분기" onclick="getchart('<?echo $thisyear;?>-07-01')">
  <input type="button" value="<?echo $thisyear;?> 4사분기" onclick="getchart('<?echo $thisyear;?>-10-01')">

  </p>


<p><input type="checkbox" name="chk_am" id="chk_am" checked value='0'><label for="chk_am">오전</label>
<input type="checkbox" name="chk_ru" id="chk_ru" checked value='1'><label for="chk_ru">점심</label>
<input type="checkbox" name="chk_pm" id="chk_pm" checked value='2'><label for="chk_pm">오후</label>
<input type="checkbox" name="chk_we" id="chk_we" checked value='0'><label for="chk_we">수요</label></p>

</fieldset>
</div><!-- #search_area -->
<?if($isadmin){?>
<ul id="check"></ul>
<?}else{
echo "아직 로그인을 하지 않았습니다.";
}?>
</form>
<div id="display_width">0</div>
<div id="areaChart"></div>
<script type="text/javascript">
window.onload = function () {
var param=$("#ezracheck").serialize();
$.ajax({
  url:"/ajax/billboard/get_chart.php",
  data:param,
  dataType:"json",
  success:function(data){
	var chart = bb.generate(data);
  }});
};
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

  
console.log($(window).height());
console.log($(document).height());
$("#cont1").height($(window).height());
$("#cont2").height($(window).height());
$("#display_width").html($(window).width()+" x "+$(window).height());
 $( window ).resize(function() {
$("#display_width").html($(window).width()+" x "+$(window).height());
//location.reload();
});
var v_am,v_pm,v_ru,v_we=true;
var wagon_idx=[];
function showline(type){
if(type=="all"){
for (var i=0;i<4 ;i++ )
{
  $(".li_"+i).show();
  $(".ci_"+i).show();
}
}else{
for (var i=0;i<4 ;i++ )
{
  $(".li_"+i).hide();
  $(".ci_"+i).hide();
}
  $(".li_"+type).show();
  $(".ci_"+type).show();
}
}


function getchart(date){
var sp_date=date.split("-"); 
var d = new Date(sp_date[0], sp_date[1], sp_date[2]);
d.setMonth(d.getMonth() + 2);
console.log(d.toISOString().substring(0, 10));
$("#fr_date").val(date);
$("#to_date").val(d.toISOString().substring(0, 10));
get_check(getCookie("type"));  
}

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


$(function() {
  $("tr:odd").css({background:"gray"});
  $("span[id^=ins]").css({width:"200px",background:"red"});
  $("span[id^=am]").css({width:"200px",background:"green"});
$('#chk_am:checkbox,#chk_ru:checkbox,#chk_pm:checkbox').change(function(event) {
        if ($(this).is(":checked")) {
  $("#chart7 .li_"+$(this).val()).show();
  $("#chart7 .ci_"+$(this).val()).show();
        } else {
  $("#chart7 .li_"+$(this).val()).hide();
  $("#chart7 .ci_"+$(this).val()).hide();
       }
    });    
$('#chk_we:checkbox').change(function(event) {
        if ($(this).is(":checked")) {
  $("#chart8 .li_"+$(this).val()).show();
  $("#chart8 .ci_"+$(this).val()).show();
        } else {
  $("#chart8 .li_"+$(this).val()).hide();
  $("#chart8 .ci_"+$(this).val()).hide();
       }
    });  
  $.datepicker.regional['ko'] = {
        closeText: '닫기',
        prevText: '이전달',
        nextText: '다음달',
        currentText: '오늘',
        monthNames: ['1월','2월','3월','4월','5월','6월',
        '7월','8월','9월','10월','11월','12월'],
        monthNamesShort: ['1월','2월','3월','4월','5월','6월',
        '7월','8월','9월','10월','11월','12월'],
        dayNames: ['일','월','화','수','목','금','토'],
        dayNamesShort: ['일','월','화','수','목','금','토'],
        dayNamesMin: ['일','월','화','수','목','금','토'],
        weekHeader: 'Wk',
        dateFormat: 'yy-mm-dd',
        buttonImageOnly: true, //이미지표시
    buttonImage: '//cashq.co.kr/img/0507/btn_calendar.gif', //이미지주소
    showOn: "both", //엘리먼트와 이미지 동시 사용(both,button)
        firstDay: 0,
        isRTL: false,
        duration:200,
        showAnim:'show',
        showMonthAfterYear: true,
        yearSuffix: '년',
    currentText: "Now"
    };


   $.datepicker.setDefaults($.datepicker.regional['ko']);

  $("#insdate").datepicker();
  $("#fr_date").datepicker();
  $("#to_date").datepicker();
  $("#insdate").val(getDateISO());
  $("#fr_date").val(getDateISO(-2));
  $("#to_date").val(getDateISO());

});

  /*     ------         */
function test(){

var param=$("#ezracheck").serialize();
var object=[];
$.ajax({
url:"/ajax/set_check.php",
data:param,
dataType:"json",
success:function(data){
if(data.success){
alert("입력 성공.");
object.push("<tr id='ins_"+data.seq+"'>");
object.push("<td>");
object.push(data.insdate+"</td>:");
object.push("<td><span id='am_"+data.seq+"'>"+data.am+"</span></td>:");
object.push("<td id='ru_"+data.seq+"'>"+data.ru+"</td>:");
object.push("<td id='pm_"+data.seq+"'>"+data.pm+"</td>:");
object.push("<td id='we_"+data.seq+"'>"+data.we+"</td>");
object.push("<td><input type='button' value='수정' onclick='modify("+data.seq+")'></td>");
object.push("<td><input type='button' value='삭제' onclick='deletecheck("+data.seq+")'></td></tr>");

//$("#check").append(object.join(""));
$("#check thead").insertBefore(object.join(""));
}else{
alert("중복입력이거나 입력에 실패 하였습니다.");
}
}
});
 }

function modi(){
$("#mode").val("update");
var seq=$("#mode_seq").val();
$.ajax({
  url:"/ajax/set_check.php",
  data:{
      "insdate":$("#insdate").val(),
      "am":$("#am").val(),
      "ru":$("#ru").val(),
      "pm":$("#pm").val(),
      "we":$("#we").val(),
      "mode":"update",
      "seq":seq
  },
  dataType:"json",
  Type:"get",
  success:function(data){
    if(data.success){
      alert("수정 성공");   
    }else{
      alert("수정 실패");
    }
  }
});
$("#mode").val("insert");
$("#test").show();
$("#btn_modify").hide();
}

function del(){

}

$(".modify_circle").on('click',function(){
  // Holds the product ID of the clicked element
  var productId = $(this).attr('index').val();
  alert(productId);
  //addToCart(productId);
});
$(".ci_0").click(function(){
  alert("1");
});
function deletecheck(seq){
//alert(seq);
    $("#mode_seq").val(seq);
    $("#test").hide();
    $("#btn_del").show();
if(confirm("삭제 되면 데이터가 사라 집니다. \n 정말 삭제 하시겠습니까? ")){
$.ajax({
  url:"/ajax/set_check.php",
  data:{
      "mode":"del",
      "seq":seq
  },
  dataType:"json",
  Type:"get",
  success:function(data){
    if(data.success){
      alert("삭제 성공");
      $("#olist_"+seq).hide();
    }else{
      alert("삭제 실패");
    }
  }
});
$("#mode").val("insert");
$("#test").show();
// $("#btn_modify").hide();
$("#btn_del").hide();
}
}


function modify(seq){
//alert(seq);
    $("#mode_seq").val(seq);
$("#insdate").val($("#ins_"+seq).html());
$("#am").val($("#am_"+seq).html());
$("#ru").val($("#ru_"+seq).html());
$("#pm").val($("#pm_"+seq).html());
$("#we").val($("#we_"+seq).html());
    $("#test").hide();
    $("#btn_modify").show();
}
function get_check(type){

}

function na(str){
return str=="0"||str==""?'\"n\/a\"':str;
}

function ci_modify(seq){
//alert(wagon_idx[seq]);
modify(wagon_idx[seq]);
}

$(function(){
//get2014_4();
//get2015_1();
$("#fr_date").val(getDateISO(-2));
$("#to_date").val(getDateISO());
var type=getCookie("type");
  if(type=="")
    type='f';
merge(type);  

});

function merge(type){
  if(type!=""){
  setCookie("type",type,365);
  }
  type=getCookie("type");
  if(type=="")
    type='f';
  get_check(type);
}
</script>
<?php
include_once ('../admin.tail.php');
?>