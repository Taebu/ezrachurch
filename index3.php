<?
if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false) {
$isMobile = "1"; //아이폰만 볼 수 있는 페이지임 ㅋ
} else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false) {
$isMobile = "2";
} else {
$isMobile = "3";
}
if($_GET['device']!="PC"){
if($isMobile=="1"||$isMobile=="2"){
//header("Location: http://www.ezrachurch.kr/list.php"); /* Redirect browser */
exit();
}
}
?>
<?
include_once("./_common.php");
include_once("$g4[path]/lib/latest.lib.php");
$g4['title'] = "";
include_once("$g4[path]/head.sub.php");
include_once("$g4[path]/lib/outlogin.lib.php");
?>
<!-- 메인화면 최신글 시작 -->
<style type="text/css">
body,div{margin:0;padding:0}
.blind{display:none;overflow:hidden;position:relative;z-index:-10;height:13px;font-size:13px;white-space:nowrap;}
a{cursor:hand}
#mn_01{width:1010px}
#mn_01 a{display:inline-block;overflow:hidden;height:100px;margin:0;margin-right:-5px;padding:0;background:url('/img/ezra_main.png') no-repeat ;line-height:999px;vertical-align:top}
#mn_01 a.mn01{width:271px;background-position:0 0}
#mn_01 a.mn02{width:119px;background-position:-271px 0}
#mn_01 a.mn03{width:154px;background-position:-390px 0}
#mn_01 a.mn04{width:126px;background-position:-544px 0}
#mn_01 a.mn05{width:106px;background-position:-670px 0}
#mn_01 a.mn06{width:109px;background-position:-776px 0}
#mn_01 a.mn07{width:115px;background-position:-885px 0}
#mn_01 a.mn08{width:1001px;height:680px;background-position:0 -100px}
#ezrabible{position:absolute;top:433px;left:174px;width:110px;height:53px;}
#mn_01 a.ezrabible{width:134px;height:45px;background-position:-175px -433px}
#mn_01 a.mn13{width:300px;height:22px;background-position:-502px -800px}
#mn_01 a.mn14{width:312px;height:23px;background-position:-502px -800px}
#mn_01 a.mn15{width:118px;height:78px;background-position:-502px -800px}
#mn_01 a.mn16{width:136px;height:78px;background-position:-502px -800px}
#notice{position:absolute;top:531px;left:0px;width:342px;height:153px;}
#gallery{position:absolute;top:531px;left:340px;width:316px;height:132px;}

.mn13{position:absolute;top:502px;left:31px}
.mn14{position:absolute;top:500px;left:350px}
.mn15{position:absolute;top:500px;left:679px;}
.mn16{position:absolute;top:502px;left:800px;width:75px;height:56px;}

#mn_02 a{display:inline-block;overflow:hidden;height:100px;margin:0;margin-right:-5px;padding:0;background:url('/img/ezra_main.png') no-repeat ;line-height:999px;vertical-align:top}
#mn_02{position:absolute;top:587px;left:679px;width:300px;height:56px;}
#mn_02 a.map21{width:74px;height:57px;background-position:-678px -587px}
#mn_02 a.map22{width:74px;height:57px;background-position:-752px -587px}
#mn_02 a.map23{width:74px;height:57px;background-position:-824px -587px}
#mn_02 a.map24{width:78px;height:57px;background-position:-896px -587px}

#outlogin{width:650px; height:10px; position:absolute; left:470px;top:5px;z-index:5;}
#new_comm{width:350px; height:500px; position:absolute; left:1010px;top:30px;z-index:1;}
#banner{width:450px; height:60px; position:absolute; left:450px; top:100px;z-index:1;}
</style>
<script>
var param;
var wr_id;
function view(param,wr_id){
var lochref;
if(param&&wr_id){
lochref = "/bbs/board.php?bo_table="+param+"&wr_id="+wr_id;
}else if(param){
lochref = "/bbs/board.php?bo_table="+param;
}else{
lochref = "/index.php";
}
location.href=lochref;
}
</script>
<body>
<?$arr = array("1", "2");
shuffle($arr ); //배열을 섞는다.
$ran = substr(join( "", $arr ), 0, 1); //배열을 붙인뒤에 앞 7자리만 출력한다.
?>
<div id="mn_01">
<a class="mn01" href="javascript:view()"><span class="blind">처음으로</span></a>
<a class="mn02" href="javascript:view('page_1','1')"><span class="blind">교회소개</span></a>
<a class="mn03" href="javascript:view('bbs_2_1','')"><span class="blind">에스라교회설교</span></a>
<a class="mn04" href="javascript:view('page_2','1')"><span class="blind">기관소개</span></a>
<a class="mn05" href="javascript:view('bbs_4_1','')"><span class="blind">자료실</span></a>
<a class="mn06" href="javascript:view('bbs_5_1','')"><span class="blind">사진첩</span></a>
<a class="mn07" href="javascript:view('bbs_6_1','')"><span class="blind">커뮤니티</span></a>
<a class="mn08"><span class="blind"></span></a>
<div id="ezrabible"><a href="http://ezra.or.kr" target="_blank"  class="ezrabible"><span class="blind">ezra.or.kr</span></a></div>
<a class="mn13" href="javascript:view('bbs_6_1','')"><span class="blind">공지사항</span></a>
<a class="mn14" href="javascript:view('bbs_5_1','')"><span class="blind">행사사진</span></a>
<a class="mn15" href="javascript:view('page_1','3')"><span class="blind">섬기는이 소개</span></a>
<a class="mn16" href="javascript:view('page_1','6')"><span class="blind">찾아오시는 길</span></a>
<div id="mn_02">
<a class="map21" href="javascript:view('zine','')" ><span class="blind">금주의 주보</span></a>
<a class="map22" href="javascript:view('bbs_6_2','')"><span class="blind">방문인사</span></a>
<a class="map23" href="javascript:view('bbs_4_1','')"><span class="blind">자료실</span></a>
<a class="map24" href="javascript:view('bbs_6_1','')"><span class="blind">커뮤니티</span></a></div>
</div><!--#mn_01-->

<div id="notice"><?echo latest("basic", "bbs_6_1", 5, 62); ?></div><!-- #notice-->

<div id="gallery">
<?include_once("$g4[path]/lib/total_gallery.lib.php");
$board_arr = array(bbs_5_1,bbs_5_2,bbs_5_3);
/*통합갤러리 최신글 출력(25는 추출이미지수, 20은 제목글자수)*/
echo arr_new_gallery("total_gallery", $board_arr, 3, 20); 
?></div><!-- #gallery-->

<div id="outlogin"><?php //echo outlogin("simple2"); // 외부 로그인 ?></div><!-- #outlogin -->

<div id="new_comm">
<?//include_once("$g4[path]/new_comm.php");?>
<?include_once("$g4[path]/test4.php");?></div><!-- #new_comm -->

<!-- 메인화면 최신글 끝 -->
<?include_once("$g4[path]/tail.sub.php");?><!-- tail.sub.php -->
수정