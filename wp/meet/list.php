<!-- list.php -->
<?php
include_once('../common.php');
include_once "../theme/modificate/head.php";
include_once "../theme/modificate/head.sub.php";
?>
<header class="page-header subpage_header">
		<section>
          <!--Swiper-->
          <div data-autoplay="5000" data-slide-effect="fade" data-loop="false" class="swiper-container swiper-slider" style="color:#fff">
            <div class="jumbotron text-center">
              <h1 style=";color:#fff">연중집회일정<br class="hidden-md hidden-sm hidden-xs"> <br class="hidden-md hidden-sm hidden-xs"><small style=";color:#fff">네가 죽도록 충성하라 그리하면 내가 생명의 관을 네게 주리라 (계2:10)</small></h1>
              <p class="big"></p>
            </div>
            <div class="swiper-wrapper">
              <div data-slide-bg="/wp/theme/modificate/images/wpmqwrjwpls-alberto-restifo.jpg" class="swiper-slide">
                <div class="swiper-slide-caption" style="text-weight:900;color:#fff;font-size:1.2em"></div>
              </div>
            </div>
          </div>
        </section>
      </header>
 <ol class="breadcrumb section-border">
          <li><a href="/">Home</a></li>
          <li><a href="#">서울에스라성서원</a></li>
          <li class="active">연중집회일정</li>
        </ol>
        <!--Start section List Layout-->
        <section class="text-center text-sm-left well well-sm">
          <div class="container">
<div class="sub_content">
			<p class="page_guide">Home &gt; 서울에스라성서원 &gt; 집회일정</p>
			<h2 class="subpage_title">연중집회일정</h2>
			<div class="ezra_lecture">
				<p>참다운 은혜와 진리를 사랑하는 모든 분들을 초대합니다. 평생 성경을 읽어도 이해가 되지 않는 분들, 신학(神學)을 했어도 성경에는 모르는 부분이 더 많은 분들, 구약성경이 항상 어렵다고 느끼시는 분들, 에스겔서나 요한 계시록이 어렵다고 생각이 되시는 분들은 꼭 참석하시기 바랍니다. <br>신학을 하고서도 보람과 의미를 느끼지 못하시는 분들, 하나님의 하시는 일을 이해할 수 없다고 생각되시는 분들은<br> 오십시오! 설교(說敎)에 자신이 없고 교육에도 의욕을 상실하신 분들은 반드시 참석하시기 바랍니다.</p>
				<p class="indent">■ 교 리--교리를 배워도 성경을 읽어 보면 모르는 것이 훨씬 더 많이 남아 있습니다.<br>■ 주 석--성경을 해석한 주석은 너무 방대하여 평생토록 한번도 독파하기 어렵습니다.<br>■ 신 학--신학이란 시대에 따라 변천하고 요동하며 좌로나 우로나 치우치고 있습니다.<br>■ 설 교--열심히 들어도 설교를 통해서 듣는 내용만으로는 평생을 들어도 미흡합니다.</p>
				<p>그러나 에스라성경강좌에 참석하시면 이 모든 미흡함이 충족 되고도 남습니다. 혼자서 평생을 연구한 것 보다 더 많은 것을 더 바르게 깨닫게 될 줄 믿습니다.</p>
				<div class="page_center_title">2017년도 에스라성경강좌</div>
								
				<!-- 연중집회일정 계획표  -->
				<div class="trainee_list">

<?php
$sql="select * from ez_meet order by em_no desc;";
$query=sql_query($sql);
?>
<table class="reference">
<thead>
<tr>
<th><input type="checkbox" name="" id="" /></th>
<th class="t_session_2 border-rad_l">회 기</th>
<th class="t_period_3">집회기간</th>
<th class="t_place_2">집회장소</th>
<th class="t_sum_2">강좌내용</th>
<th class="t_teacher_2">강 사</th>
<th class="t_period_2">신청기간</th>
<th class="t_phone_2 border-rad_r">문의전화</th>
<th class="t_phone_2 border-rad_r">상태</th>
</tr>
</thead>
<tbody>
<!-- 데이터 유무에 따라서 빈박스 처리  -->
<?php
while($list=sql_fetch_array($query))
{
echo "<tr><td>";
echo '<input type="checkbox" name="chk_seq[]" value="'.$list['em_no'].'"/>';
echo "</td><td>";
echo $list[em_lecture_no];
echo "</td><td>";
echo $list[em_lecture_st]." ~ ". $list[em_lecture_ed];
echo "</td><td>";
echo $list[em_place];
echo "</td><td>";
echo $list[em_lecture_contents];
echo "</td><td>";
echo $list[em_author];
echo "</td><td>";
echo $list[em_receipt_st]." ~ ".$list[em_receipt_ed];
echo "</td><td>";
echo $list[em_phone];

//echo $list[em_lecture_name];

//echo "</td><td>";
//echo "</td><td>";
//echo $list[em_datetime];
echo "</td><td>";
echo $list[em_status];
//echo "</td><td>";
echo "</td></tr>";
}
echo "</table>";
?>

  
 </body>
</html>
</section>
<?php
include_once('../common.php');
include_once "../theme/modificate/tail.php";
include_once "../theme/modificate/head.sub.php";
?>