<?php
$sub_menu = "500200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '메인유튜브관리';
include_once('../admin.head.php');
$isadmin=$member['mb_level']=="10"?true:false;
$thisyear=date("Y");
$lastyear=$thisyear-1;
$last2year=$thisyear-2;
$last3year=$thisyear-3;
$last4year=$thisyear-4;
?>
<script type="text/javascript" src="/lib/js/nwagon.js"></script>
<link rel="stylesheet" href="/lib/css/nwagon.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 <script data-jsfiddle="common" src="/lib/js/handsontable.full.min.js"></script>
  <link data-jsfiddle="common" rel="stylesheet" media="screen" href="/lib/css/handsontable.full.min.css">

<style>
#cont1{position: relative;width:100%;height:100%;background: #f21;float: left;}
#cont2{position: relative;width:100%;height:100%;background: #f2f;float: left;}
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
<div class="btn_add01 btn_add">
    <a href="./write.php" id="member_add">쓰기</a>
</div>
<div id="youtube_main_list">#youtube_main_list</div><!-- #youtube_main_list -->
<div id="search_area">
<h4>검색 영역</h4>
<fieldset>
</fieldset>
</div><!-- #search_area -->
<?if($isadmin){?>
<ul id="check"></ul>
<?}else{
echo "아직 로그인을 하지 않았습니다.";
}?>
</form>
<div id="display_width">0</div>
<script type="text/javascript">
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
    buttonImage: 'http://cashq.co.kr/img/0507/btn_calendar.gif', //이미지주소
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
$("#chart7").html("");
$("#chart8").html("");

var ob=[];
var ob2=[];
var ob3=[];
var param=$("#ezracheck").serialize();
$.ajax({
  url:"/ajax/get_main_youtube.php",
  data:param,
  dataType:"json",
  success:function(data){
    wagon_idx=[];
    ob2.push("<table class='att'>");
    ob2.push("<thead>");
    
    ob2.push("<tr>");
    ob2.push("<th>날짜</th>");
    ob2.push("<th>오전</th>");
    ob2.push("<th>점심</th>");
    ob2.push("<th>오후</th>");
    ob2.push("<th>수요일</th>");
    ob2.push("<th>수정</th>");
    ob2.push("<th>삭제</th>");
    ob2.push("</tr>");
    ob2.push("</thead>");
    $.each(data,function(key,val){//deletecheck
			console.log(val);
/*
    ob2.push("<tr id='olist_"+val.seq+"'>");
*/
    });
    ob2.push("<table>");
    $("#check").html(ob2.join(""));
/*
ob2.push("[");
ob2.push("['', '오전', '점심', '오후', '수요일'],");
$.each(data,function(key,val){
    ob2.push("['"+val.insdate+"',"+val.am+","+val.ru+","+val.pm+","+val.we+"],");
});
ob2.push("]");
var container = document.getElementById('example'),
  hot;
var exeldata=eval("("+ob2.join("")+")");
hot = new Handsontable(container, {
  data: exeldata,
  minSpareRows: 1,
  colHeaders: true,
  contextMenu: true
});
*/

if(type=="f"){
var avg_am=[],avg_ru=[],avg_pm=[],avg_we=[];
var sum_am=0,sum_ru=0,sum_pm=0,sum_we=0;
    ob.push("{'legend':{names:[");
    $.each(data,function(key,val){
      if(parseInt(val.am)>0){
    ob.push("'"+val.insdate.substring(5, 10)+"',");
  }
    });
    ob.push("]},");
    ob.push("'dataset':{");
    ob.push("title:'서울 에스라 교회 출석인원', ");
    ob.push("values: [");

    $.each(data,function(key,val) {
      if(parseInt(val.am)>0){
        ob.push("["+na(val.am)+","+na(val.ru)+","+na(val.pm)+"],");
      
		if(parseInt(val.am)>0){

        avg_am.push(val.am);
        }
        if(parseInt(val.ru)>0){

        avg_ru.push(val.ru);
        }
        if(parseInt(val.pm)>0){
        avg_pm.push(val.pm);
        }
	  }
    });
    var sum=0;
    for (var i in avg_ru)
    {
          sum_am+=parseInt(avg_am[i],10);
          sum_ru+=parseInt(avg_ru[i],10);
          sum_pm+=parseInt(avg_pm[i],10);
    }
 
    var ravg_am=sum_am/avg_am.length;
    var ravg_ru=sum_ru/avg_ru.length;
    var ravg_pm=sum_pm/avg_pm.length;
    ob.push("],");
    ob.push("colorset: ['#DC143C','#FF8C00', '#2EB400'],");
    ob.push("fields:['오전 "+ravg_am.toFixed(2)+"' , '점심 "+ravg_ru.toFixed(2)+"', '오후 "+ravg_pm.toFixed(2)+"']");
    ob.push("},");
    ob.push("'chartDiv' : 'chart7',");
    ob.push("'chartType' : 'line',");
    
    ob.push("'leftOffsetValue': 50,");
    ob.push("'bottomOffsetValue': 60,");
    ob.push("'chartSize':{width:1200, height:300},");
    ob.push(" 'minValue':0,");
    var amMax=Math.max.apply(20,avg_am)+1;
    ob.push(" 'maxValue':"+amMax+",");
//	ob.push(" 'maxValue':100,");
    ob.push(" 'increment':10");
//    ob.push(" 'isGuideLineNeeded' : true ");
    ob.push("}");
    

    Nwagon.chart(eval("(" + ob.join("") + ")"));

    ob3.push("{'legend':{names:[");
    $.each(data,function(key,val){
      if(parseInt(val.we)>0){
       ob3.push("'"+val.insdate.substring(5, 10)+"',");
      }
    });
    ob3.push("]},");
    ob3.push("'dataset':{");
    ob3.push("title:'서울 에스라 교회 출석인원', ");
    ob3.push("values: [");

    $.each(data,function(key,val) {
        if(parseInt(val.we)>0){
        ob3.push("["+na(val.we)+"],");

        if(parseInt(val.we)>0){
        avg_we.push(val.we);
        }

	}
    });

  for (var i in avg_we)
{     sum_we+=parseInt(avg_we[i],10);
}
    var ravg_we=sum_we/avg_we.length;
    $("#avg_we").html(ravg_we);

    ob3.push("],");
    ob3.push("colorset: ['#2278fb'],");
    ob3.push("fields:['수요예배 "+ravg_we.toFixed(2)+"']");
    ob3.push("},");
    ob3.push("'chartDiv' : 'chart8',");
    ob3.push("'chartType' : 'line',");
    
    ob3.push("'leftOffsetValue': 50,");
    ob3.push("'bottomOffsetValue': 60,");
    ob3.push("'chartSize':{width:1200, height:300},");
    ob3.push(" 'minValue':0,");
    //avg_we
    var weMax=Math.max.apply(20,avg_we)+1;
    ob3.push(" 'maxValue':"+weMax+",");
//    ob3.push(" 'increment':"+parseInt(weMax/10)+"");    
    ob3.push(" 'increment':"+Math.ceil(weMax/10)+"");
//    ob3.push(" 'isGuideLineNeeded' : true ");
    ob3.push("}");



    Nwagon.chart(eval("(" + ob3.join("") + ")"));
}else if(type=="t"){
var avg_am=[],avg_ru=[],avg_pm=[],avg_we=[];
var sum_am=0,sum_ru=0,sum_pm=0,sum_we=0;
    ob.push("{'legend':{names:[");
    $.each(data,function(key,val){
    ob.push("'"+val.insdate.substring(5, 10)+"',");
    });
    ob.push("]},");
    ob.push("'dataset':{");
    ob.push("title:'서울 에스라 교회 출석인원', ");
    ob.push("values: [");

  
    $.each(data,function(key,val) {
        ob.push("["+na(val.am)+","+na(val.ru)+","+na(val.pm)+","+na(val.we)+"],");
        console.log("we : "+na(val.we));
        if(parseInt(val.am)>0){
        avg_am.push(val.am);
        }
        if(parseInt(val.ru)>0){
        avg_ru.push(val.ru);
        }
        if(parseInt(val.pm)>0){
        avg_pm.push(val.pm);
        }
        if(parseInt(val.we)>0){
        avg_we.push(val.we);        
        }


    });
    var sum=0;
    for (var i in avg_am)
    {
          sum_am+=parseInt(avg_am[i],10);
    }
    for (var i in avg_ru)
    {
          sum_ru+=parseInt(avg_ru[i],10);
    }

    for (var i in avg_pm)
    {
          sum_pm+=parseInt(avg_pm[i],10);
    }
          
    for (var i in avg_we)
    {
          sum_we+=parseInt(avg_we[i],10);
    }     


    var ravg_am=sum_am/avg_am.length;
    var ravg_ru=sum_ru/avg_ru.length;
    var ravg_pm=sum_pm/avg_pm.length;
    var ravg_we=sum_we/avg_we.length;

    ob.push("],");
    ob.push("colorset: ['#DC143C','#FF8C00', '#2EB400','#2278fb'],");
    ob.push("fields:['오전 "+ravg_am.toFixed(2)+"', '점심 "+ravg_ru.toFixed(2)+"', '오후 "+ravg_pm.toFixed(2)+"','수요 "+ravg_we.toFixed(2)+"']");
    ob.push("},");
    ob.push("'chartDiv' : 'chart7',");
    ob.push("'chartType' : 'line',");
    
    ob.push("'leftOffsetValue': 50,");
    ob.push("'bottomOffsetValue': 60,");
    ob.push("'chartSize':{width:1200, height:300},");
    ob.push(" 'minValue':0,");
    var amMax=Math.max.apply(20,avg_am)+1;
    ob.push(" 'maxValue':"+amMax+",");
    ob.push(" 'increment':10");
//    ob.push(" 'isGuideLineNeeded' : true ");
    ob.push("}");
    
    Nwagon.chart(eval("(" + ob.join("") + ")"));
}
  }
});
}

function na(str){
return str=="0"||str==""?'\"n\/a\"':str;
}

function ci_modify(seq){
//alert(wagon_idx[seq]);
modify(wagon_idx[seq]);
}


function get_youtube_url()
{
	var object=[];
	$.ajax({
		url:"/ajax/get_youtubemain.php",
		dataType:'json',
		success:function(data){

object.push('  <div class="tbl_frm01 tbl_wrap">');
object.push('          <table>');
object.push('          <caption>홈페이지 기본환경 설정</caption>');
object.push('          <colgroup>');
object.push('              <col class="grid_4">');
object.push('              <col>');
object.push('              <col class="grid_4">');
object.push('              <col>');
object.push('          </colgroup>');
object.push('          <tbody>');
object.push('  ');


			$.each(data.posts,function(key,val){
				console.log(val);

				object.push('<tr class=\'ym_list_'+val.ym_no+'\'>');
				object.push('        <th scope="row"><label for="cf_title">유튜브 링크<strong class="sound_only">필수</strong></label></th>');
				object.push('        <td colspan="3">');
				object.push("		<input type='text' name='ym_link' id='ym_link_"+val.ym_no+"' id='ym_link_"+val.ym_no+"' value="+val.ym_link+" ");
				object.push(" class='required frm_input' size='40'  onkeydown='javascript:get_thumb(this);' onchange='javascript:get_thumb(this);' onkeyup='javascript:get_thumb(this);'>");
				object.push("</td>");
				object.push('    </tr>');
				object.push('<tr class=\'ym_list_'+val.ym_no+'\'>');
				object.push('        <th scope="row"><label for="cf_title">유튜브 썸네일</label></th>');
				object.push('        <td colspan="3">');
				object.push("		<span id='youtube_img_area_"+val.ym_no+"'>");
				object.push("		<img src='https://img.youtube.com/vi/"+val.ym_link+"/default.jpg'>");
				object.push("		<img src='https://img.youtube.com/vi/"+val.ym_link+"/1.jpg'>");
				object.push("		<img src='https://img.youtube.com/vi/"+val.ym_link+"/2.jpg'>");
				object.push("		<img src='https://img.youtube.com/vi/"+val.ym_link+"/3.jpg'>");
				object.push("</span>");
				object.push("		</td>");
				object.push('    </tr>');

				object.push('<tr class=\'ym_list_'+val.ym_no+'\'>');
				object.push('        <th scope="row"><label for="cf_title">유튜브 가운데 텍스트<strong class="sound_only">필수</strong></label></th>');
				object.push('        <td colspan="3">');
				object.push("<textarea name='ym_content'  id='ym_content_"+val.ym_no+"' cols=10 rows=5>");
				object.push(val.ym_content);
				object.push("</textarea>");

				object.push('    </tr>');
				object.push('<tr class=\'ym_list_'+val.ym_no+'\'>');
				object.push('        <th scope="row"><label for="cf_title">유튜브 시작 타임 (단위 초)<strong class="sound_only">필수</strong></label></th>');
				object.push('        <td colspan="3">');
				object.push("<input type='text' name='ym_time' id='ym_time_"+val.ym_no+"' value='");
				object.push(val.ym_time);
				object.push("'>");
				object.push('		</td>');
				object.push('    </tr>');

				object.push('<tr class=\'ym_list_'+val.ym_no+'\'>');
				object.push('        <th colspan="4">');
				object.push('<div class="btn_confirm01 btn_confirm">');
				object.push("<a href='javascript:set_youtubemin(\"modify\","+val.ym_no+");'  class='btn_submit');'>수정</a>");
				object.push("&nbsp;&nbsp;&nbsp;&nbsp;");
				object.push("<a href='javascript:set_youtubemin(\"delete\","+val.ym_no+");'>삭제</a>");
				object.push('</div>');
				object.push('		</td>');
				object.push('    </tr>');
			
			});

			object.push('  				</tbody>');
object.push('          </table>');

			$("#youtube_main_list").html(object.join(""));
			
		}
	});
}


function set_youtubemin(mode,ym_no)
{
	var param={};
	param.ym_link=$("#ym_link_"+ym_no).val();
	param.ym_content=$("#ym_content_"+ym_no).val();
	param.ym_time=$("#ym_time_"+ym_no).val();
	param.ym_no=ym_no;
	param.mode=mode;

	if(mode=='modify')
	{
		//alert(ym_no+"와 수정이다.");
		$.ajax({
			url:"/ajax/set_main_youtube.php",
			data:param,
			type:"POST",
			dataType:'json',
			success:function(data){
				if(data.success){
					alert("수정되었습니다.");
				}else{
					alert("수정 실패 관리자에게 문의 하세요.");
				}
				
			}
		});
	}else{
		//alert(ym_no+"와 삭제다.");
			var is_del=confirm("삭제 하면 메인에서 해당 리스트가 사라 집니다. \n 정말 삭제 하시겠습니까? ");
			if(is_del)
		{
			$.ajax({
			url:"/ajax/set_main_youtube.php",
			data:param,
			type:"POST",
			dataType:'json',
			success:function(data){
				if(data.success){
					alert("삭제되었습니다.");
					$(".ym_list_"+ym_no).remove();
				}else{
					alert("삭제 실패 관리자에게 문의 하세요.");
				}
				
			}
		});
		}else{
			alert("취소 되었습니다.");
		}
	}
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

get_youtube_url();
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

function get_thumb(d)
{
	var id_list=d.id.split("_");
//	$("#youtube_img_"+id_list[2]).attr("src","https://img.youtube.com/vi/"+d.value+"/default.jpg");
	var object=[];
	object.push("<img src='https://img.youtube.com/vi/"+d.value+"/default.jpg'>");
	object.push("<img src='https://img.youtube.com/vi/"+d.value+"/1.jpg'>");
	object.push("<img src='https://img.youtube.com/vi/"+d.value+"/2.jpg'>");
	object.push("<img src='https://img.youtube.com/vi/"+d.value+"/3.jpg'>");
	$("#youtube_img_area_"+id_list[2]).html(object.join(""));
}
</script>
<?php
include_once ('../admin.tail.php');
?>